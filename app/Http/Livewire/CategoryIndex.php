<?php

namespace App\Http\Livewire;

use App\Models\Category;
use Livewire\Component;

class CategoryIndex extends Component
{   
    public $showingCategoryModal = false;
    public $isEditMode = false;
    public $name;   

    public $category;   

    public function render()
    {
        return view('livewire.category-index', [
            'categories' => Category::all(),
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
        // dd($this->category);
        $this->category->update([
            'name' => $this->name
        ]);

        $this->reset();
        $this->showingCategoryModal = false;

        $this->dispatchBrowserEvent('update-success');
    }

    public function deleteCategory($id)
    {
        $category = Category::find($id);
        $category->delete();

        $this->dispatchBrowserEvent('delete-success');
    }
}
