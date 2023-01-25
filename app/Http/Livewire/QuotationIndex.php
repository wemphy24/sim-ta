<?php

namespace App\Http\Livewire;

use App\Models\Customer;
use App\Models\BudgetPlanCost;
use App\Models\Inquiry;
use App\Models\Quotation;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class QuotationIndex extends Component
{
    use WithPagination;
    public $search;
    public $showPage;

    public $showingQuotationModal = false;
    public $showingDetailQuotationModal = false;
    public $isEditMode = false;
    public $inquiries_id, $quotation_code, $name, $project, $location, $customers_id, $users_id, $status_id;   

    public $budget_plan_code;

    public $quotation;
    public $currentDate;

    public function mount()
    {
        // Set default value untuk fitur tampilkan halaman
        $this->showPage = 5;
    }
    
    public function render()
    {
        return view('livewire.quotation-index', [
            'quotations' => Quotation::where('quotation_code', 'like', '%'.$this->search.'%')
                        ->orWhere('name', 'like', '%'.$this->search.'%')->orWhere('project', 'like', '%'.$this->search.'%')
                        ->orWhere('date', 'like', '%'.$this->search.'%')->latest()->paginate($this->showPage),
            'customers' => Customer::all(),
            'inquiries' => Inquiry::all(),
        ])->layout('layouts.admin');
    }

    public function closeModal()
    {
        $this->showingQuotationModal = false;
        $this->showingDetailQuotationModal = false;
    }

    public function showQuotationModal()
    {
        $this->reset();
        $this->showingQuotationModal = true;
        $this->currentDate = Carbon::now()->format('Y-m-d');

        // Membuat kode penawaran
        $countQO = Quotation::count();
        $getTimeNow = Carbon::now();
        if($countQO == 0) {
            $this->quotation_code = 'QO.' . "0" . ($getTimeNow->day) . "." . ($getTimeNow->month) . "." . ($getTimeNow->year) . '.' . 1001;
        } else {
            $getLastQO = Quotation::all()->last();
            $convertQO = (int)substr($getLastQO->quotation_code, -4) + 1;
            $this->quotation_code = 'QO.' . "0" . ($getTimeNow->day) . "." . ($getTimeNow->month) . "." . ($getTimeNow->year) . '.' . $convertQO;
        }

        // Membuat kode RABP
        // $countRabp = BudgetPlanCost::count();
        // $getTimeNow = Carbon::now();
        // if($countRabp == 0) {
        //     $this->budget_plan_code = 'RABP.' . ($getTimeNow->day) . ".0" . ($getTimeNow->month) . "." . ($getTimeNow->year) . '.' . 1001;
        // } else {
        //     $getLastRabp = BudgetPlanCost::all()->last();
        //     $convertRabp = (int)substr($getLastRabp->budget_plan_code, -4) + 1;
        //     $this->budget_plan_code = 'RABP.' . ($getTimeNow->day) . ".0" . ($getTimeNow->month) . "." . ($getTimeNow->year) . '.' . $convertRabp;
        // }
    }

    public function storeQuotation()
    {
        // Memasukkan data ke dalam 2 tabel sekaligus, $getQuotationId digunakan untuk mendapat id quotation, dan otomatis di assign ke quotations_id pada tabel budget_plans 
        DB::transaction(function () {
            $getQuotationId = Quotation::create([
                'inquiries_id' => $this->inquiries_id,
                'quotation_code' => $this->quotation_code,
                'name' => $this->name,
                'project' => $this->project,
                // Ambil tanggal sekarang dari method showQuotationModal
                'date' => $this->currentDate,
                'location' => $this->location,
                'customers_id' => $this->customers_id,
                'status_id' => 1,
                'users_id' => Auth::user()->id,
            ]);

            // BudgetPlanCost::create([
            //     'quotations_id' => $getQuotationId->id,
            //     'budget_plan_code' => $this->budget_plan_code,
            //     'budget_cost_code' => NULL,
            //     'description' => 'Menunggu pembuatan RABP',
            //     // Ambil tanggal sekarang dari method showQuotationModal
            //     'date' => $this->currentDate,
            //     'status_id' => 1,
            //     'users_id' => Auth::user()->id,
            // ]);
        });

        $this->reset();
        $this->closeModal();

        $this->dispatchBrowserEvent('store-success');
    }

    public function showQuotationEditModal($id)
    {
        $this->quotation = Quotation::findOrFail($id);
        $this->quotation_code = $this->quotation->quotation_code;
        $this->name = $this->quotation->name;
        $this->project = $this->quotation->project;
        $this->currentDate = $this->quotation->date;
        $this->location = $this->quotation->location;
        $this->customers_id = $this->quotation->customers_id;

        $this->showingQuotationModal = true;
        $this->isEditMode = true;
    }

    public function updateQuotation()
    {
        $this->quotation->update([
            'name' => $this->name,
            'project' => $this->project,
            'date' => $this->currentDate,
            'location' => $this->location,
        ]);

        $this->reset();
        $this->closeModal();

        $this->dispatchBrowserEvent('update-success');
    }

    public function updated($key, $value)
    {
        // Realtime update value
        if($this->inquiries_id != NULL) {
            $this->customers_id = Inquiry::where('id','=',$this->inquiries_id)->first(['customers_id'])->customers_id;
        } else {
            $this->customers_id = NULL;
        }
    }

    public function detailQuotation($id)
    {
        $this->quotation = Quotation::findOrFail($id);
        $this->inquiries_id = $this->quotation->inquiry['name'];
        $this->quotation_code = $this->quotation->quotation_code;
        $this->name = $this->quotation->name;
        $this->project = $this->quotation->project;
        $this->currentDate = $this->quotation->date;
        $this->location = $this->quotation->location;
        $this->status_id = $this->quotation->status['name'];
        $this->customers_id = $this->quotation->customer['name'];
        $this->users_id = $this->quotation->user['name'];

        $this->showingDetailQuotationModal = true;
    }

    public function deleteQuotation($id) 
    {
        $quotation = Quotation::find($id);
        $quotation->delete();

        $this->dispatchBrowserEvent('delete-success');
    }
}
