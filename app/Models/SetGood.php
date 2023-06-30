<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SetGood extends Model
{
    // use HasFactory;
    public $table = 'set_goods';

    protected $dates = [
        'updated_at',
        'created_at',
    ];

    protected $fillable = [
        'categories_id', 
        'measurements_id', 
        'quotations_id', // Tambahan
        'set_goods_code', 
        'name', 
        'qty', 
        'price', 
        'status', 
        'status_delivery', 
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

    public function quotation() // Tambahan
    {
        return $this->belongsTo('App\Models\Quotation', 'quotations_id', 'id');
    }

    public function set_bill_material()
    {
        return $this->hasOne('App\Models\SetBillMaterial', 'set_goods_id');
    }

    public function detail_rabp()
    {
        return $this->hasMany('App\Models\DetailRabp', 'set_goods_id');
    }

    public function logistic_material()
    {
        return $this->hasMany('App\Models\LogisticMaterial', 'set_goods_id');
    }

    public function retur()
    {
        return $this->hasMany('App\Models\Retur', 'set_goods_id');
    }

    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        $query->where(function($query) use ($term) {
            $query->where('set_goods_code', 'like', $term)
            ->orWhere('name', 'like', $term)
            ->orWhere('qty', 'like', $term)
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
