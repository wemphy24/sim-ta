<?php

namespace App\Http\Livewire;

use App\Models\Customer;
use Livewire\Component;
use Livewire\WithPagination;

class CustomerIndex extends Component
{
    use WithPagination;
    public $search = '';
    public $showPage = 15;
    public $searchBy = 'name';
    public $orderAsc = true;

    public $showingCustomerModal = false;
    public $isEditMode = false;
    public $name, $email, $phone, $address;   

    public $customer; 

    public function render()
    {
        return view('livewire.customer-index', [
            'customers' => Customer::search(trim($this->search))->orderBy($this->searchBy,$this->orderAsc ? 'asc' : 'desc')->paginate($this->showPage),
        ])->layout('layouts.admin');
    }

    public function closeModal()
    {
        $this->showingCustomerModal = false;
    }

    public function showCustomerModal()
    {
        $this->reset();
        $this->showingCustomerModal = true;
    }

    public function showCustomerEditModal($id)
    {
        $this->customer = Customer::findOrFail($id);
        $this->name = $this->customer->name;
        $this->email = $this->customer->email;
        $this->phone = $this->customer->phone;
        $this->address = $this->customer->address;

        $this->showingCustomerModal = true;
        $this->isEditMode = true;
    }

    public function storeCustomer()
    {
        Customer::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
        ]);
        
        $this->reset();
        $this->closeModal();

        $this->dispatchBrowserEvent('store-success');
    }

    public function updateCustomer()
    {
        $this->customer->update([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
        ]);

        $this->reset();
        $this->showingCustomerModal = false;

        $this->dispatchBrowserEvent('update-success');
    }

    public function deleteCustomer($id)
    {
        $customer = Customer::find($id);
        $customer->delete();

        $this->dispatchBrowserEvent('delete-success');
    }
}
