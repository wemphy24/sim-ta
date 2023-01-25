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
        'set_goods_code', 
        'name', 
        'qty', 
        'price', 
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

    public function set_bill_material()
    {
        return $this->hasOne('App\Models\SetBillMaterial', 'set_goods_id');
    }

    public function detail_rabp()
    {
        return $this->hasMany('App\Models\DetailRabp', 'set_goods_id');
    }
}
