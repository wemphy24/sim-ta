<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    // use HasFactory;
    public $table = 'materials';

    protected $dates = [
        'updated_at',
        'created_at',
    ];

    protected $fillable = [
        'categories_id', 
        'measurements_id', 
        'material_code', 
        'name', 
        'stock', 
        'price', 
        'old_price', 
        'change_price', 
        'min_stock', 
        'max_stock', 
        'pr_status', 
        'price_approval', 
        'updated_at',
        'created_at',
    ];

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'categories_id', 'id');
    }

    public function measurement()
    {
        return $this->belongsTo('App\Models\Measurement', 'measurements_id', 'id');
    }

    public function bill_material()
    {
        return $this->hasMany('App\Models\BillMaterial', 'materials_id');
    }

    public function set_bill_material()
    {
        return $this->hasMany('App\Models\SetBillMaterial', 'materials_id');
    }

    public function logistic_material()
    {
        return $this->hasMany('App\Models\LogisticMaterial', 'materials_id');
    }

    public function purhcase_request()
    {
        return $this->hasMany('App\Models\PurchaseRequest', 'materials_id');
    }

    public function detail_po()
    {
        return $this->hasMany('App\Models\DetailPO', 'materials_id');
    }

    public function good_receive()
    {
        return $this->hasMany('App\Models\GoodReceive', 'materials_id');
    }

    public function retur()
    {
        return $this->hasMany('App\Models\Retur', 'materials_id');
    }

    // AFTER REVISION
    public function billmaterial()
    {
        return $this->hasMany('App\Models\BillMaterial', 'materials_id');
    }

    public function rabp_material()
    {
        return $this->hasMany('App\Models\RabpMaterial', 'materials_id');
    }

    

    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        $query->where(function($query) use ($term) {
            $query->where('material_code', 'like', $term)
            ->orWhere('name', 'like', $term)
            ->orWhere('stock', 'like', $term)
            ->orWhere('price', 'like', $term)
            ->orWhereHas('category', function($query) use ($term) {
                $query->where('name', 'like', $term);
            })
            ->orWhereHas('measurement', function($query) use ($term) {
                $query->where('name', 'like', $term);
            });
        });
    }
}
