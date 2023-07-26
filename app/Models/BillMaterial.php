<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillMaterial extends Model
{
    public $table = 'bill_materials';

    protected $dates = [
        'updated_at',
        'created_at',
    ];

    protected $fillable = [
        'goods_id', 
        'materials_id', 
        'qty', 
        'price', 
        'total_price', 
        'qty_received', 
        'qty_install', 
        'qty_remaining', 
        'status', 
    ];

    public function good()
    {
        return $this->belongsTo('App\Models\Good', 'goods_id', 'id');
    }

    public function material()
    {
        return $this->belongsTo('App\Models\Material', 'materials_id', 'id');
    }
}
