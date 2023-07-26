<?php

namespace App\Http\Livewire;

use App\Models\BillMaterial;
use App\Models\Category;
use App\Models\Cost;
use App\Models\Customer;
use App\Models\DetailRabp;
use App\Models\Good;
use App\Models\Material;
use App\Models\Measurement;
use Livewire\Component;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class GoodIndex extends Component
{
    use WithPagination;
    public $search = '';
    public $showPage = 15;
    public $searchBy = 'good_code';
    public $orderAsc = true;

    public $showingGoodModal = false;
    public $showingMainPage = true;
    public $showingDetail = false;

    public $good_code, $name, $stock, $price, $sell_price, $categories_id, $measurements_id, $customers_id, $users_id, $status_id, $status;
    public $good, $getGoodsId;

    public $overhead, $preliminary, $profit;

    public $materials_id;
    public $qty_bm, $price_bm, $total_price_bm;
    
    public function render()
    {
        return view('livewire.good-index', [
            'goods' => Good::with('category')->search(trim($this->search))->orderBy($this->searchBy,$this->orderAsc ? 'asc' : 'desc')->paginate($this->showPage),
            'categories' => Category::all(),
            'measurements' => Measurement::all(),
            'customers' => Customer::all(),
            'billmaterials' => BillMaterial::where('goods_id','=',$this->getGoodsId)->get(),
            'materials' => Material::all(),
        ])->layout('layouts.admin');
    }

    public function closeModal()
    {
        $this->showingGoodModal = false;
    }

    public function back()
    {
        // Menutup detail page dan menampilkan main page
        $this->showingMainPage = true;
        $this->showingDetail = false;
    }

    public function createGoodCode()
    {
        // Membuat kode barang
        $countGood = Good::count();
        if($countGood == 0) {
            $this->good_code = 'SET.' . "0" . (Carbon::now()->day) . "." . (Carbon::now()->month) . "." . (Carbon::now()->year) . '.' . 1001;
        } else {
            $getLastGood = Good::all()->last();
            $convertGood = (int)substr($getLastGood->good_code, -4) + 1;
            $this->good_code = 'SET.' . "0" . (Carbon::now()->day) . "." . (Carbon::now()->month) . "." . (Carbon::now()->year) . '.' . $convertGood;
        }
    }

    public function showGoodModal()
    {
        $this->reset();
        $this->showingGoodModal = true;

        $this->createGoodCode();
        $this->price = 0;
        $this->stock = 0;
        $this->categories_id = 3;
        $this->measurements_id = 3;
    }

    public function store()
    {
        $getIdBarang = DB::table('goods')->insertGetId([
                            'categories_id' => $this->categories_id,
                            'measurements_id' => $this->measurements_id,
                            'good_code' => $this->good_code,
                            'name' => $this->name,
                            'stock' => 0,
                            'price' => 0,
                            'sell_price' => 0,
                            'customers_id' => $this->customers_id,
                            'status_id' => 1,
                            'status_production' => "Siap Dirakit",
                            'status_delivery' => NULL,
                            'status_qc' => NULL,
                            'start_prod' => NULL,
                            'end_prod' => NULL,
                            'users_id' => Auth::user()->id,
                        ]);

        Cost::create([
            'goods_id' => $getIdBarang,
            'overhead' => 0,
            'preliminary' => 0,
            'profit' => 0,
        ]);

        $this->reset();
        $this->closeModal();
        $this->dispatchBrowserEvent('store-success');
    }

    public function detail($id)
    {
        // Menampilkan detail page
        $this->showingDetail = true;
        $this->showingMainPage = false;

        $this->good = Good::findOrFail($id);
        $this->categories_id = $this->good->category['id'];
        $this->measurements_id = $this->good->measurement['id'];
        $this->good_code = $this->good->good_code;
        $this->name = $this->good->name;
        $this->stock = $this->good->stock;
        $this->price = $this->good->price;
        $this->sell_price = $this->good->sell_price;
        $this->users_id = $this->good->user['name'];

        $this->overhead = Cost::where('goods_id','=',$this->good->id)->first('overhead')->overhead;
        $this->preliminary = Cost::where('goods_id','=',$this->good->id)->first('preliminary')->preliminary;
        $this->profit = Cost::where('goods_id','=',$this->good->id)->first('profit')->profit;

        $this->qty_bm = 1;

        // Ambill id barang
        $this->getGoodsId = Good::where('id','=',$id)->first('id')->id;

        // Hitung ulang semua harga apabila terjadi perubahan harga material master
        $hitungHargaAsli = BillMaterial::where('goods_id','=',$this->good->id)->sum('total_price');
        $hitungHargaProduksi = $hitungHargaAsli + $this->overhead + $this->preliminary;

        $hitungProfit = $hitungHargaProduksi * ($this->profit * 0.01);

        $hitungHargaJual = $hitungHargaProduksi + $hitungProfit;

        Good::where('id','=',$this->good->id)->update([
            'price' => $hitungHargaProduksi,
            'sell_price' => $hitungHargaJual,
        ]);
        
        $this->dispatchBrowserEvent('store-success');
    }

    public function update()
    {
        $this->good->update([
            'name' => $this->name,
        ]);

        Cost::where('goods_id','=',$this->good->id)->update([
            'overhead' => $this->overhead,
            'preliminary' => $this->preliminary,
            'profit' => $this->profit,
        ]);

        $hitungHargaAsli = BillMaterial::where('goods_id','=',$this->good->id)->sum('total_price');
        $hitungHargaProduksi = $hitungHargaAsli + $this->overhead + $this->preliminary;

        $hitungProfit = $hitungHargaProduksi * ($this->profit * 0.01);

        $hitungHargaJual = $hitungHargaProduksi + $hitungProfit;

        Good::where('id','=',$this->good->id)->update([
            'price' => $hitungHargaProduksi,
            'sell_price' => $hitungHargaJual,
        ]);

        DetailRabp::where('goods_id','=',$this->good->id)->update([
            'price' => $hitungHargaJual,
        ]);

        $this->reset();
        $this->dispatchBrowserEvent('store-success');
    }

    public function storeBillMaterial()
    {
        BillMaterial::create([
            'goods_id' => $this->good->id,
            'materials_id' => $this->materials_id,
            'qty' => $this->qty_bm,
            'price' => $this->price_bm,
            'total_price' => $this->total_price_bm,
            'qty_received' => 0,
            'qty_install' => 0,
            'qty_remaining' => 0,
            'status' => "Belum Diambil",
        ]);

        $hitungHargaAsli = BillMaterial::where('goods_id','=',$this->good->id)->sum('total_price');
        $hitungHargaProduksi = $hitungHargaAsli + $this->overhead + $this->preliminary;

        $hitungProfit = $hitungHargaProduksi * ($this->profit * 0.01);

        $hitungHargaJual = $hitungHargaProduksi + $hitungProfit;

        Good::where('id','=',$this->good->id)->update([
            'price' => $hitungHargaProduksi,
            'sell_price' => $hitungHargaJual,
        ]);

        $this->reset();
        $this->dispatchBrowserEvent('store-success');
    }

    public function editBillMaterial($id)
    {
        
    }

    public function updateBillMaterial()
    {
        // BillMaterial::where('id','=',$id)->update([
        //     'materials_id' => $this->materials_id,
        //     'qty' => $this->qty_bm,
        //     'price' => $this->price_bm,
        // ]); 
    }

    public function updated($key, $value)
    {
        // Realtime update value set good ketika insert data
        if($this->materials_id != NULL) {
            $this->price_bm = Material::where('id','=',$this->materials_id)->first(['price'])->price;
            $this->total_price_bm = ($this->qty_bm * $this->price_bm);
        } else {
            $this->price_bm = NULL;
            $this->total_price_bm = NULL;
        }
    }
}
