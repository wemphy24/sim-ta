<?php

namespace App\Http\Livewire;

use App\Models\Contract;
use App\Models\Production;
use Livewire\Component;
use Livewire\WithPagination;

class ContractIndex extends Component
{
    use WithPagination;
    public $search = '';
    public $showPage = 15;
    public $searchBy = 'contract_code';
    public $orderAsc = true;

    public $showingMainPage = true;
    public $showingDetail = false;

    // Tabel contract
    public $quotations_id, $contract_code, $name, $contract_value, $finish_date, $status_id, $users_id;

    public $contract;

    public function render()
    {
        return view('livewire.contract-index', [
            'contracts' => Contract::with('quotation','status')->search(trim($this->search))->orderBy($this->searchBy,$this->orderAsc ? 'asc' : 'desc')->paginate($this->showPage),
        ])->layout('layouts.admin');
    }

    public function back()
    {
        // Menutup detail page dan menampilkan main page
        $this->showingDetail = false;
        $this->showingMainPage = true;
    }

    // DETAILS SECTION --------------------------------
    public function detail($id)
    {
        // Menampilkan detail page
        $this->showingDetail = true;
        $this->showingMainPage = false;

        // $this->contract = Production::findOrFail($id);
        // $this->quotations_id = $this->contract->quotation;
        // $this->production_code = $this->production->production_code;
        // $this->name = $this->production->name;
        // $this->description = $this->production->description;
        // $this->deadline = $this->production->deadline;
        // $this->status_id = $this->production->status_id;
        // $this->users_id = $this->production->users_id;
    }

}
