<?php

namespace App\Http\Livewire;

use App\Models\Good;
use App\Models\LogisticGood;
use App\Models\Material;
use App\Models\SetBillMaterial;
use Livewire\Component;
use Livewire\WithPagination;

class LogisticGoodIndex extends Component
{
    use WithPagination;
    public $search = '';
    public $showPage = 15;
    public $searchBy = 'logistic_good_code';
    public $orderAsc = true;

    public $showingMainPage = true;

    public function render()
    {
        return view('livewire.logistic-good-index', [
            'logistics' => LogisticGood::with('good','status')->search(trim($this->search))->orderBy($this->searchBy,$this->orderAsc ? 'asc' : 'desc')->paginate($this->showPage),
        ])->layout('layouts.admin');
    }

    public function approve($id)
    {
        // Mengambil id material
        // $getMaterialId = LogisticGood::where('id', '=', $id)->first('materials_id')->materials_id; ////
        $getGoodId = LogisticGood::where('id', '=', $id)->first('goods_id')->goods_id;

        // Menambah data set bill material setelah di approve oleh logistik
        // SetBillMaterial::where('materials_id', '=', $getMaterialId)->update([
        //     'qty_received' => LogisticGood::where('materials_id', '=', $id)->first('qty_ask')->qty_ask,
        //     'status' => "Sudah Diambil",
        // ]);

        // Update status logistic material
        LogisticGood::where('id', '=', $id)->update([
            'status_id' => 3,
            'qty_stock' => LogisticGood::where('id', '=', $id)->first('qty_stock')->qty_stock + LogisticGood::where('id', '=', $id)->first('qty_ask')->qty_ask,
        ]);

        // Menambah stok pada master data
        // Material::where('id', '=', $getMaterialId)->update([
        //     'stock' => (Material::where('id', '=', $getMaterialId)->first('stock')->stock) + (LogisticGood::where('materials_id', '=', $getMaterialId)->first('qty_ask')->qty_ask),
        //     'price' => LogisticGood::where('materials_id', '=', $getMaterialId)->first('price')->price,
        // ]); //////

        // Menambah stok pada master data
        Good::where('id','=',$getGoodId)->update([
            'stock' => Good::where('id','=',$getGoodId)->first('stock')->stock + LogisticGood::where('id', '=', $id)->first('qty_ask')->qty_ask,
        ]);

        $this->dispatchBrowserEvent('store-success');
    }
}
