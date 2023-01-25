<?php

namespace App\Http\Livewire;

use App\Models\BillMaterial;
use App\Models\BudgetPlanCost;
use App\Models\Category;
use App\Models\DetailRabp;
use App\Models\Material;
use App\Models\Measurement;
use App\Models\Quotation;
use App\Models\Rabp;
use App\Models\RabpCost;
use App\Models\SetGood;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class RabpIndex extends Component
{
    use WithPagination;
    public $search;
    public $showPage;

    public $showingRabpModal = false;
    public $showingDetailModal = false;
    public $isEditMode = false;
    public $showingMainPage = true;

    public $quotations_id, $rabp_code, $name, $description, $date, $status_id;
    public $rabp;

    public $rabps_id, $set_goods_id, $qty_bg, $price_bg, $total_price_bg;

    public $overhead, $preliminary, $ppn, $profit, $total_price;




    // public $currentDate;
    // public $getDateNow;

    // // RABP material
    // public $catchRabpId;
    // public $budget_plan_costs_id, $materials_id, $price, $quantity, $total_price;
    // public $overhead_cost, $preliminary_cost, $ppn, $profit;

    // public $checkExistBillMaterial;
    // public $measurement;

    // // Detail RABP material
    // public $checkExistData;
    // public $totalRap, $totalProfit, $totalPPN, $subTotal, $totalRabp;

    // public $keyword = "";
    // protected $queryString = ['keyword'];
    // public $results = array();
    // public $keyword;
    // public $results;
    // protected $queryString = ['keyword'];

    public function mount()
    {
        // Set default value untuk fitur tampilkan halaman
        $this->showPage = 5;
        // $this->ppn = 11;
        // $this->getDateNow = Carbon::now()->format('Y-m-d');
    }

    public function render()
    {
        // Autocomplete search nama material
        // if (strlen($this->keyword) > 2) {
        //     $this->results = Material::where('name', 'LIKE', "%".$this->keyword."%")->get(['name']);
        // }

        // Cek jika tabel bill material sudah ada isinya
        // $this->checkExistBillMaterial = BillMaterial::count();

        return view('livewire.rabp-index', [
            'rabps' => Rabp::latest()->paginate(5),
            'quotations' => Quotation::all(),
            'setgoods' => SetGood::all(),
            'detailrabps' => DetailRabp::all(),
            'rabpcosts' => RabpCost::all(),
        ])->layout('layouts.admin');
    }

    public function closeModal()
    {
        $this->showingRabpModal = false;
        $this->showingDetailModal = false;
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
    }

    public function storeRabp()
    {
        Rabp::create([
            'quotations_id' => $this->quotations_id,
            'rabp_code' => $this->rabp_code,
            'name' => $this->name,
            'description' => $this->description,
            'date' => $this->date,
            'status_id' => 1,
            'users_id' => Auth::user()->id,
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
        $this->ppn = 12;

        $this->rabp = Rabp::findOrFail($id);
        $this->rabp_code = $this->rabp->rabp_code;
        $this->quotations_id = $this->rabp->quotation['quotation_code'];
        $this->name = $this->rabp->name;
        $this->description = $this->rabp->description;
        $this->date = $this->rabp->date;

        $this->overhead = RabpCost::where('id','=',$id)->first(['overhead'])->overhead;
        $this->preliminary = RabpCost::where('id','=',$id)->first(['preliminary'])->preliminary;
        $this->profit = RabpCost::where('id','=',$id)->first(['profit'])->profit;
    }

    public function updateRabp()
    {
        $this->rabp->update([
            'name' => $this->name,
            'description' => $this->description,
        ]);

        $this->back();
        $this->dispatchBrowserEvent('update-success');
    }

    // Menentukan cost barang yang di order
    public function storeCost()
    {
        RabpCost::create([
            'rabps_id' => $this->rabps_id,
            'overhead' => $this->overhead,
            'preliminary' => $this->preliminary,
            'profit' => $this->profit,
            'ppn' => $this->ppn,
            'total_price' => $this->total_price,
        ]);

        $this->dispatchBrowserEvent('store-success');
    }

    // Menetukan barang yang di order
    public function storeGood()
    {
        // dd(RabpCost::where('id','=', $this->rabps_id)->first(['total_price'])->total_price);
        DetailRabp::create([
            'rabps_id' => $this->rabps_id,
            'set_goods_id' => $this->set_goods_id,
            'qty' => $this->qty_bg,
            'price' => $this->price_bg,
        ]);

        $countOverPrelim = DetailRabp::where('id','=', $this->rabps_id)->sum('price') + $this->overhead + $this->preliminary; 
        $countTotalProfit = $countOverPrelim * ($this->profit * 0.01);
        $countTotalTax = $countOverPrelim * ($this->ppn * 0.01);
        // Update total harga seluruh barang
        RabpCost::findOrFail($this->rabps_id)->update([
            // 'total_price' => (DetailRabp::where('id','=', $this->rabps_id)->sum('price')),
            'total_price' => $countOverPrelim + $countTotalProfit + $countTotalTax,
        ]);


        $this->dispatchBrowserEvent('store-success');
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

        if($this->overhead != NULL)
        {
            $this->total_price = RabpCost::where('id','=',$this->rabps_id)->first(['total_price'])->total_price;
        } else {
            $this->total_price = 0;
        }
    }
}
