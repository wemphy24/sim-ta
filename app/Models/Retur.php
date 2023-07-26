<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Retur extends Model
{
    // use HasFactory;
    public $table = 'returs';

    protected $dates = [
        'updated_at',
        'created_at',
    ];

    protected $fillable = [
        // 'set_goods_id', 
        'goods_id', 
        'retur_code', 
        'materials_id',
        'qty', 
        'price', 
        'retur_date', 
        'status_id',  
        'users_id',  
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

    public function material()
    {
        return $this->belongsTo('App\Models\Material', 'materials_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo('App\Models\Status', 'status_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'users_id', 'id');
    }

    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        $query->where(function($query) use ($term) {
            $query->where('retur_code', 'like', $term)
            ->orWhere('retur_date', 'like', $term)
            ->orWhere('qty', 'like', $term)
            ->orWhereHas('good', function($query) use ($term) {
                $query->where('name', 'like', $term);
            })
            ->orWhereHas('material', function($query) use ($term) {
                $query->where('name', 'like', $term);
            })
            ->orWhereHas('status', function($query) use ($term) {
                $query->where('name', 'like', $term);
            });
        });
    }
}
