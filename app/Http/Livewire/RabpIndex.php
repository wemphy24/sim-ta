<?php

namespace App\Http\Livewire;

use App\Models\BillMaterial;
use App\Models\BudgetPlanCost;
use App\Models\Category;
use App\Models\DetailBillMaterial;
use App\Models\Material;
use App\Models\Measurement;
use App\Models\Quotation;
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
    public $showingDetailRabpModal = false;
    public $showingRabpMaterialModal = false;
    public $isEditMode = false;
    public $budget_plan_code, $budget_cost_code, $description, $quotations_id, $status_id, $users_id;

    public $rabp;
    public $currentDate;
    public $getDateNow;

    // RABP material
    public $catchRabpId;
    public $budget_plan_costs_id, $materials_id, $price, $quantity, $total_price;
    public $overhead_cost, $preliminary_cost, $ppn, $profit;

    public $checkExistBillMaterial;
    public $measurement;

    // Detail RABP material
    public $checkExistData;
    public $totalRap, $totalProfit, $totalPPN, $subTotal, $totalRabp;

    // public $keyword = "";
    // protected $queryString = ['keyword'];
    // public $results = array();
    public $keyword;
    public $results;
    protected $queryString = ['keyword'];

    public function mount()
    {
        // Set default value untuk fitur tampilkan halaman
        $this->showPage = 5;
        $this->ppn = 11;
        $this->getDateNow = Carbon::now()->format('Y-m-d');
    }

    public function render()
    {
        // Autocomplete search nama material
        if (strlen($this->keyword) > 2) {
            $this->results = Material::where('name', 'LIKE', "%".$this->keyword."%")->get(['name']);
        }

        // Cek jika tabel bill material sudah ada isinya
        $this->checkExistBillMaterial = BillMaterial::count();

        return view('livewire.rabp-index', [
            'rabps' => BudgetPlanCost::where('budget_plan_code', '!=', NULL)->latest()->paginate(5),
            // 'rabps' => BudgetPlanCost::latest()->paginate(5),
            'quotations' => Quotation::all(),
            'materials' => Material::all(),
            'bill_materials' => BillMaterial::where("budget_plan_costs_id", "=", $this->catchRabpId)->get(),
        ])->layout('layouts.admin');
    }

    public function closeModal()
    {
        $this->showingRabpModal = false;
        $this->showingDetailRabpModal = false;
        $this->showingRabpMaterialModal = false;
    }

    public function showRabpEditModal($id) 
    {
        $this->rabp = BudgetPlanCost::findOrFail($id);
        $this->budget_plan_code = $this->rabp->budget_plan_code;
        $this->description = $this->rabp->description;
        $this->currentDate = $this->rabp->date;

        $this->showingRabpModal = true;
        $this->isEditMode = true;
    }
    
    public function updateRabp() 
    {
        $this->rabp->update([
            'description' => $this->description,
        ]);

        $this->showingRabpModal = false;
        $this->dispatchBrowserEvent('update-success');
    }

    public function deleteRabp($id)
    {
        $rabp = BudgetPlanCost::find($id);
        $rabp->delete();

        $this->dispatchBrowserEvent('delete-success');
    }

    public function detailRabp($id)
    {
        // Tampilkan daftar bill material
        $this->catchRabpId = $id;

        $this->showingDetailRabpModal = true;

        $this->rabp = BudgetPlanCost::findOrFail($id);
        $this->quotation_code = $this->rabp->quotation['quotation_code'];
        $this->quotation_date = $this->rabp->quotation['date'];
        $this->quotation_name = $this->rabp->quotation['name'];
        $this->quotation_customer = $this->rabp->quotation->customer['name'];

        $this->budget_plan_code = $this->rabp->budget_plan_code;
        $this->description = $this->rabp->description;
        $this->currentDate = $this->rabp->date;
        $this->status_id = $this->rabp->status['name'];
        $this->users_id = $this->rabp->user['name'];

        $this->totalRap = BillMaterial::where('budget_plan_costs_id','=',$id)->sum('total_price');
        $this->overhead_cost = DetailBillMaterial::where('bill_materials_id','=',$id)->first(['overhead_cost'])->overhead_cost;
        $this->preliminary_cost = DetailBillMaterial::where('bill_materials_id','=',$id)->first(['preliminary_cost'])->preliminary_cost;
        $this->totalRabp = DetailBillMaterial::where('bill_materials_id','=',$id)->first(['total_price_rabp'])->total_price_rabp;

        $getPercentageProfit = (DetailBillMaterial::where('bill_materials_id','=',$id)->first(['profit'])->profit);
        $this->profit = $getPercentageProfit;

        $getProfit = (DetailBillMaterial::where('bill_materials_id','=',$id)->first(['profit'])->profit) * 0.01;
        $this->totalProfit = $getProfit * $this->totalRap;

        $getPPN = (DetailBillMaterial::where('bill_materials_id','=',$id)->first(['ppn'])->ppn) * 0.01;
        $this->totalPPN = $getPPN * ($this->totalRap + $this->totalProfit + $this->overhead_cost + $this->preliminary_cost);

        $this->subTotal = ($this->totalRap + $this->overhead_cost + $this->preliminary_cost + $this->totalProfit);
    }

    // --- MATERIAL RABP ---
    public function showRabpMaterial($id)
    {
        // Tampilkan daftar bill material
        $this->catchRabpId = $id;

        // Set default RABP material
        $this->budget_plan_costs_id = $id;
        $this->materials_id = 1;
        $this->quantity = 1;

        $getCategoryId = Material::where('id', '=', $this->materials_id)->first(['measurements_id'])->measurements_id;
        $this->category = Category::where('id', '=', $getCategoryId)->first(['name'])->name;

        $getMeasurementId = Material::where('id', '=', $this->materials_id)->first(['measurements_id'])->measurements_id;
        $this->measurement = Measurement::where('id', '=', $getMeasurementId)->first(['name'])->name;
        
        $this->price = Material::where('id', '=', $this->materials_id)->first(['price'])->price;
        $this->total_price = Material::where('id', '=', $this->materials_id)->first(['price'])->price;

        // Cek jika kolom detail_materials_id ada isinya
        $checkExistValue = DetailBillMaterial::select('bill_materials_id')->where('bill_materials_id',$id)->exists();
        if($checkExistValue == true) {
            $this->overhead_cost = DetailBillMaterial::where("bill_materials_id", '=', $id)->first(['overhead_cost'])->overhead_cost;
            $this->preliminary_cost = DetailBillMaterial::where("bill_materials_id", '=', $id)->first(['preliminary_cost'])->preliminary_cost;
            $this->profit = DetailBillMaterial::where("bill_materials_id", '=', $id)->first(['profit'])->profit;
        } else {
            $this->overhead_cost = NULL;
            $this->preliminary_cost = NULL;
            $this->profit = NULL;
        }

        $this->keyword = "";
        $this->showingRabpMaterialModal = true;
    }

    public function storeRabpMaterial()
    {
        BillMaterial::create([
            'budget_plan_costs_id' => $this->budget_plan_costs_id,
            'materials_id' => $this->materials_id,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'total_price' => $this->total_price,
        ]);

        $this->dispatchBrowserEvent('store-success');
        $this->quantity = 1;
    }

    public function storeRabpCostMaterial()
    {
        $calculateTotalRap = BillMaterial::where('budget_plan_costs_id','=',$this->budget_plan_costs_id)->sum('total_price');
        $calculateProfit = ($this->profit * 0.01) * ($calculateTotalRap);
        $calculatePPN = ($this->ppn * 0.01) * ($calculateTotalRap + $calculateProfit + $this->overhead_cost + $this->preliminary_cost);

        // Cek jika kolom detail_materials_id sudah ada isinya
        $this->checkExistData = DetailBillMaterial::select('bill_materials_id')->where('bill_materials_id',$this->budget_plan_costs_id)->exists();
        if($this->checkExistData == false) {
            DetailBillMaterial::create([
                'bill_materials_id' => $this->budget_plan_costs_id,
                'total_price_rap' => $calculateTotalRap,
                'overhead_cost' => $this->overhead_cost,
                'preliminary_cost' => $this->preliminary_cost,
                'profit' => $this->profit,
                'ppn' => $this->ppn,
                'total_price_rabp' => ($calculateTotalRap + $calculateProfit + $this->overhead_cost + $this->preliminary_cost+ $calculatePPN),
            ]);
        } else {
            $getDetailBillMaterialId = DetailBillMaterial::findOrFail($this->budget_plan_costs_id);
            $getDetailBillMaterialId->update([
                'bill_materials_id' => $this->budget_plan_costs_id,
                'total_price_rap' => $calculateTotalRap,
                'overhead_cost' => $this->overhead_cost,
                'preliminary_cost' => $this->preliminary_cost,
                'profit' => $this->profit,
                'ppn' => $this->ppn,
                'total_price_rabp' => ($calculateTotalRap + $calculateProfit + $this->overhead_cost + $this->preliminary_cost+ $calculatePPN),
            ]);
        }

        $this->dispatchBrowserEvent('store-success');
        $this->showingRabpMaterialModal = false;
    }

    public function approveRabp($id)
    {
        $this->changeStatus = BudgetPlanCost::findOrFail($id);
        $this->getRabpId = $id;
        DB::transaction(function() {
            // Ubah status RABP ke Complete
            $this->changeStatus->update([
                'status_id' => 3,
                'description' => "Sudah Deal",
            ]);
            // Membuat kode RAP
            $getTimeNow = Carbon::now();
            $getRabpCode = substr(BudgetPlanCost::where('quotations_id', '=', $this->getRabpId)->first(['budget_plan_code'])->budget_plan_code, -4);
            $this->budget_cost_code = 'RAP.' . ($getTimeNow->day) . ".0" . ($getTimeNow->month) . "." . ($getTimeNow->year) . '.' . $getRabpCode;

            $getRapId = BudgetPlanCost::create([
                'quotations_id' => $this->getRabpId,
                'budget_plan_code' => NULL,
                'budget_cost_code' => $this->budget_cost_code,
                'description' => "Review RAP",
                'date' => $this->getDateNow,
                'status_id' => 1,
                'users_id' => Auth::user()->id,
            ]);

            // Membuat bill material untuk RAP berdasarkan RABP
            $getBillMaterialRabp = BillMaterial::all();
            foreach ($getBillMaterialRabp as $bmrap) {
                    BillMaterial::create([
                    'budget_plan_costs_id' => $getRapId->id,
                    'materials_id' => $bmrap->materials_id,
                    'quantity' => $bmrap->quantity,
                    'price' => $bmrap->price,
                    'total_price' => $bmrap->total_price,
                ]);
            }
            
            // Membuat detail bill material untuk RAP berdasarkan RABP
            DetailBillMaterial::create([
                'bill_materials_id' => $getRapId->id,
                'total_price_rap' => DetailBillMaterial:: where('bill_materials_id', '=', $this->getRabpId)->first(['total_price_rap'])->total_price_rap,
                'overhead_cost' => DetailBillMaterial:: where('bill_materials_id', '=', $this->getRabpId)->first(['overhead_cost'])->overhead_cost,
                'preliminary_cost' => DetailBillMaterial:: where('bill_materials_id', '=', $this->getRabpId)->first(['preliminary_cost'])->preliminary_cost,
                'profit' => DetailBillMaterial:: where('bill_materials_id', '=', $this->getRabpId)->first(['profit'])->profit,
                'ppn' => $this->ppn,
                'total_price_rabp' => DetailBillMaterial:: where('bill_materials_id', '=', $this->getRabpId)->first(['total_price_rabp'])->total_price_rabp,
            ]);
        });

        $this->dispatchBrowserEvent('store-success');
    }

    public function updated($key, $value)
    {
        // Realtime update value perhitungan RABP material masuk database
        if (in_array($key,['quantity','price','materials_id'])) {
            $this->price = Material::where('id', '=', $this->materials_id)->first(['price'])->price;
            $this->total_price = $this->quantity * $this->price;

            // Realtime update value tanpa masuk database
            $getCategoryId = Material::where('id', '=', $this->materials_id)->first(['measurements_id'])->measurements_id;
            $this->category = Category::where('id', '=', $getCategoryId)->first(['name'])->name;
            
            $getMeasurementId = Material::where('id', '=', $this->materials_id)->first(['measurements_id'])->measurements_id;
            $this->measurement = Measurement::where('id', '=', $getMeasurementId)->first(['name'])->name;
        }
    }

    // public function updateKeyword() {
    //      // if (strlen($this->keyword) > 2) {
    //         $this->results = Material::where('name', 'LIKE', "%".$this->keyword."%")->get();
    //     // }
    // }
}
