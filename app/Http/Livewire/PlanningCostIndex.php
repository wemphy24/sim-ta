<?php

namespace App\Http\Livewire;

use App\Models\FinishGood;
use App\Models\Material;
use App\Models\Measurement;
use App\Models\PlanningCost;
use App\Models\Quotation;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class PlanningCostIndex extends Component
{
    use WithPagination;
    public $search;
    public $showPage;

    public $showingPlanningModal = false;
    public $showingDetailPlanningModal = false;
    public $showingItemModal = false;
    public $showKeyword = false;
    public $isEditMode = false;

    public $quotations_id, $rabp_code, $rap_code, $name, $description, $date, $status_id, $users_id;
    public $planning;

    public $planning_costs_id, $name_finish_goods, $qty, $price, $categories_id, $measurements_id;
    
    public $keyword;
    public $results;
    protected $queryString = ['keyword'];

    public function mount()
    {
        // Set default value untuk fitur tampilkan halaman
        $this->showPage = 5;
    }

    public function render()
    {
        // Autocomplete search nama material
        if (strlen($this->keyword) > 2) {
            $this->results = Material::where('name', 'LIKE', "%".$this->keyword."%")->get(['name']);
        }

        // Checking value set barang
        if($this->keyword == NULL) {
            $this->measurements_id = NULL;
            $this->price = NULL;
        }

        return view('livewire.planning-cost-index',[
        'planning_costs' => PlanningCost::latest()->paginate($this->showPage),
        'quotations' => Quotation::all(),
        'measurements' => Measurement::all(),
        ])->layout('layouts.admin');
    }

    public function closeModal()
    {
        $this->showingPlanningModal = false;
        $this->showingDetailPlanningModal = false;
        $this->showingItemModal = false;
        $this->keyword = null;
    }

    public function createRabpCode() 
    {
        $countRabp = PlanningCost::count();
        $getTimeNow = Carbon::now();
        if($countRabp == 0) {
            $this->rabp_code = 'RABP.' . ($getTimeNow->day) . "." . ($getTimeNow->month) . "." . ($getTimeNow->year) . '.' . 1001;
        } else {
            $getLastRabp = PlanningCost::all()->last();
            $convertRabp = (int)substr($getLastRabp->rabp_code, -4) + 1;
            $this->rabp_code = 'RABP.' . ($getTimeNow->day) . "." . ($getTimeNow->month) . "." . ($getTimeNow->year) . '.' . $convertRabp;
        }
    }

    public function showPlanningModal() 
    {
        $this->reset();
        $this->showingPlanningModal = true;
        $this->date = Carbon::now()->format('Y-m-d');
        $this->createRabpCode();
        $this->description = 'Menunggu Review';
    }

    public function showPlanningEditModal($id)
    {
        $this->showingPlanningModal = true;
        $this->isEditMode = true;

        $this->planning = PlanningCost::findOrFail($id);
        $this->quotations_id = $this->planning->quotations_id;
        $this->rabp_code = $this->planning->rabp_code;
        $this->name = $this->planning->name;
        $this->description = $this->planning->description;
        $this->date = $this->planning->date;
    }

    public function storePlanning()
    {
        $this->validate([
            'quotations_id' => 'required',
            'rabp_code' => 'required|string|max:60',
            'name' => 'required',
            'date' => 'required|date',
        ]);

        PlanningCost::create([
            'quotations_id' => $this->quotations_id,
            'rabp_code' => $this->rabp_code,
            'rap_code' => NULL,
            'name' => $this->name,
            'description' => $this->description,
            'date' => $this->date,
            'status_id' => 1,
            'users_id' => Auth::user()->id,
        ]);
        
        $this->showingPlanningModal = false;
    }

    public function updatePlanning() 
    {
        $this->validate([
            'quotations_id' => 'required',
            'rabp_code' => 'required',
            'name' => 'required|string|max:60',
            'description' => 'required',
            'date' => 'required|date',
            'customers_id' => 'required',
        ]);

        $this->planning->update([
            'name' => $this->name,
            'description' => $this->description,
        ]);

        $this->showingPlanningModal = false;
        $this->dispatchBrowserEvent('update-success');
    }

    public function updated($key, $value)
    {
        if($this->quotations_id != NULL) {
            $this->name = 'Rancangan Anggaran' ." ". Quotation::where('id','=',$this->quotations_id)->first(['name'])->name;
        } else {
            $this->name = NULL;
        }
    }

    public function showItemModal($id)
    {
        $this->reset();
        $this->showingItemModal = true;
        $this->showKeyword = true;


            $this->measurements_id = "PEPEK";
        
    }

    public function setItem()
    {
    }

    public function updateKeyword($selectKeyword) {
        $this->keyword = $selectKeyword;
        $this->measurements_id = Material::where('name','=',$this->keyword)->first(['measurements_id'])->measurements_id;
        $this->price = Material::where('name','=',$this->keyword)->first(['price'])->price;
        // if($this->keyword != "") {
        //     $this->showKeyword = false;
        // } 
    }
}
