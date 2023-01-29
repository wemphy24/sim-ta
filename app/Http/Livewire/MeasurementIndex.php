<?php

namespace App\Http\Livewire;

use App\Models\Measurement;
use Livewire\Component;
use Livewire\WithPagination;

class MeasurementIndex extends Component
{
    use WithPagination;
    public $showPage = 15;

    public $showingMeasurementModal = false;
    public $isEditMode = false;
    public $name;

    public $measurement;

    public function render()
    {
        return view('livewire.measurement-index', [
            'measurements' => Measurement::latest()->paginate($this->showPage),
        ])->layout('layouts.admin');
    }

    public function showMeasurementModal()
    {
        $this->reset();
        $this->showingMeasurementModal = true;
    }

    public function closeModal()
    {
        $this->showingMeasurementModal = false;
    }

    public function storeMeasurement()
    {
        Measurement::create([
            'name' => $this->name
        ]);

        $this->reset();
        $this->closeModal();

        $this->dispatchBrowserEvent('store-success');
    }

    public function showMeasurementEditModal($id)
    {
        $this->measurement = Measurement::findOrFail($id);
        $this->name = $this->measurement->name;

        $this->showingMeasurementModal = true;
        $this->isEditMode = true;
    }

    public function updateMeasurement()
    {
        $this->measurement->update([
            'name' => $this->name
        ]);

        $this->reset();
        $this->closeModal();

        $this->dispatchBrowserEvent('update-success');
    }

    public function deleteMeasurement($id)
    {
        $measurement = Measurement::find($id);
        $measurement->delete();

        $this->dispatchBrowserEvent('delete-success');
    }
}
