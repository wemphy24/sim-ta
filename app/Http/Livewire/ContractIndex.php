<?php

namespace App\Http\Livewire;

use App\Models\Contract;
use App\Models\DetailRabp;
use App\Models\Production;
use App\Models\Quotation;
use App\Models\RabpCost;
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
    public $quotations_id, $contract_code, $name, $contract_value, $start_date, $finish_date, $status_id, $users_id;

    public $contract;

    public $total_price;

    public function render()
    {
        return view('livewire.contract-index', [
            'contracts' => Contract::with('quotation','status')->search(trim($this->search))->orderBy($this->searchBy,$this->orderAsc ? 'asc' : 'desc')->paginate($this->showPage),
            'quotations' => Quotation::all(),
            'detailrabps' => DetailRabp::where('rabps_id','=',$this->quotations_id)->get(),
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

        $this->contract = Contract::findOrFail($id);
        $this->contract_code = $this->contract->contract_code;
        $this->name = $this->contract->name;
        $this->quotations_id = $this->contract->quotation['id'];
        $this->contract_value = $this->contract->contract_value;
        $this->start_date = $this->contract->start_date;
        $this->finish_date = $this->contract->finish_date;
        $this->status_id = $this->contract->status['name'];
        // $this->total_price = RabpCost::where('rabps_id', '=', $this->quotations_id)->first('total_price')->total_price;
    }
    // END --------------------------------

    public function updateContract()
    {
        $this->contract->update([
            'name' => $this->name,
        ]);

        $this->reset();
        $this->dispatchBrowserEvent('store-success');
    }
}
