<?php

namespace App\Http\Livewire;

use App\Models\BudgetPlan;
use App\Models\Quotation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class RabpIndex extends Component
{
    use WithPagination;
    public $search;
    public $showPage;

    public $showingRabpModal = false;
    public $showingDetailRabpModal = false;
    public $isEditMode = false;
    public $budget_plan_code, $description, $quotations_id, $status_id, $users_id;

    public $rabp;
    public $currentDate;

    public function mount()
    {
        // Set default value untuk fitur tampilkan halaman
        $this->showPage = 5;
    }

    public function render()
    {
        return view('livewire.rabp-index', [
            'rabps' => BudgetPlan::latest()->paginate(5),
            'quotations' => Quotation::all(),
        ])->layout('layouts.admin');
    }

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
    }

    public function storeRabp()
    {
        BudgetPlan::create([
            'budget_plan_code' => $this->budget_plan_code,
            'description' => $this->description,
            'date' => $this->currentDate,
            'quotations_id' => $this->quotations_id,
            'status_id' => 1,
            'users_id' => Auth::user()->id,
        ]);

        $this->reset();
        $this->showingRabpModal = false;

        $this->dispatchBrowserEvent('store-success');
    }

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
        $this->rabp = Quotation::findOrFail($id);
        $this->quotation_code = $this->rabp->quotation_code;
        $this->budget_plan_code = $this->rabp->budget_plan['budget_plan_code'];
        $this->description = $this->rabp->budget_plan['description'];
        $this->currentDate = $this->rabp->budget_plan['date'];
        $this->status_id = $this->rabp->budget_plan->status['name'];
        $this->users_id = $this->rabp->budget_plan->user['name'];

        $this->showingDetailRabpModal = true;
    }

    public function deleteRabp($id)
    {
        $rabp = BudgetPlan::find($id);
        $rabp->delete();

        $this->dispatchBrowserEvent('delete-success');
    }
}
