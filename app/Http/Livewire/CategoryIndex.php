<?php

namespace App\Http\Livewire;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class CategoryIndex extends Component
{   
    use WithPagination;
    public $showPage = 15;

    public $showingCategoryModal = false;
    public $isEditMode = false;
    public $name;   

    public $category;   

    public function render()
    {
        return view('livewire.category-index', [
            'categories' => Category::latest()->paginate($this->showPage),
        ])->layout('layouts.admin');
    }

    public function showCategoryModal()
    {
        $this->reset();
        $this->showingCategoryModal = true;
    }

    public function closeModal()
    {
        $this->showingCategoryModal = false;
    }

    public function showCategoryEditModal($id)
    {
        $this->category = Category::findOrFail($id);
        $this->name = $this->category->name;

        $this->showingCategoryModal = true;
        $this->isEditMode = true;
    }

    public function storeCategory()
    {
        Category::create([
            'name' => $this->name
        ]);

        $this->reset();
        $this->showingCategoryModal = false;

        $this->dispatchBrowserEvent('store-success');
    }

    public function updateCategory()
    {
        $this->category->update([
            'name' => $this->name
        ]);

        $this->reset();
        $this->closeModal();

        $this->dispatchBrowserEvent('update-success');
    }

    public function deleteCategory($id)
    {
        $category = Category::find($id);
        $category->delete();

        $this->dispatchBrowserEvent('delete-success');
    }
}
