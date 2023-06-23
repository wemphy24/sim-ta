<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\DetailRabp;
use App\Models\Material;
use App\Models\Measurement;
use App\Models\Quotation;
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
    
    public $showingSetGood = false;
    public $showingDetail = false;
    public $showingMainPage = true;
    public $showingEditMaterial = false;

    // Tabel set_goods
    public $categories_id, $quotations_id, $measurements_id, $set_goods_code, $name, $qty, $price;
    public $set_good;

    // Tabel set_bill_materials
    public $set_goods_id, $materials_id, $qty_bm, $price_bm, $total_price_bm;

    // Untuk edit set_bill_materials (material)
    public $s_good_id, $m_id, $m_qty, $m_price, $m_total_price;
    public $set_bill_material;

    public function render()
    {
        return view('livewire.set-good-index', [
            'set_goods' => SetGood::with('category','measurement')->search(trim($this->search))->orderBy($this->searchBy,$this->orderAsc ? 'asc' : 'desc')->paginate($this->showPage),
            'materials' => Material::where('categories_id','=',3)->get(),
            'all_materials' => Material::where('categories_id','=',1)->orWhere('categories_id','=','2')->get(),
            'categories' => Category::all(),
            'measurements' => Measurement::all(),
            'set_bill_materials' => SetBillMaterial::where('set_goods_id','=',$this->set_goods_id)->get(),
            'quotations' => Quotation::all(),
        ])->layout('layouts.admin');
    }

    public function closeModal()
    {
        // Menutup set good modal
        $this->showingSetGood = false;
        $this->showingDetail = false;
    }

    public function back()
    {
        // Menutup detail page dan menampilkan main page
        $this->showingDetail = false;
        $this->showingMainPage = true;
    }

    // SET GOOD -----------
    public function createSetGoodCode() 
    {
        // Membuat kode set good
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
        // Menampilkan set good modal
        $this->reset();
        $this->showingSetGood = true;

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

        // Store data set good
        SetGood::create([
            'quotations_id' => $this->quotations_id,
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

    // DETAILS -----------
    public function showDetail($id)
    {
        // Menampilkan detail page
        $this->showingDetail = true;
        $this->showingMainPage = false;
        $this->set_goods_id = $id;

        $this->set_good = SetGood::findOrFail($id);
        $this->set_goods_code = $this->set_good->set_goods_code;
        $this->name = $this->set_good->name;
        $this->categories_id = $this->set_good->categories_id;
        $this->qty = $this->set_good->qty;
        $this->measurements_id = $this->set_good->measurements_id;
        $this->price = $this->set_good->price;

        // Default value input qty material
        $this->qty_bm = 1;
    }

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

        // Mengupdate data set good
        $this->set_good->update([
            'set_goods_code' => $this->set_goods_code,
            'name' => $this->name,
            'categories_id' => $this->categories_id,
            'qty' => $this->qty,
            'measurements_id' => $this->measurements_id,
            'price' => $this->price,
        ]);

        // Hitung total harga seluruh material
        SetGood::findOrFail($this->set_goods_id)->update([
            'price' => SetBillMaterial::where('set_goods_id','=',$this->set_goods_id)->sum('total_price')
        ]);

        DetailRabp::where('set_goods_id','=',$this->set_goods_id)->update([
            'price' => SetBillMaterial::where('set_goods_id','=',$this->set_goods_id)->sum('total_price')
        ]);

        $this->reset();
        $this->closeModal();
        $this->dispatchBrowserEvent('update-success');
    }

    

    // SET BILL MATERIAL -----------
    public function storeSetBill()
    {
        // Store data set bill material
        SetBillMaterial::create([
            'set_goods_id' => $this->set_goods_id,
            'materials_id' => $this->materials_id,
            'qty' => $this->qty_bm,
            'price' => $this->price_bm,
            'total_price' => $this->total_price_bm,
            'qty_received' => 0,
            'qty_install' => 0,
            'qty_remaining' => 0,
        ]);

        // Hitung total harga seluruh material
        SetGood::findOrFail($this->set_goods_id)->update([
            'price' => SetBillMaterial::where('set_goods_id','=',$this->set_goods_id)->sum('total_price')
        ]);

        DetailRabp::where('set_goods_id','=',$this->set_goods_id)->update([
            'price' => SetBillMaterial::where('set_goods_id','=',$this->set_goods_id)->sum('total_price')
        ]);

        // Mengembalikan pilihan material ke null
        // $this->materials_id = "";
        // $this->qty_bm = 1;
        // $this->price_bm = "";
        // $this->total_price_bm = "";

        $this->dispatchBrowserEvent('store-success');
    }

    public function editSetBill($id)
    {
        // Menampilkan modal edit material
        $this->showingEditMaterial = true;

        $this->set_bill_material = SetBillMaterial::findOrFail($id);
        $this->m_id = $this->set_bill_material->materials_id;
        $this->m_qty = $this->set_bill_material->qty;
        $this->m_price = $this->set_bill_material->price;
        $this->m_total_price = $this->set_bill_material->total_price;
    }

    public function updateSetBill()
    {
        // Mengupdate data set bill material
        $this->set_bill_material->update([
            'set_goods_id' => $this->set_goods_id,
            'materials_id' => $this->m_id,
            'qty' => $this->m_qty,
            'price' => $this->m_price,
            'total_price' => $this->m_total_price,
        ]);

        // Hitung total harga seluruh material
        SetGood::findOrFail($this->set_goods_id)->update([
            'price' => SetBillMaterial::where('set_goods_id','=',$this->set_goods_id)->sum('total_price')
        ]);

        DetailRabp::where('set_goods_id','=',$this->set_goods_id)->update([
            'price' => SetBillMaterial::where('set_goods_id','=',$this->set_goods_id)->sum('total_price')
        ]);

        $this->dispatchBrowserEvent('update-success');
        $this->closeEdit();
    }

    public function closeEdit()
    {
        // Menutup modal edit material
        $this->showingEditMaterial = false;
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

        // Realtime update value set bill material ketika insert data
        if($this->materials_id != NULL) {
            $this->price_bm = Material::where('id','=',$this->materials_id)->first(['price'])->price;
            $this->total_price_bm = ($this->qty_bm * $this->price_bm);
        } else {
            $this->price_bm = NULL;
            $this->total_price_bm = NULL;
        }

        // Realtime update value set bill material ketika update data
        if($this->m_id != NULL) {
            $this->m_price = Material::where('id','=',$this->m_id)->first(['price'])->price;
            $this->m_total_price = ($this->m_qty * $this->m_price);
            // $this->price = SetBillMaterial::where('set_goods_id', '=', $this->set_goods_id)->sum('total_price');
        }
    }
}
