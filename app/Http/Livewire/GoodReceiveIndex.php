<?php

namespace App\Http\Livewire;

use App\Models\GoodReceive;
use Livewire\Component;
use Livewire\WithPagination;

class GoodReceiveIndex extends Component
{
    use WithPagination;
    public $search = '';
    public $showPage = 15;
    public $searchBy = 'good_receive_code';
    public $orderAsc = true;

    public $showingMainPage = true;
    public function render()
    {
        return view('livewire.good-receive-index', [
            // 'goodreceives' => GoodReceive::all(),
        ])->layout('layouts.admin');
    }
}
