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
    public $search = '';
    public $showPage = 15;
    public $searchBy = 'name';
    public $orderAsc = true;

    public $showingInquiry = false;
    public $showingDetail = false;
    public $showingMainPage = true;

    use WithFileUploads;
    public $inquiry_code, $name, $inquiry_file, $purchase_order_file, $description, $date, $customers_id, $status_id, $users_id;
    public $inquiry;

    public function render()
    {
        return view('livewire.inquiry-index',[
            // 'inquiries' => Inquiry::latest()->paginate($this->showPage),
            'inquiries' => Inquiry::with('customer','status')->search(trim($this->search))->orderBy($this->searchBy,$this->orderAsc ? 'asc' : 'desc')->paginate($this->showPage),
            'customers' => Customer::all(),
        ])->layout('layouts.admin');
    }

    public function back()
    {
        // Menutup detail page dan menampilkan main page
        $this->showingDetail = false;
        $this->showingMainPage = true;
    }

    public function closeModal()
    {
        // Menutup inquiry modal
        $this->showingInquiry = false;
        $this->showingDetail = false;
    }

    public function createInquiryCode()
    {
        // Membuat kode inquiry
        $countInquiries = Inquiry::count();
        if($countInquiries == 0) {
            $this->inquiry_code = 'INQ.' . "0" . (Carbon::now()->day) . "." . (Carbon::now()->month) . "." . (Carbon::now()->year) . '.' . 1001;
        } else {
            $getLastInquiries = Inquiry::all()->last();
            $convertInquiries = (int)substr($getLastInquiries->inquiry_code, -4) + 1;
            $this->inquiry_code = 'INQ.' . "0" . (Carbon::now()->day) . "." . (Carbon::now()->month) . "." . (Carbon::now()->year) . '.' . $convertInquiries;
        }
    }

    public function showInquiry() 
    {
        // Menampilkan inquiry modal
        $this->reset();
        $this->showingInquiry = true;

        $this->date = Carbon::now()->format('Y-m-d');
        $this->createInquiryCode();
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

        // Store data inquiry
        Inquiry::create([
            'name' => $this->name,
            'inquiry_file' => $filename,
            'inquiry_code' => $this->inquiry_code,
            'description' => $this->description,
            'date' => $this->date,
            'customers_id' => $this->customers_id,
            'status_id' => 1,
            'users_id' => Auth::user()->id,
        ]);

        $this->reset();
        $this->showingInquiry = false;
        $this->dispatchBrowserEvent('store-success');
    }

    public function showDetail($id)
    {
         // Menampilkan detail page
        $this->showingDetail = true;
        $this->showingMainPage = false;

        // Mengambil data inquiry
        $this->inquiry = Inquiry::findOrFail($id);
        $this->inquiry_code = $this->inquiry->inquiry_code;
        $this->name = $this->inquiry->name;
        $this->description = $this->inquiry->description;
        $this->date = $this->inquiry->date;
        $this->customers_id = $this->inquiry->customers_id;
        $this->status_id = $this->inquiry->status['name'];
        $this->users_id = $this->inquiry->user['name'];
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

         // Mengupdate data inquiry
        $this->inquiry->update([
            'name' => $this->name,
            'inquiry_file' => $this->inquiry_file != NULL ?  $filenameInq : $this->inquiry->inquiry_file,
            'purchase_order_file' => $this->purchase_order_file != NULL ?  $filenamePO : $this->inquiry->purchase_order_file,
            'description' => $this->description,
        ]);

        $this->reset();
        $this->dispatchBrowserEvent('update-success');
    }

    public function doneInquiry()
    {
        // Mengubah status inquiry ke complete
        $this->inquiry->update([
            'status_id' => 3,
        ]);

        $this->reset();
        $this->dispatchBrowserEvent('update-success');
    }

    // public function deleteInquiry($id)
    // {
    //     $inquiry = Inquiry::find($id);
    //     $inquiry->delete();

    //     $this->dispatchBrowserEvent('delete-success');
    // }
}
