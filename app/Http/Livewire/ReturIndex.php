<?php

namespace App\Http\Livewire;

use App\Models\Material;
use App\Models\RabpMaterial;
use App\Models\Retur;
use App\Models\SetBillMaterial;
use Livewire\Component;
use Livewire\WithPagination;

class ReturIndex extends Component
{
    use WithPagination;
    public $search = '';
    public $showPage = 15;
    public $searchBy = 'retur_code';
    public $orderAsc = true;

    public $showingMainPage = true;
    
    public function render()
    {
        return view('livewire.retur-index', [
            'returs' => Retur::with('good','material','status')->search(trim($this->search))->orderBy($this->searchBy,$this->orderAsc ? 'asc' : 'desc')->paginate($this->showPage),
        ])->layout('layouts.admin');
    }

    public function approve($id)
    {
        $getMaterialId = Retur::where('id','=',$id)->first('materials_id')->materials_id;
        $getFirstStock = Material::where('id','=',$getMaterialId)->first('stock')->stock;
        $updateReturStock = Retur::where('id','=',$id)->first('qty')->qty;

        // Mengupdate status retur
        Retur::where('id','=',$id)->update([
           'status_id' => 3
        ]);

        // Mengubah jumlah stok material karena mendapat dari retur
        Material::where('id','=',$getMaterialId)->update([
            'stock' => $getFirstStock + $updateReturStock,
        ]);

        // Mengubah status pada set bill material menjadi sudah retur
        RabpMaterial::where('materials_id','=',$getMaterialId)->update([
            'status' => "Sudah Retur",
        ]);

        $this->dispatchBrowserEvent('store-success');
    }
}
