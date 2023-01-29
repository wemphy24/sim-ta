<?php

namespace App\Http\Livewire;

use App\Models\Supplier;
use Livewire\Component;
use Livewire\WithPagination;

class SupplierIndex extends Component
{
    use WithPagination;
    public $search = '';
    public $showPage = 15;
    public $searchBy = 'name';
    public $orderAsc = true;

    public $showingSupplierModal = false;
    public $isEditMode = false;
    public $name, $email, $phone, $address;

    public $supplier;

    public function render()
    {
        return view('livewire.supplier-index', [
            'suppliers' => Supplier::search(trim($this->search))->orderBy($this->searchBy,$this->orderAsc ? 'asc' : 'desc')->paginate($this->showPage),
        ])->layout('layouts.admin');
    }

    public function showSupplierModal()
    {
        $this->reset();
        $this->showingSupplierModal = true;
    }

    public function closeModal()
    {
        $this->showingSupplierModal = false;
    }

    public function storeSupplier()
    {
        Supplier::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
        ]);

        $this->reset();
        $this->closeModal();

        $this->dispatchBrowserEvent('store-success');
    }

    public function showSupplierEditModal($id)
    {
        $this->supplier = Supplier::findOrFail($id);
        $this->name = $this->supplier->name;
        $this->email = $this->supplier->email;
        $this->phone = $this->supplier->phone;
        $this->address = $this->supplier->address;

        $this->showingSupplierModal = true;
        $this->isEditMode = true;
    }

    public function updateSupplier()
    {
        $this->supplier->update([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
        ]);

        $this->reset();
        $this->showingSupplierModal = false;

        $this->dispatchBrowserEvent('update-success');
    }

    public function deleteSupplier($id)
    {
        $supplier = Supplier::find($id);
        $supplier->delete();

        $this->dispatchBrowserEvent('delete-success');
    }
}
