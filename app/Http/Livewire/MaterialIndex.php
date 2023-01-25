<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Material;
use App\Models\Measurement;
use Livewire\Component;

class MaterialIndex extends Component
{
    public $showingMaterialModal = false;
    public $isEditMode = false;
    public $categories_id, $measurements_id, $material_code, $name, $stock, $price, $min_stock, $max_stock;

    public $material;

    public function render()
    {
        return view('livewire.material-index', [
            'materials' => Material::all(),
            'categories' => Category::all(),
            'measurements' => Measurement::all(),
        ])->layout('layouts.admin');
    }

    public function showMaterialModal()
    {
        $this->reset();
        $this->showingMaterialModal = true;
    }

    public function closeModal()
    {
        $this->showingMaterialModal = false;
    }

    public function storeMaterial()
    {
        Material::create([
            'categories_id' => $this->categories_id,
            'measurements_id' => $this->measurements_id,
            'material_code' => $this->material_code,
            'name' => $this->name,
            'stock' => $this->stock,
            'price' => $this->price,
            'min_stock' => $this->min_stock,
            'max_stock' => $this->max_stock,
        ]);

        $this->reset();
        $this->closeModal();

        $this->dispatchBrowserEvent('store-success');
    }

    public function showMaterialEditModal($id)
    {
        $this->material = Material::findOrFail($id);
        $this->categories_id = $this->material->category['id'];
        $this->measurements_id = $this->material->measurement['id'];
        $this->material_code = $this->material->material_code;
        $this->name = $this->material->name;
        $this->stock = $this->material->stock;
        $this->price = $this->material->price;
        $this->min_stock = $this->material->min_stock;
        $this->max_stock = $this->material->max_stock;

        $this->showingMaterialModal = true;
        $this->isEditMode = true;
    }

    public function updateMaterial()
    {
        $this->material->update([
            'categories_id' => $this->categories_id,
            'measurements_id' => $this->measurements_id,
            'material_code' => $this->material_code,
            'name' => $this->name,
            'stock' => $this->stock,
            'price' => $this->price,
            'min_stock' => $this->min_stock,
            'max_stock' => $this->max_stock,
        ]);

        $this->reset();
        $this->closeModal();

        $this->dispatchBrowserEvent('update-success');
    }

    public function deleteMaterial($id)
    {
        $material = Material::find($id);
        $material->delete();

        $this->dispatchBrowserEvent('delete-success');
    }

    public function updated($key, $value)
    {
        // Realtime update value
        $countMaterial = Material::count();
        $getLastMaterialCode = Material::all()->last();
        if($countMaterial == 0) {
            if($this->categories_id == 1) {
                $this->material_code = "BB.00" . 1;
            } else if($this->categories_id == 2) {
                $this->material_code = "BP.00" . 1;
            } else {
                $this->material_code = "BJ.00" . 1;
            }
        } else {
            if($this->categories_id == 1) {
                $this->material_code = "BB.00" . (int)substr($getLastMaterialCode->material_code, -2) + 1;
            } else if($this->categories_id == 2) {
                $this->material_code = "BP.00" . (int)substr($getLastMaterialCode->material_code, -2) + 1;
            } else {
                $this->material_code = "BJ.00" . (int)substr($getLastMaterialCode->material_code, -2) + 1;
            }
        }
        
    }
}
