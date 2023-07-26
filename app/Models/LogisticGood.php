<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogisticGood extends Model
{
    // use HasFactory;
    public $table = 'logistic_goods';

    protected $dates = [
        'updated_at',
        'created_at',
    ];

    protected $fillable = [
        // 'set_goods_id', 
        'goods_id', 
        'categories_id', 
        'measurements_id', 
        'logistic_good_code', 
        // 'materials_id',
        'qty_ask', 
        'qty_stock', 
        'price', 
        'type', 
        'users_id', 
        'status_id', 
        'updated_at',
        'created_at',
    ];

    // public function set_good()
    // {
    //     return $this->belongsTo('App\Models\SetGood', 'set_goods_id', 'id');
    // }

    public function good()
    {
        return $this->belongsTo('App\Models\Good', 'goods_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'categories_id', 'id');
    }

    public function measurement()
    {
        return $this->belongsTo('App\Models\Measurement', 'measurements_id', 'id');
    }

    // public function material()
    // {
    //     return $this->belongsTo('App\Models\Material', 'materials_id', 'id');
    // }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'users_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo('App\Models\Status', 'status_id', 'id');
    }

    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        $query->where(function($query) use ($term) {
            $query->where('logistic_good_code', 'like', $term)
            ->orWhere('type', 'like', $term)
            ->orWhereHas('good', function($query) use ($term) {
                $query->where('name', 'like', $term);
            })
            ->orWhereHas('status', function($query) use ($term) {
                $query->where('name', 'like', $term);
            });
        });
    }
}
