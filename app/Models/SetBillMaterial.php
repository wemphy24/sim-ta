<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SetBillMaterial extends Model
{
    // use HasFactory;
    public $table = 'set_bill_materials';

    protected $dates = [
        'updated_at',
        'created_at',
    ];

    protected $fillable = [
        'set_goods_id', 
        'materials_id', 
        'qty', 
        'price', 
        'total_price', 
        'qty_received', 
        'qty_install', 
        'qty_remaining', 
        'updated_at',
        'created_at',
    ];

    public function set_good()
    {
        return $this->belongsTo('App\Models\SetGood', 'set_goods_id', 'id');
    }

    public function material()
    {
        return $this->belongsTo('App\Models\Material', 'materials_id', 'id');
    }
}
