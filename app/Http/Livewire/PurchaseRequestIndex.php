<?php

namespace App\Http\Livewire;

use App\Models\Material;
use App\Models\Production;
use App\Models\PurchaseRequest;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class PurchaseRequestIndex extends Component
{
    use WithPagination;
    public $search = '';
    public $showPage = 15;
    public $searchBy = 'purchase_request_code';
    public $orderAsc = true;

    public $showingMainPage = true;
    public $showingDetail = false;
    public $showingPR = false;

    // Tabel purchase requests
    public $productions_id, $purchase_request_code, $materials_id, $qty_ask, $description, $deadline, $categories_id, $measurements_id, $status_id, $users_id;

    public function render()
    {
        return view('livewire.purchase-request-index', [
            'purchaserequests' => PurchaseRequest::with('production','status')->search(trim($this->search))->orderBy($this->searchBy,$this->orderAsc ? 'asc' : 'desc')->paginate($this->showPage),
            'productions' =>Production::all(),
            'materials' =>Material::where('categories_id','=',1)->orWhere('categories_id','=','2')->get(),
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
        $this->showingPR = false;
    }

    public function createPRCode()
    {
        // Membuat kode PR
        $countPR = PurchaseRequest::count();
        if($countPR == 0) {
            $this->purchase_request_code = 'PR.' . 1001;
        } else {
            $getLastPR = PurchaseRequest::all()->last();
            $convertPR = (int)substr($getLastPR->purchase_request_code, -4) + 1;
            $this->purchase_request_code = 'LOGI.' . $convertPR;
        }
    }
    
    public function showPR()
    {
        $this->showingPR = true;

        $this->description = "Menunggu Pembelian";
        $this->createPRCode();
    }

    public function store()
    {
        PurchaseRequest::create([
            'productions_id' => $this->productions_id,
            'purchase_request_code' => $this->purchase_request_code,
            'materials_id' => $this->materials_id,
            'qty_ask' => $this->qty_ask,
            'description' => "Menunggu Pembelian",
            'deadline' => $this->deadline,
            'categories_id' => Material::where('id','=',$this->materials_id)->first('categories_id')->categories_id,
            'measurements_id' => Material::where('id','=',$this->materials_id)->first('measurements_id')->measurements_id,
            'status_id' => 1,
            'users_id' => Auth::user()->id,
        ]);

        $this->reset();
        $this->closeModal();

        $this->dispatchBrowserEvent('store-success');
    }

    public function approve($id)
    {
        PurchaseRequest::where('id', '=', $id)->update([
            'status_id' => 3,
            'description' => "Request Diterima",
        ]);
    }

    public function detail($id)
    {
        // Menampilkan detail page
        $this->showingDetail = true;
        $this->showingMainPage = false;

        // Menampilkan detail data pr
        // $this->purchaserequest = PurchaseRequest::findOrFail($id);
        // $this->rabps_id = $this->production->rabp['id'];
        // $this->purchase_request_code = $this->purchaserequest->purchase_request_code;
        // $this->name = $this->production->name;
        // $this->description = $this->production->description;
        // $this->deadline = $this->production->deadline;
        // $this->status_id = $this->production->status['name'];
        // $this->users_id = $this->production->users_id;
    }
}
