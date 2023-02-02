<?php

namespace App\Http\Livewire;

use App\Models\DetailRabp;
use App\Models\Quotation;
use App\Models\Rabp;
use App\Models\RabpCost;
use App\Models\SetBillMaterial;
use App\Models\SetGood;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class RabpIndex extends Component
{
    use WithPagination;
    public $search = '';
    public $showPage = 15;
    public $searchBy = 'rabp_code';
    public $orderAsc = true;

    public $showingRabpModal = false;
    public $showingDetailModal = false;
    public $isEditMode = false;
    public $showingMainPage = true;
    public $showingDetailGood = false;
    public $showingApproval = false;

    public $quotations_id, $rabp_code, $name, $description, $date, $status_id;
    public $rabp;

    public $rabps_id, $set_goods_id, $qty_bg, $price_bg, $total_price_bg;

    public $overhead, $preliminary, $ppn, $profit,$total_profit, $total_price;
    public $rabp_cost;

    public $getBMId, $good_name;

    public $assign_rabpid;

    

    // public $keyword = "";
    // protected $queryString = ['keyword'];
    // public $results = array();
    // public $keyword;
    // public $results;
    // protected $queryString = ['keyword'];

    // public function mount()
    // {
    //     // Set default value untuk fitur tampilkan halaman
    //     $this->showPage = 15;
    // }

    public function render()
    {
        // Autocomplete search nama material
        // if (strlen($this->keyword) > 2) {
        //     $this->results = Material::where('name', 'LIKE', "%".$this->keyword."%")->get(['name']);
        // }
        return view('livewire.rabp-index', [
            // 'rabps' => Rabp::latest()->paginate($this->showPage),
            // 'rabps' => Rabp::where($this->searchBy,'like','%'.$this->search.'%')->orderBy($this->searchBy,$this->orderAsc ? 'asc' : 'desc')->paginate($this->showPage),
            'rabps' => Rabp::with('quotation','status')->search(trim($this->search))->orderBy($this->searchBy,$this->orderAsc ? 'asc' : 'desc')->paginate($this->showPage),
            'quotations' => Quotation::all(),
            'setgoods' => SetGood::all(),
            'detailrabps' => DetailRabp::where('rabps_id','=',$this->rabps_id)->get(),
            'rabpcosts' => RabpCost::all(),
            'setbillmaterials' => SetBillMaterial::where('set_goods_id','=',$this->getBMId)->get(),
        ])->layout('layouts.admin');
    }

    public function closeModal()
    {
        $this->showingRabpModal = false;
        $this->showingDetailModal = false;
        $this->showingApproval = false;
    }

    public function back()
    {
        $this->showingDetailModal = false;
        $this->showingMainPage = true;
    }

    public function createRabpCode() 
    {
        $countRabp = Rabp::count();
        if($countRabp == 0) {
            $this->rabp_code = 'RABP.' . 1001;
        } else {
            $getLastRabp = Rabp::all()->last();
            $convertRabp = (int)substr($getLastRabp->rabp_code, -4) + 1;
            $this->rabp_code = 'RABP.' . $convertRabp;
        }
    }
    
    public function showRabp()
    {
        $this->reset();
        $this->showingRabpModal = true;

        $this->createRabpCode();
        $this->date = Carbon::now()->format('Y-m-d');
        $this->description = "Menunggu Review";

        $this->ppn = 11;
    }

    public function storeRabp()
    {
        $this->validate([
            'quotations_id' => 'required|integer',
            'name' => 'required|string|max:128',
            'description' => 'string|max:128',
        ],[
        'name.required' => 'Nama wajib diisi',
        ]);

        Rabp::create([
            'quotations_id' => $this->quotations_id,
            'rabp_code' => $this->rabp_code,
            'name' => $this->name,
            'description' => $this->description,
            'date' => $this->date,
            'status_id' => 1,
            'users_id' => Auth::user()->id,
        ]);

        $getId = Rabp::where('quotations_id','=', $this->quotations_id)->first(['id'])->id;

        RabpCost::create([
            'rabps_id' => $getId,
            'overhead' => 0,
            'preliminary' => 0,
            'profit' => 0,
            'ppn' => 11,
            'total_profit' => 0,
            'total_price' => 0,
        ]);

        $this->reset();
        $this->closeModal();

        $this->dispatchBrowserEvent('store-success');
    }

    public function detailRabp($id)
    {
        $this->showingDetailModal = true;
        $this->showingMainPage = false;
        $this->rabps_id = $id;
        $this->qty_bg = 1;

        $this->rabp = Rabp::findOrFail($id);
        $this->rabp_code = $this->rabp->rabp_code;
        $this->quotations_id = $this->rabp->quotation['quotation_code'];
        $this->name = $this->rabp->name;
        $this->description = $this->rabp->description;
        $this->date = $this->rabp->date;

        $this->rabp_cost = RabpCost::findOrFail($id);
        $this->overhead = $this->rabp_cost->overhead;
        $this->preliminary = $this->rabp_cost->preliminary;
        $this->profit = $this->rabp_cost->profit;
        $this->ppn = $this->rabp_cost->ppn;
        $this->total_price = $this->rabp_cost->total_price;
        $this->total_profit = $this->rabp_cost->total_profit;
    }

    public function updateRabp()
    {
        $this->validate([
            'name' => 'required|string|max:128',
            'description' => 'string|max:128',
        ]);
        
        $this->rabp->update([
            'name' => $this->name,
            'description' => $this->description,
        ]);

        $this->back();
        $this->dispatchBrowserEvent('update-success');
    }

    public function updateCost()
    {
        $this->validate([
            'overhead' => 'required|integer',
            'preliminary' => 'required|integer',
            'profit' => 'required|integer',

            'total_profit' => 'required|integer',
            'total_price' => 'required|integer',
        ]);

        // Update total cost
        RabpCost::findOrFail($this->rabps_id)->update([
            'overhead' => $this->overhead,
            'preliminary' => $this->preliminary,
            'profit' => $this->profit,
        ]);

        $countOverPrelim = DetailRabp::where('rabps_id','=', $this->rabps_id)->sum('price') + $this->overhead + $this->preliminary; 
        $countTotalProfit = $countOverPrelim * ($this->profit * 0.01);
        $countTotalTax = ($countOverPrelim + $countTotalProfit) * ($this->ppn * 0.01);

        // Update total harga seluruh barang
        RabpCost::findOrFail($this->rabps_id)->update([
            'total_profit' => $countTotalProfit,
            'total_price' => $countOverPrelim + $countTotalProfit + $countTotalTax,
        ]);

        // Reset total harga dan total profit
        $this->total_price = RabpCost::where('id','=',$this->rabps_id)->first(['total_price'])->total_price;
        $this->total_profit = RabpCost::where('id','=',$this->rabps_id)->first(['total_profit'])->total_profit;

        $this->dispatchBrowserEvent('update-success');
    }

    public function storeGood()
    {
        $this->validate([
            'set_goods_id' => 'required|integer',
            'qty_bg' => 'required|integer',
            'price_bg' => 'required|integer',

            'total_profit' => 'required|integer',
            'total_price' => 'required|integer',
        ]);

        // Menambah barang yang di order
        DetailRabp::create([
            'rabps_id' => $this->rabps_id,
            'set_goods_id' => $this->set_goods_id,
            'qty' => $this->qty_bg,
            'price' => $this->price_bg,
        ]);

        $countOverPrelim = DetailRabp::where('rabps_id','=', $this->rabps_id)->sum('price') + $this->overhead + $this->preliminary; 
        $countTotalProfit = $countOverPrelim * ($this->profit * 0.01);
        $countTotalTax = ($countOverPrelim + $countTotalProfit) * ($this->ppn * 0.01);

        // Update total harga seluruh barang
        RabpCost::findOrFail($this->rabps_id)->update([
            'total_profit' => $countTotalProfit,
            'total_price' => $countOverPrelim + $countTotalProfit + $countTotalTax,
        ]);

        // Reset form tambah barang
        $this->set_goods_id = NULL;
        $this->qty_bg = 1;
        $this->price_bg = NULL;
        $this->total_price_bg = NULL;

        // Reset total harga dan total profit
        $this->total_price = RabpCost::where('id','=',$this->rabps_id)->first(['total_price'])->total_price;
        $this->total_profit = RabpCost::where('id','=',$this->rabps_id)->first(['total_profit'])->total_profit;
        $this->dispatchBrowserEvent('store-success');
    }

    public function detailGood($id)
    {
        $this->showingDetailGood = true;
        $this->getBMId = $id;
        $this->good_name = SetGood::where('id','=',$id)->first(['name'])->name;
    }

    public function closeDetailGood()
    {
        $this->showingDetailGood = false;
    }

    public function updated($key, $value)
    {
        // Realtime update value set good
        if($this->set_goods_id != NULL) {
            $this->price_bg = SetGood::where('id','=',$this->set_goods_id)->first(['price'])->price;
            $this->total_price_bg = ($this->qty_bg * $this->price_bg);
        } else {
            $this->price_bg = NULL;
            $this->total_price_bg = NULL;
        }
    }

    public function updateProfitPrice()
    {
        $countOverPrelim = DetailRabp::where('rabps_id','=', $this->rabps_id)->sum('price') + $this->overhead + $this->preliminary; 
        $countTotalProfit = $countOverPrelim * ($this->profit * 0.01);
        $countTotalTax = ($countOverPrelim + $countTotalProfit) * ($this->ppn * 0.01);

        // Update total harga seluruh barang
        RabpCost::findOrFail($this->rabps_id)->update([
            'total_profit' => $countTotalProfit,
            'total_price' => $countOverPrelim + $countTotalProfit + $countTotalTax,
        ]);

        // Reset total harga dan total profit
        $this->total_price = RabpCost::where('id','=',$this->rabps_id)->first(['total_price'])->total_price;
        $this->total_profit = RabpCost::where('id','=',$this->rabps_id)->first(['total_profit'])->total_profit;
        $this->dispatchBrowserEvent('store-success');
    }

    public function approve()
    {
        $this->showingApproval = true;
    }
}
