<?php

namespace App\Http\Livewire;

use App\Models\BillMaterial;
use App\Models\BudgetPlan;
use App\Models\DetailBillMaterial;
use App\Models\Material;
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
    public $budget_plan_code, $description, $quotations_id, $status_id, $users_id;

    public $rabp;
    public $currentDate;

    // Rabp material
    public $budget_plans_id, $materials_id, $price, $quantity, $total_price;
    public $overhead_cost, $preliminary_cost, $ppn, $profit;

    // Detail Rabp material
    public $totalRap, $totalProfit, $totalPPN, $totalRabp;

    public function mount()
    {
        // Set default value untuk fitur tampilkan halaman
        $this->showPage = 5;
        $this->ppn = 11;
    }

    public function render()
    {
        return view('livewire.rabp-index', [
            'rabps' => BudgetPlan::latest()->paginate(5),
            'quotations' => Quotation::all(),
            'materials' => Material::all(),
            'bill_materials' => BillMaterial::all(),
        ])->layout('layouts.admin');
    }

    // --- RABP ---
    public function showRabpModal()
    {
        $this->reset();
        $this->showingRabpModal = true;

        $this->currentDate = Carbon::now()->format('Y-m-d');

        $countRabp = BudgetPlan::count();
        $getTimeNow = Carbon::now();
        if($countRabp == 0) {
            $this->budget_plan_code = 'RABP.' . ($getTimeNow->day) . 0 . ($getTimeNow->month) . ($getTimeNow->year) . '.' . 1001;
        } else {
            $getLastRabp = BudgetPlan::all()->last();
            $convertRabp = (int)substr($getLastRabp->budget_plan_code, -4) + 1;
            $this->budget_plan_code = 'RABP.' . ($getTimeNow->day) . 0 . ($getTimeNow->month) . ($getTimeNow->year) . '.' . $convertRabp;
        }
    }

    public function closeModal()
    {
        $this->showingRabpModal = false;
        $this->showingDetailRabpModal = false;
        $this->showingRabpMaterialModal = false;
    }

    // public function storeRabp()
    // {
    //     BudgetPlan::create([
    //         'budget_plan_code' => $this->budget_plan_code,
    //         'description' => $this->description,
    //         'date' => $this->currentDate,
    //         'quotations_id' => $this->quotations_id,
    //         'status_id' => 1,
    //         'users_id' => Auth::user()->id,
    //     ]);

    //     $this->reset();
    //     $this->showingRabpModal = false;

    //     $this->dispatchBrowserEvent('store-success');
    // }

    public function showRabpEditModal($id) 
    {
        $this->rabp = BudgetPlan::findOrFail($id);
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

        $this->reset();
        $this->showingRabpModal = false;

        $this->dispatchBrowserEvent('update-success');
    }

    public function detailRabp($id)
    {
        $this->rabp = BudgetPlan::findOrFail($id);
        $this->quotation_code = $this->rabp->quotation['quotation_code'];
        $this->quotation_date = $this->rabp->quotation['date'];
        $this->quotation_name = $this->rabp->quotation['name'];
        $this->quotation_customer = $this->rabp->quotation->customer['name'];

        $this->budget_plan_code = $this->rabp->budget_plan_code;
        $this->description = $this->rabp->description;
        $this->currentDate = $this->rabp->date;
        $this->status_id = $this->rabp->status['name'];
        $this->users_id = $this->rabp->user['name'];

        $this->totalRap = DetailBillMaterial::where('bill_materials_id','=',$id)->first(['total_price_rap'])->total_price_rap;
        // $this->totalProfit = $calculateProfit;
        $this->totalPPN = ($this->ppn * 0.01) * ($this->totalRap);
        $this->overhead_cost = DetailBillMaterial::where('bill_materials_id','=',$id)->first(['overhead_cost'])->overhead_cost;
        $this->preliminary_cost = DetailBillMaterial::where('bill_materials_id','=',$id)->first(['preliminary_cost'])->preliminary_cost;
        $this->totalRabp = DetailBillMaterial::where('bill_materials_id','=',$id)->first(['total_price_rabp'])->total_price_rabp;

        $this->showingDetailRabpModal = true;
    }

    public function deleteRabp($id)
    {
        $rabp = BudgetPlan::find($id);
        $rabp->delete();

        $this->dispatchBrowserEvent('delete-success');
    }

    // --- MATERIAL RABP ---
    public function showRabpMaterial($id)
    {
        // Set default rabp material
        $this->budget_plans_id = $id;
        $this->materials_id = 1;
        $this->quantity = 1;
        $this->price = Material::where('id', '=', $this->materials_id)->first(['price'])->price;
        $this->total_price = Material::where('id', '=', $this->materials_id)->first(['price'])->price;

        // Save value nilai detail rabp material jika ada
        $this->overhead_cost = DetailBillMaterial::where("bill_materials_id", '=', $id)->first(['overhead_cost'])->overhead_cost;
        $this->preliminary_cost = DetailBillMaterial::where("bill_materials_id", '=', $id)->first(['preliminary_cost'])->preliminary_cost;
        $this->profit = DetailBillMaterial::where("bill_materials_id", '=', $id)->first(['profit'])->profit;

        $this->showingRabpMaterialModal = true;
    }

    public function storeRabpMaterial()
    {
        DB::transaction(function() {
            $getBillMaterialId = BillMaterial::create([
                'budget_plans_id' => $this->budget_plans_id,
                'materials_id' => $this->materials_id,
                'quantity' => $this->quantity,
                'price' => $this->price,
                'total_price' => $this->total_price,
            ]);

            $calculateTotalRap = BillMaterial::where('budget_plans_id','=',$this->budget_plans_id)->sum('total_price');
            $calculateProfit = ($this->profit * 0.01) * ($calculateTotalRap);
            $calculatePPN = ($this->ppn * 0.01) * ($calculateTotalRap);
            // dd($getBillMaterialId->budget_plans_id);

            // // dd($checkExist = DetailBillMaterial::where('bill_materials_id', '=', $this->budget_plans_id)->first('bill_materials_id')->bill_materials_id);
            $checkExist = DetailBillMaterial::select('bill_materials_id')->where('bill_materials_id',$this->budget_plans_id)->exists();
            if($checkExist == false) {
                DetailBillMaterial::create([
                    'bill_materials_id' => $getBillMaterialId->budget_plans_id,
                    'total_price_rap' => $calculateTotalRap,
                    'overhead_cost' => $this->overhead_cost,
                    'preliminary_cost' => $this->preliminary_cost,
                    'profit' => $this->profit,
                    'ppn' => $this->ppn,
                    'total_price_rabp' => ($calculateTotalRap + $this->overhead_cost + $this->preliminary_cost) + ($calculateProfit) + ($calculatePPN),
                ]);
            };
        });

        $this->dispatchBrowserEvent('store-success');
        $this->materials_id = 1;
        $this->quantity = 1;
        $this->price = Material::where('id', '=', $this->materials_id)->first(['price'])->price;
        $this->total_price = Material::where('id', '=', $this->materials_id)->first(['price'])->price;
    }

    // Realtime update value input
    public function updated($key, $value)
    {
        if (in_array($key,['quantity','price','materials_id'])) {
            $this->price = Material::where('id', '=', $this->materials_id)->first(['price'])->price;
            $this->total_price = $this->quantity * $this->price;
        }
    }
}
