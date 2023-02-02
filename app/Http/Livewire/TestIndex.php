<?php

namespace App\Http\Livewire;

use Livewire\Component;

class TestIndex extends Component
{   
    public function render()
    {
        return view('livewire.test-index', [

        ])->layout('layouts.admin');
    }
}
