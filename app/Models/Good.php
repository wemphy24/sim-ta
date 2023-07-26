<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Good extends Model
{
    public $table = 'goods';

    protected $dates = [
        'updated_at',
        'created_at',
    ];

    protected $fillable = [
        'good_code', 
        'name', 
        'stock', 
        'price', 
        'sell_price', 
        'categories_id', 
        'measurements_id', 
        'customers_id', 
        // 'status_id', 
        'status_production', 
        'status_delivery', 
        'status_qc', 
        'start_prod', 
        'end_prod', 
        'users_id', 
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

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer', 'customers_id', 'id');
    }

    // public function status()
    // {
    //     return $this->belongsTo('App\Models\Status', 'status_id', 'id');
    // }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'users_id', 'id');
    }
    
    public function cost()
    {
        return $this->hasMany('App\Models\Cost', 'goods_id');
    }

    public function billmaterial()
    {
        return $this->hasMany('App\Models\BillMaterial', 'goods_id');
    }

    public function detailrabp()
    {
        return $this->hasMany('App\Models\DetailRabp', 'goods_id');
    }

    public function rabp_material()
    {
        return $this->hasMany('App\Models\RabpMaterial', 'goods_id');
    }

    public function logistic_material()
    {
        return $this->hasMany('App\Models\LogisticMaterial', 'goods_id'); 
    }

    public function logistic_good()
    {
        return $this->hasMany('App\Models\LogisticGood', 'goods_id'); 
    }

    public function retur()
    {
        return $this->hasMany('App\Models\Retur', 'goods_id');
    }

    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        $query->where(function($query) use ($term) {
            $query->where('good_code', 'like', $term)
            ->orWhere('name', 'like', $term)
            // ->orWhereHas('status', function($query) use ($term) {
            //     $query->where('name', 'like', $term);
            // })
            ->orWhereHas('category', function($query) use ($term) {
                $query->where('name', 'like', $term);
            });
        });
    }
}
