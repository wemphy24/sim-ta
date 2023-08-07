<?php

namespace App\Http\Livewire;

use App\Models\GoodReceive;
use App\Models\LogisticMaterial;
use App\Models\Material;
use App\Models\PurchaseOrder;
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

    public $getGRId, $getMaxReceive;

    // Assign ke tabel logistic materials
    public $logistic_code, $qty_received, $qty_order, $qty_accept;

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

    public function showApprove($id)
    {
        $this->showingReceived = true;
        $this->getGRId = $id;
        $this->qty_received = GoodReceive::where('id','=', $id)->first('qty')->qty;
        $this->getMaxReceive = GoodReceive::where('id','=', $id)->first('qty')->qty;
    }

    public function store()
    {
        
        // $getCategoryId = Material::where('id', '=', $this->getGRId)->first('categories_id')->categories_id;
        // $getMeasurementId = Material::where('id', '=', $this->getGRId)->first('measurements_id')->measurements_id;
        // $countBeforeStock = Material::where('id', '=', $this->getGRId)->first('stock')->stock;

        // Mendapatkan material id dari good receive yang akan di terima
        $getMaterialId = GoodReceive::where('id', '=', $this->getGRId)->first('materials_id')->materials_id;

        // Mengupdate data good receive setelah di approve oleh logistik
        GoodReceive::where('id', '=', $this->getGRId)->update([
            'qty' => GoodReceive::where('id', '=', $this->getGRId)->first('qty')->qty - $this->qty_received,
            'qty_accept' => GoodReceive::where('id', '=', $this->getGRId)->first('qty_accept')->qty_accept + $this->qty_received,
            'status_id' => 2,
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

        // Melakukan cek jika stok material lebih besar dari stok minimum pr_status akan "NULL"
        $minStockMaterial = Material::where('id','=',$getMaterialId)->first('min_stock')->min_stock;
        $stockMaterial = Material::where('id','=',$getMaterialId)->first('stock')->stock;

        if($stockMaterial >= $minStockMaterial)
        {
            Material::where('id', '=', $getMaterialId)->update([
                'pr_status' => NULL,
            ]);
        }

        $this->dispatchBrowserEvent('update-success');
        $this->closeModal();
    }

    public function completeGR($id)
    {
        GoodReceive::where('id', '=', $id)->update([
            'status_id' => 3,
        ]);

        // $getPOId = GoodReceive::where('id', '=', $id)->first('purchase_orders_id')->purchase_orders_id;
        // PurchaseOrder::where('id', '=', $getPOId)->update([
        //     'status_id' => 3,
        //     'description' => "Barang Diterima",
        // ]);
        
        $this->dispatchBrowserEvent('update-success');
        $this->closeModal();
    }
}
