<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class ProductionIndex extends Component
{
    use WithPagination;
    public $search = '';
    public $showPage = 15;
    public $searchBy = 'material_code';
    public $orderAsc = true;

    public function render()
    {
        return view('livewire.production-index', [

        ])->layout('layouts.admin');
    }
}
