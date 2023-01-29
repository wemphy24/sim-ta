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
    public $search = '';
    public $showPage = 15;
    public $searchBy = 'quotation_code';
    public $orderAsc = true;

    public $showingQuotationModal = false;
    public $showingDetailModal = false;
    public $showingMainPage = true;
    public $isEditMode = false;
    public $inquiries_id, $quotation_code, $name, $project, $location, $customers_id, $users_id, $status_id;   

    public $quotation;

    public $date;

    // public function mount()
    // {
    //     // Set default value untuk fitur tampilkan halaman
    //     $this->showPage = 5;
    // }
    
    public function render()
    {
        return view('livewire.quotation-index', [
            'quotations' => Quotation::with('customer','status')->search(trim($this->search))->orderBy($this->searchBy,$this->orderAsc ? 'asc' : 'desc')->paginate($this->showPage),
            'customers' => Customer::all(),
            'inquiries' => Inquiry::all(),
        ])->layout('layouts.admin');
    }

    public function back()
    {
        $this->showingMainPage = true;
        $this->showingDetailModal = false;
    }

    public function closeModal()
    {
        $this->showingQuotationModal = false;
        $this->showingDetailModal = false;
    }

    public function createQuotationCode()
    {
        $countQuotations = Quotation::count();
        if($countQuotations == 0) {
            $this->quotation_code = 'QO.' . "0" . (Carbon::now()->day) . "." . (Carbon::now()->month) . "." . (Carbon::now()->year) . '.' . 1001;
        } else {
            $getLastQuotations = Quotation::all()->last();
            $convertQuotations = (int)substr($getLastQuotations->quotation_code, -4) + 1;
            $this->quotation_code = 'QO.' . "0" . (Carbon::now()->day) . "." . (Carbon::now()->month) . "." . (Carbon::now()->year) . '.' . $convertQuotations;
        }
    }

    public function showQuotationModal()
    {
        $this->reset();
        $this->showingQuotationModal = true;

        $this->createQuotationCode();
        $this->date = Carbon::now()->format('Y-m-d');
    }

    public function storeQuotation()
    {
        Quotation::create([
            'inquiries_id' => $this->inquiries_id,
            'quotation_code' => $this->quotation_code,
            'name' => $this->name,
            'project' => $this->project,
            'date' => $this->date,
            'location' => $this->location,
            'customers_id' => $this->customers_id,
            'status_id' => 1,
            'users_id' => Auth::user()->id,
        ]);

        $this->reset();
        $this->closeModal();

        $this->dispatchBrowserEvent('store-success');
    }

    public function detailQuotation($id)
    {
        $this->showingDetailModal = true;
        $this->showingMainPage = false;
        $this->isEditMode = true;

        $this->quotation = Quotation::findOrFail($id);
        $this->inquiries_id = $this->quotation->inquiry['id'];
        $this->quotation_code = $this->quotation->quotation_code;
        $this->name = $this->quotation->name;
        $this->project = $this->quotation->project;
        $this->date = $this->quotation->date;
        $this->location = $this->quotation->location;
        $this->customers_id = $this->quotation->customer['id'];
        $this->status_id = $this->quotation->status['name'];
        $this->users_id = $this->quotation->user['name'];
    }

    public function updateQuotation()
    {
        $this->quotation->update([
            'name' => $this->name,
            'project' => $this->project,
            'date' => $this->date,
            'location' => $this->location,
        ]);

        $this->reset();
        $this->closeModal();

        $this->dispatchBrowserEvent('update-success');
    }

    public function deleteQuotation($id) 
    {
        $quotation = Quotation::find($id);
        $quotation->delete();

        $this->dispatchBrowserEvent('delete-success');
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
}
