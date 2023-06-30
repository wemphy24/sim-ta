<?php

namespace App\Http\Livewire;

use App\Models\Contract;
use App\Models\Delivery;
use App\Models\DetailRabp;
use App\Models\LogisticMaterial;
use App\Models\Material;
use App\Models\Rabp;
use App\Models\SetGood;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class DeliveryIndex extends Component
{
    use WithPagination;
    public $search = '';
    public $showPage = 15;
    public $searchBy = 'delivery_code';
    public $orderAsc = true;

    public $showingMainPage = true;
    public $showingDetail = false;
    public $showingDelivery = false;

    public $delivery_code, $rabps_id, $name, $contracts_id, $description, $send_date, $received_date, $status_id;
    public $delivery;

    public $logistic_code;
    
    public function render()
    {
        return view('livewire.delivery-index', [
            'deliverys' => Delivery::with('contract','status')->search(trim($this->search))->orderBy($this->searchBy,$this->orderAsc ? 'asc' : 'desc')->paginate($this->showPage),
            'detailrabps' => DetailRabp::where('rabps_id','=',$this->rabps_id)->get(),
            'contracts' => Contract::all(),
            'rabps' => Rabp::all(),
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
        // Menutup delivery modal
        $this->showingDelivery = false;
    }

    public function createDeliveryCode()
    {
        // Membuat kode pengiriman
        $countDelivery = Delivery::count();
        if($countDelivery == 0) {
            $this->delivery_code = 'DELIVERY.' . 1001;
        } else {
            $getLastDel = Delivery::all()->last();
            $convertDel = (int)substr($getLastDel->delivery_code, -4) + 1;
            $this->delivery_code = 'DELIVERY.' . $convertDel;
        }
    }

    public function showDelivery()
    {
        $this->showingDelivery = true;
        $this->createDeliveryCode();
        $this->send_date = Carbon::now()->format('Y-m-d');
        $this->description = "Menunggu Pengiriman";
    }

    public function store()
    {
        Delivery::create([
            'contracts_id' => $this->contracts_id,
            'rabps_id' => $this->rabps_id,
            'delivery_code' => $this->delivery_code,
            'name' => $this->name,
            'description' => $this->description,
            'send_date' => $this->send_date,
            'received_date' => NULL,
            'status_id' => 1,
            'users_id' => Auth::user()->id,
        ]);

        $this->reset();
        $this->closeModal();

        $this->dispatchBrowserEvent('store-success');
    }

    // DETAILS SECTION --------------------------------
    public function detail($id)
    {
        // Menampilkan detail page
        $this->showingDetail = true;
        $this->showingMainPage = false;

        $this->delivery = Delivery::findOrFail($id);
        $this->delivery_code = $this->delivery->delivery_code;
        $this->rabps_id = $this->delivery->rabps_id;
        $this->name = $this->delivery->name;
        $this->contracts_id = $this->delivery->contracts_id;
        $this->description = $this->delivery->description;
        $this->send_date = $this->delivery->send_date;
        $this->received_date = $this->delivery->received_date;
        $this->status_id = $this->delivery->status['name'];
    }
    // END --------------------------------

    public function update()
    {
        $this->delivery->update([
            'name' => $this->name,
        ]);

        $this->reset();
        $this->dispatchBrowserEvent('store-success');
    }

    public function createLogisticCode()
    {
        // Membuat kode logistik
        $countLogistic = LogisticMaterial::count();
        if($countLogistic == 0) {
            $this->logistic_code = 'LOGI.' . 1001;
        } else {
            $getLastLog = LogisticMaterial::all()->last();
            $convertLog = (int)substr($getLastLog->logistic_code, -4) + 1;
            $this->logistic_code = 'LOGI.' . $convertLog;
        }
    }
    
    public function approve()
    {
        $this->delivery->update([
            'status_id' => 2,
        ]);

        $this->reset();
        $this->dispatchBrowserEvent('store-success');
    }

    public function updateStatus()
    {
        $this->delivery->update([
            'status_id' => 3,
            'received_date' => Carbon::now()->format('Y-m-d'),
        ]);

        $this->reset();
        $this->dispatchBrowserEvent('store-success');
    }

    public function printLogistic($id)
    {
        $this->createLogisticCode();

        $getMaterialName = SetGood::where('id','=',$id)->first('name')->name;
        $getMaterialId = Material::where('name','=',$getMaterialName)->first('id')->id;

        // dd(SetGood::where('name', '=', $getMaterialName)->first('price')->price);

        LogisticMaterial::create([
            'set_goods_id' => $id,
            'logistic_code' => $this->logistic_code,
            'materials_id' => $getMaterialId,
            'qty_ask' => SetGood::where('name', '=', $getMaterialName)->first('qty')->qty,
            'qty_stock' => Material::where('id', '=', $getMaterialId)->first('stock')->stock,
            'price' => SetGood::where('name', '=', $getMaterialName)->first('price')->price,
            'type' => "Barang Keluar",
            'categories_id' => 3,
            'measurements_id' => 3,
            'status_id' => 1,
            'users_id' => Auth::user()->id,
        ]);

        SetGood::where('id','=',$id)->update([
            'status_delivery' => "Sedang Diambil"
        ]);

        $this->dispatchBrowserEvent('store-success');
    }
}
