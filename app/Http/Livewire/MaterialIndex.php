<?php

namespace App\Http\Livewire;

use App\Models\BillMaterial;
use App\Models\Category;
use App\Models\Material;
use App\Models\Measurement;
use App\Models\PurchaseRequest;
use Livewire\Component;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class MaterialIndex extends Component
{
    use WithPagination;
    public $search = '';
    public $showPage = 15;
    public $searchBy = 'material_code';
    public $orderAsc = true;

    public $showingMaterialModal = false;
    public $showingRequest = false;
    public $showingChangePrice = false;
    public $isEditMode = false;
    public $categories_id, $measurements_id, $material_code, $name, $stock, $price, $old_price, $min_stock, $max_stock, $change_price, $price_approval;

    public $material, $getMaterialId;

    // Tabel purchase_request
    public $purchase_request_code,$stock_logistci, $qty_ask, $deadline;

    public function render()
    {
        return view('livewire.material-index', [
            'materials' => Material::with('category','measurement')->search(trim($this->search))->orderBy($this->searchBy,$this->orderAsc ? 'asc' : 'desc')->paginate($this->showPage),
            'categories' => Category::all(),
            'measurements' => Measurement::all(),
        ])->layout('layouts.admin');
    }

    public function showMaterialModal()
    {
        $this->reset();
        $this->showingMaterialModal = true;
    }

    public function closeModal()
    {
        $this->showingMaterialModal = false;
        $this->showingRequest = false;
        $this->showingChangePrice = false;
    }

    public function storeMaterial()
    {
        Material::create([
            'categories_id' => $this->categories_id,
            'measurements_id' => $this->measurements_id,
            'material_code' => $this->material_code,
            'name' => $this->name,
            'stock' => $this->stock,
            'price' => $this->price,
            'min_stock' => $this->min_stock,
            'max_stock' => $this->max_stock,
        ]);

        $this->reset();
        $this->closeModal();

        $this->dispatchBrowserEvent('store-success');
    }

    public function showChangePrice($id)
    {
        $this->showingChangePrice = true;
        $this->material = Material::findOrFail($id);
        $this->change_price = Material::where('id','=', $id)->first('change_price')->change_price;
        $this->price_approval = Material::where('id','=', $id)->first('price_approval')->price_approval;
    }

    public function storeChangePrice()
    {
        Material::where('id', '=', $this->material->id)->update([
            'change_price' => $this->change_price,
            'price_approval' => "Need Approve",
        ]);

        $this->reset();
        $this->closeModal();

        $this->dispatchBrowserEvent('store-success');
    }

    public function approve()
    {
        $getOldPrice = Material::where('id', '=', $this->material->id)->first('price')->price;
        Material::where('id', '=', $this->material->id)->update([
            'change_price' => $this->change_price,
            'price_approval' => NULL,
            'old_price' => $getOldPrice,
            'price' => $this->change_price,
        ]);

        // Update bill material/set barang
        BillMaterial::where('materials_id','=',$this->material->id)->update([
            'price' => $this->change_price,
            'total_price' => $this->change_price * BillMaterial::where('materials_id','=',$this->material->id)->first('qty')->qty,
        ]);

        $this->reset();
        $this->closeModal();

        $this->dispatchBrowserEvent('store-success');
    }

    public function showMaterialEditModal($id)
    {
        $this->material = Material::findOrFail($id);
        $this->categories_id = $this->material->category['id'];
        $this->measurements_id = $this->material->measurement['id'];
        $this->material_code = $this->material->material_code;
        $this->name = $this->material->name;
        $this->stock = $this->material->stock;
        $this->price = $this->material->price;
        $this->min_stock = $this->material->min_stock;
        $this->max_stock = $this->material->max_stock;

        $this->showingMaterialModal = true;
        $this->isEditMode = true;
    }

    public function updateMaterial()
    {
        // dd($this->material->id);
        $this->material->update([
            'categories_id' => $this->categories_id,
            'measurements_id' => $this->measurements_id,
            'material_code' => $this->material_code,
            'name' => $this->name,
            'stock' => $this->stock,
            'price' => $this->price,
            'min_stock' => $this->min_stock,
            'max_stock' => $this->max_stock,
        ]);

        // Update bill material/set barang
        BillMaterial::where('materials_id','=',$this->material->id)->update([
            'price' => $this->price,
            'total_price' => $this->price * BillMaterial::where('materials_id','=',$this->material->id)->first('qty')->qty,
        ]);

        $this->reset();
        $this->closeModal();

        $this->dispatchBrowserEvent('update-success');
    }

    public function deleteMaterial($id)
    {
        $material = Material::find($id);
        $material->delete();

        $this->dispatchBrowserEvent('delete-success');
    }

    public function showRequest($id) 
    {
        $this->getMaterialId = $id;
        $this->showingRequest = true;
        $this->qty_ask = Material::where('id','=',$id)->first('max_stock')->max_stock - Material::where('id','=',$id)->first('stock')->stock;
    }

    public function createPRCode() 
    {
        // Membuat kode PR
        $countPR = PurchaseRequest::count();
        if($countPR == 0) {
            $this->purchase_request_code = 'PR.' . "0" . (Carbon::now()->day) . "." . (Carbon::now()->month) . "." . (Carbon::now()->year) . '.' . 1001;
        } else {
            $getLastPR = PurchaseRequest::all()->last();
            $convertPR = (int)substr($getLastPR->purchase_request_code, -4) + 1;
            $this->purchase_request_code = 'PR.' . "0" . (Carbon::now()->day) . "." . (Carbon::now()->month) . "." . (Carbon::now()->year) . '.' . $convertPR;
        }
    }

    public function requestPR()
    {
        $this->createPRCode();

        PurchaseRequest::create([
            'purchase_request_code' => $this->purchase_request_code,
            'materials_id' => $this->getMaterialId,
            'stock_logistic' => Material::where('id','=', $this->getMaterialId)->first('stock')->stock,
            'qty_ask' => $this->qty_ask,
            'description' => "Meminta Request",
            'deadline' => $this->deadline,
            'categories_id' => Material::where('id','=', $this->getMaterialId)->first('categories_id')->categories_id,
            'measurements_id' => Material::where('id','=', $this->getMaterialId)->first('measurements_id')->measurements_id,
            'status_id' => 1,
            'users_id' => Auth::user()->id,
        ]);

        Material::where('id','=', $this->getMaterialId)->update([
            'pr_status' => "PO Berhasil",
        ]);

        $this->closeModal();
        $this->dispatchBrowserEvent('store-success');
    }

    public function updated($key, $value)
    {
        // Realtime update value
        $countMaterial = Material::count();
        $getLastMaterialCode = Material::all()->last();

        if($this->categories_id == 3) {
            $this->price = 0;
            $this->stock = 0;
            $this->min_stock = 0;
            $this->max_stock = 0;
        }

        if($countMaterial == 0) {
            if($this->categories_id == 1) {
                $this->material_code = "BB.00" . 1;
            } else if($this->categories_id == 2) {
                $this->material_code = "BP.00" . 1;
            } else if($this->categories_id == 3){
                $this->material_code = "BJ.00" . 1;
            }
        } else {
            if($this->categories_id == 1) {
                $this->material_code = "BB.00" . (int)substr($getLastMaterialCode->material_code, -2) + 1;
            } else if($this->categories_id == 2) {
                $this->material_code = "BP.00" . (int)substr($getLastMaterialCode->material_code, -2) + 1;
            } else if($this->categories_id == 3) {
                $this->material_code = "BJ.00" . (int)substr($getLastMaterialCode->material_code, -2) + 1;
            }
        } 
    }
}
