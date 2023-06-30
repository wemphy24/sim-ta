<?php

namespace App\Http\Livewire;

use App\Models\Customer;
use App\Models\Delivery;
use App\Models\Inquiry;
use App\Models\LogisticGood;
use App\Models\LogisticMaterial;
use App\Models\Production;
use App\Models\PurchaseOrder;
use App\Models\QualityControl;
use App\Models\Quotation;
use App\Models\Rabp;
use App\Models\Retur;
use App\Models\Supplier;
use Livewire\Component;
use Livewire\WithPagination;

class DashboardIndex extends Component
{
    use WithPagination;
    public $search = '';
    public $showPage = 15;
    public $searchBy = 'rabp_code';
    public $orderAsc = true;
    public function render()
    {
        return view('livewire.dashboard-index', [
            'inquiries' => Inquiry::count(),
            'quotations' => Quotation::where('status_id', '=', 1)->count(),
            'rabpss' => Rabp::where('status_id', '=', 1)->count(),
            'rabps' => Rabp::with('quotation','status')->search(trim($this->search))->orderBy($this->searchBy,$this->orderAsc ? 'asc' : 'desc')->paginate($this->showPage),
            'productions' => Production::where('status_id', '=', 3)->count(),
            'purchaseorders' => PurchaseOrder::where('status_id', '=', 2)->count(),
            'deliverys' => Delivery::where('status_id', '=', 2)->count(),
            'logistics' => LogisticMaterial::where('status_id', '=', 1)->count(),
            'returs' => Retur::where('status_id', '=', 1)->count(),
            'qualitycontrols' => QualityControl::where('status_id', '=', 1)->count(),
        ])->layout('layouts.admin');
    }
}
