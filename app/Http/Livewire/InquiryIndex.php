<?php

namespace App\Http\Livewire;

use Livewire\WithFileUploads;
use App\Models\Customer;
use App\Models\Inquiry;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class InquiryIndex extends Component
{
    use WithPagination;
    public $search;
    public $showPage;

    public $showingInquiryModal = false;
    public $showingDetailInquiryModal = false;
    public $isEditMode = false;

    use WithFileUploads;
    public $name, $inquiry_file, $purchase_order_file, $description, $date, $customers_id, $status_id, $users_id;
    public $inquiry;

    public function mount()
    {
        $this->showPage = 15;
    }

    public function render()
    {
        return view('livewire.inquiry-index',[
            'inquiries' => Inquiry::latest()->paginate($this->showPage),
            'customers' => Customer::all(),
        ])->layout('layouts.admin');
    }

    public function closeModal()
    {
        $this->showingInquiryModal = false;
        $this->showingDetailInquiryModal = false;
    }

    public function showInquiryModal() 
    {
        $this->reset();
        $this->showingInquiryModal = true;
        $this->date = Carbon::now()->format('Y-m-d');
        $this->description = "Request Penawaran";
    }

    public function storeInquiry()
    {
        $this->validate([
            'name' => 'required|string|max:60',
            'inquiry_file' => 'required|mimes:pdf,png,jpg,jpeg',
            'description' => 'required',
            'date' => 'required|date',
            'customers_id' => 'required',
        ]);

        $filename = $this->inquiry_file->getClientOriginalName();
        if(!empty($this->inquiry_file)) {
            $this->inquiry_file->storeAs('public/inquiry', $filename);
        } 

        Inquiry::create([
            'name' => $this->name,
            'inquiry_file' => $filename,
            'description' => $this->description,
            'date' => $this->date,
            'customers_id' => $this->customers_id,
            'status_id' => 1,
            'users_id' => Auth::user()->id,
        ]);

        $this->reset();
        $this->showingInquiryModal = false;
        $this->dispatchBrowserEvent('store-success');
    }

    public function showInquiryEditModal($id)
    {
        $this->showingInquiryModal = true;
        $this->isEditMode = true;

        $this->inquiry = Inquiry::findOrFail($id);
        $this->name = $this->inquiry->name;
        // $this->inquiry_file = $this->inquiry->inquiry_file;
        // $this->purchase_order_file = $this->inquiry->purchase_order_file;
        $this->description = $this->inquiry->description;
        $this->date = $this->inquiry->date;
        $this->customers_id = $this->inquiry->customers_id;
    }

    public function updateInquiry()
    {
        $this->validate([
            'name' => 'required|string|max:60',
            'description' => 'required',
            'date' => 'required|date',
            'customers_id' => 'required',
        ]);

        // Cek jika inquiry_file NOT NULL dan tidak sama dengan PATHFILE
        if (!empty($this->inquiry_file)) {
            $filenameInq = $this->inquiry_file->getClientOriginalName();
            $this->inquiry_file->storeAs('public/inquiry', $filenameInq);
        } 
        // Cek jika purchase_order_file NOT NULL dan tidak sama dengan PATHFILE
        else if (!empty($this->purchase_order_file)) {
            $filenamePO = $this->purchase_order_file->getClientOriginalName();
            $this->purchase_order_file->storeAs('public/purchaseorder', $filenamePO);
        }

        $this->inquiry->update([
            'name' => $this->name,
            'inquiry_file' => $this->inquiry_file != NULL ?  $filenameInq : $this->inquiry->inquiry_file,
            'purchase_order_file' => $this->purchase_order_file != NULL ?  $filenamePO : $this->inquiry->purchase_order_file,
            'description' => $this->description,
        ]);

        $this->showingInquiryModal = false;
        $this->dispatchBrowserEvent('update-success');
    }

    public function detailInquiry($id)
    {
        $this->inquiry = Inquiry::findOrFail($id);
        $this->name = $this->inquiry->name;
        $this->inquiry_file = $this->inquiry->inquiry_file;
        $this->purchase_order_file = $this->inquiry->purchase_order_file;
        $this->description = $this->inquiry->description;
        $this->date = $this->inquiry->date;
        $this->customers_id = $this->inquiry->customer['name'];
        $this->status_id = $this->inquiry->status['name'];
        $this->users_id = $this->inquiry->user['name'];

        $this->showingDetailInquiryModal = true;
    }

    public function deleteInquiry($id)
    {
        $inquiry = Inquiry::find($id);
        $inquiry->delete();

        $this->dispatchBrowserEvent('delete-success');
    }
}
