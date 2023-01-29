<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\DetailRabp;
use App\Models\Material;
use App\Models\Measurement;
use App\Models\SetBillMaterial;
use App\Models\SetGood;
use Livewire\Component;
use Livewire\WithPagination;

class SetGoodIndex extends Component
{
    use WithPagination;
    public $search = '';
    public $showPage = 15;
    public $searchBy = 'set_goods_code';
    public $orderAsc = true;
    
    public $showingSetGoodModal = false;
    public $showingDetailModal = false;
    public $showingMainPage = true;

    public $isEditMode = false;

    public $categories_id, $measurements_id, $set_goods_code, $name, $qty, $price;
    public $set_good;

    public $set_goods_id, $materials_id, $qty_bm, $price_bm, $total_price_bm;
    public $set_bill;
    public $good_name;

    // public function mount()
    // {
    //     $this->showPage = 5;
    // }

    public function render()
    {
        return view('livewire.set-good-index', [
            // 'set_goods' => SetGood::latest()->paginate($this->showPage),
            'set_goods' => SetGood::with('category','measurement')->search(trim($this->search))->orderBy($this->searchBy,$this->orderAsc ? 'asc' : 'desc')->paginate($this->showPage),
            'materials' => Material::where('categories_id','=',3)->get(),
            'material_bms' => Material::where('categories_id','=',1)->orWhere('categories_id','=','2')->get(),
            'categories' => Category::all(),
            'measurements' => Measurement::all(),
            'set_bill_materials' => SetBillMaterial::where('set_goods_id','=',$this->set_goods_id)->get(),
        ])->layout('layouts.admin');
    }

    public function closeModal()
    {
        $this->showingSetGoodModal = false;
        $this->showingDetailModal = false;
    }

    public function back()
    {
        $this->showingDetailModal = false;
        $this->showingMainPage = true;
    }

    // SET GOOD
    public function createSetGoodCode() 
    {
        $countSetGoods = SetGood::count();
        if($countSetGoods == 0) {
            $this->set_goods_code = 'SG.' . 1001;
        } else {
            $getLastSetGoods = SetGood::all()->last();
            $convertSetGoods = (int)substr($getLastSetGoods->set_goods_code, -4) + 1;
            $this->set_goods_code = 'SG.' . $convertSetGoods;
        }
    }

    public function showSetGood() 
    {
        $this->reset();
        $this->showingSetGoodModal = true;

        $this->createSetGoodCode();
        $this->qty = 1;
        $this->price = 0;
    }

    public function storeSetGood()
    {
        $this->validate([
            'set_goods_code' => 'required|string',
            'name' => 'required',
            'categories_id' => 'required',
            'qty' => 'required|integer',
            'measurements_id' => 'required',
            'price' => 'required|integer',
        ]);

        SetGood::create([
            'categories_id' => $this->categories_id,
            'measurements_id' => $this->measurements_id,
            'set_goods_code' => $this->set_goods_code,
            'name' => $this->name,
            'qty' => $this->qty,
            'price' => $this->price,
        ]);
        
        $this->reset();
        $this->closeModal();
        $this->dispatchBrowserEvent('store-success');
    }

    // public function showEditGood($id)
    // {
    //     $this->showingSetGoodModal = true;
    //     // $this->isEditMode = true; ---
    //     $this->showingMainPage = false;

    //     $this->set_good = SetGood::findOrFail($id);
    //     $this->set_goods_code = $this->set_good->set_goods_code;
    //     $this->name = $this->set_good->name;
    //     $this->categories_id = $this->set_good->categories_id;
    //     $this->qty = $this->set_good->qty;
    //     $this->measurements_id = $this->set_good->measurements_id;
    //     $this->price = $this->set_good->price;
    // }

    public function updateSetGood()
    {
        $this->validate([
            'set_goods_code' => 'required|string',
            'name' => 'required',
            'categories_id' => 'required',
            'qty' => 'required|integer',
            'measurements_id' => 'required',
            'price' => 'required|integer',
        ]);

        $this->set_good->update([
            'set_goods_code' => $this->set_goods_code,
            'name' => $this->name,
            'categories_id' => $this->categories_id,
            'qty' => $this->qty,
            'measurements_id' => $this->measurements_id,
            'price' => $this->price,
        ]);

        // $this->reset(); ----
        // $this->closeModal(); ----
        $this->dispatchBrowserEvent('update-success');
    }

    // SET BILL MATERIAL
    // public function showSetBill($id)
    // {
    //     $this->reset();
    //     $this->showingBillMaterialModal = true;

    //     // $this->set_goods_id = $id; ---
    //     $this->qty_bm = 1;
    //     $this->good_name = SetGood::where('id','=',$id)->first(['name'])->name;
    // }

    

    // DETAILS
    public function showDetail($id)
    {
        $this->showingDetailModal = true;
        $this->showingMainPage = false;
        $this->set_goods_id = $id;

        $this->set_good = SetGood::findOrFail($id);
        $this->set_goods_code = $this->set_good->set_goods_code;
        $this->name = $this->set_good->name;
        $this->categories_id = $this->set_good->categories_id;
        $this->qty = $this->set_good->qty;
        $this->measurements_id = $this->set_good->measurements_id;
        $this->price = $this->set_good->price;

        $this->qty_bm = 1;
    }

    public function storeSetBill()
    {
        // $this->validate([
        //     'set_goods_id' => 'required|integer',
        //     'materials_id' => 'required|integer',
        //     'qty' => 'required|integer',
        //     'price' => 'required|integer',
        //     'total_price' => 'required|integer',
        // ]);

        SetBillMaterial::create([
            'set_goods_id' => $this->set_goods_id,
            'materials_id' => $this->materials_id,
            'qty' => $this->qty_bm,
            'price' => $this->price_bm,
            'total_price' => $this->total_price_bm,
        ]);

        // Hitung total harga seluruh material
        SetGood::findOrFail($this->set_goods_id)->update([
            'price' => SetBillMaterial::where('set_goods_id','=',$this->set_goods_id)->sum('total_price')
        ]);

        DetailRabp::where('set_goods_id','=',$this->set_goods_id)->update([
            'price' => SetBillMaterial::where('set_goods_id','=',$this->set_goods_id)->sum('total_price')
        ]);

        $this->reset();
        $this->dispatchBrowserEvent('store-success');
    }

    public function updated($key, $value)
    {
        // Realtime update value set good
        if($this->name != NULL) {
            $this->categories_id = Material::where('name','=',$this->name)->first(['categories_id'])->categories_id;
            $this->measurements_id = Material::where('name','=',$this->name)->first(['measurements_id'])->measurements_id;
        } else {
            $this->categories_id = NULL;
            $this->measurements_id = NULL;
        }

        // Realtime update value set bill material
        if($this->materials_id != NULL) {
            $this->price_bm = Material::where('id','=',$this->materials_id)->first(['price'])->price;
            $this->total_price_bm = ($this->qty_bm * $this->price_bm);
        } else {
            $this->price_bm = NULL;
            $this->total_price_bm = NULL;
        }
    }
}
