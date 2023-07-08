<?php

namespace App\Http\Livewire;

use Livewire\WithFileUploads;
use App\Models\Customer;
use App\Models\Inquiry;
use App\Models\Quotation;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class QuotationIndex extends Component
{
    use WithPagination;
    public $search = '';
    public $showPage = 15;
    public $searchBy = 'quotation_code';
    public $orderAsc = true;

    public $showingQuotation = false;
    public $showingDetail = false;
    public $showingMainPage = true;

    use WithFileUploads;
    public $inquiries_id, $quotation_code, $name, $quotation_file, $project, $location,$date, $customers_id, $users_id, $status_id;   
    public $quotation;
    
    public function render()
    {
        return view('livewire.quotation-index', [
            'quotations' => Quotation::with('customer','status')->search(trim($this->search))->orderBy($this->searchBy,$this->orderAsc ? 'asc' : 'desc')->paginate($this->showPage),
            'customers' => Customer::all(),
            'inquiries' => Inquiry::where('status_id','=',1)->get(),
        ])->layout('layouts.admin');
    }

    public function back()
    {
        // Menutup detail page dan menampilkan main page
        $this->showingMainPage = true;
        $this->showingDetail = false;
    }

    public function closeModal()
    {
        // Menutup quotation modal
        $this->showingQuotation = false;
        $this->showingDetail = false;
    }

    public function createQuotationCode()
    {
        // Membuat kode quotation
        $countQuotations = Quotation::count();
        if($countQuotations == 0) {
            $this->quotation_code = 'QO.' . "0" . (Carbon::now()->day) . "." . (Carbon::now()->month) . "." . (Carbon::now()->year) . '.' . 1001;
        } else {
            $getLastQuotations = Quotation::all()->last();
            $convertQuotations = (int)substr($getLastQuotations->quotation_code, -4) + 1;
            $this->quotation_code = 'QO.' . "0" . (Carbon::now()->day) . "." . (Carbon::now()->month) . "." . (Carbon::now()->year) . '.' . $convertQuotations;
        }
    }

    public function showQuotation()
    {
        // Menampilkan quotation modal
        $this->reset();
        $this->showingQuotation = true;

        $this->createQuotationCode();
        $this->date = Carbon::now()->format('Y-m-d');
    }

    public function storeQuotation()
    {
        // Store data inquiry
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

        Inquiry::where('id','=', $this->inquiries_id)->update([
            'status_id' => 2,
        ]);

        $this->reset();
        $this->closeModal();

        $this->dispatchBrowserEvent('store-success');
    }

    public function showDetail($id)
    {
        // Menampilkan detail page
        $this->showingDetail = true;
        $this->showingMainPage = false;

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
        // Cek jika quotation_file NOT NULL dan tidak sama dengan PATHFILE
        if (!empty($this->quotation_file)) {
            $filenameQuo = $this->quotation_file->getClientOriginalName();
            $this->quotation_file->storeAs('public/quotation', $filenameQuo);
        } 

        // Mengupdate data quotation
        $this->quotation->update([
            'name' => $this->name,
            'quotation_file' => $this->quotation_file != NULL ?  $filenameQuo : $this->quotation->quotation_file,
            'project' => $this->project,
            'date' => $this->date,
            'location' => $this->location,
        ]);

        $this->reset();
        $this->closeModal();

        $this->dispatchBrowserEvent('update-success');
    }

    public function approve()
    {
        $this->quotation->update([
            'status_id' => 2,
        ]);

        $this->reset();
        $this->dispatchBrowserEvent('update-success');
    }

    public function completeQO()
    {
        $this->quotation->update([
            'status_id' => 3,
        ]);

        $this->reset();
        $this->dispatchBrowserEvent('update-success');
    }

    // public function deleteQuotation($id) 
    // {
    //     $quotation = Quotation::find($id);
    //     $quotation->delete();

    //     $this->dispatchBrowserEvent('delete-success');
    // }

    public function updated($key, $value)
    {
        if($this->inquiries_id !=NULL) {
            $this->name = "Penawaran " . substr(Inquiry::where('id','=',$this->inquiries_id)->first('name')->name, 11);
        } else {
            $this->name = NULL;
        }

        // Realtime update value
        if($this->inquiries_id != NULL) {
            $this->customers_id = Inquiry::where('id','=',$this->inquiries_id)->first(['customers_id'])->customers_id;
        } else {
            $this->customers_id = NULL;
        }
    }
}
