<?php

namespace App\Http\Livewire;

use App\Models\Customer;
use App\Models\Quotation;
use App\Models\Supplier;
use Livewire\Component;

class DashboardIndex extends Component
{
    public function render()
    {
        return view('livewire.dashboard-index', [
            'customers' => Customer::count(),
            'suppliers' => Supplier::count(),
            'quotations' => Quotation::count(),
        ])->layout('layouts.admin');
    }
}
