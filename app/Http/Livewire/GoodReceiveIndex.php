<?php

namespace App\Http\Livewire;

use App\Models\GoodReceive;
use App\Models\LogisticMaterial;
use App\Models\Material;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class GoodReceiveIndex extends Component
{
    use WithPagination;
    public $search = '';
    public $showPage = 15;
    public $searchBy = 'good_receive_code';
    public $orderAsc = true;

    public $showingMainPage = true;
    public $showingReceived = false;

    public $getGRId;

    // Assign ke tabel logistic materials
    public $logistic_code, $qty_received;

    public function render()
    {
        return view('livewire.good-receive-index', [
            'goodreceives' => GoodReceive::with('supplier','material','status')->search(trim($this->search))->orderBy($this->searchBy,$this->orderAsc ? 'asc' : 'desc')->paginate($this->showPage),
        ])->layout('layouts.admin');
    }

    public function closeModal()
    {
        // Menutup received modal
        $this->showingReceived = false;
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

    public function showApprove($id)
    {
        $this->showingReceived = true;
        $this->getGRId = $id;
        $this->createLogisticCode();
    }

    public function store()
    {
        
        // $getCategoryId = Material::where('id', '=', $this->getGRId)->first('categories_id')->categories_id;
        // $getMeasurementId = Material::where('id', '=', $this->getGRId)->first('measurements_id')->measurements_id;
        // $countBeforeStock = Material::where('id', '=', $this->getGRId)->first('stock')->stock;

        // Mendapatkan material id dari good receive yang akan di terima
        $getMaterialId = GoodReceive::where('id', '=', $this->getGRId)->first('materials_id')->materials_id;
        // LogisticMaterial::create([
        //     'set_goods_id' => NULL,
        //     'logistic_code' => $this->logistic_code,
        //     'materials_id' => GoodReceive::where('id', '=', $this->getGRId)->first('materials_id')->materials_id,
        //     'qty_ask' => $this->qty_received,
        //     'qty_stock' => $countBeforeStock + $this->qty_received,
        //     'price' => GoodReceive::where('id', '=', $this->getGRId)->first('price')->price,
        //     'type' => "Barang Masuk",
        //     'categories_id' => $getCategoryId,
        //     'measurements_id' => $getMeasurementId,
        //     'users_id' => Auth::user()->id,
        //     'status_id' => 1,
        // ]);

        // Mengupdate data good receive setelah di approve oleh logistik
        GoodReceive::where('id', '=', $this->getGRId)->update([
            'qty' => GoodReceive::where('id', '=', $this->getGRId)->first('qty')->qty - $this->qty_received,
        ]);

        // Jika qty pada good receive 0 maka update status menjadi complete
        // if(GoodReceive::where('id', '=', $this->getGRId)->first('qty')->qty != 0)
        // {
        //     GoodReceive::where('id', '=', $this->getGRId)->update([
        //         'status_id' => 3,
        //     ]);
        // }
        
        // Mengupdate qty stok pada data logistic material karena telah menerima material dari approve GR
        // LogisticMaterial::where('materials_id', '=', $getMaterialId)->update([
        //     'qty_stock' => LogisticMaterial::where('materials_id', '=', $getMaterialId)->first('qty_stock')->qty_stock + $this->qty_received,
        // ]);

        // Mengupdate data material karena telah menerima material dari approve GR
        Material::where('id', '=', $getMaterialId)->update([
            'stock' => Material::where('id', '=', $getMaterialId)->first('stock')->stock + $this->qty_received,
        ]);

        $this->dispatchBrowserEvent('update-success');
        $this->closeModal();
    }

    public function approve2()
    {
        GoodReceive::where('id', '=', $this->getGRId)->update([
            'status_id' => 3,
        ]);
    }
}
