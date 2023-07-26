<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RabpMaterial extends Model
{
    public $table = 'rabp_materials';

    protected $dates = [
        'updated_at',
        'created_at',
    ];

    protected $fillable = [
        'rabps_id', 
        'goods_id', 
        'materials_id', 
        'qty', 
        'price', 
        'total_price', 
        'qty_received', 
        'qty_install', 
        'qty_remaining', 
        'status', 
        'updated_at',
        'created_at',
    ];

    public function rabp()
    {
        return $this->belongsTo('App\Models\Rabp', 'rabps_id', 'id');
    }

    public function good()
    {
        return $this->belongsTo('App\Models\Good', 'goods_id', 'id');
    }

    public function material()
    {
        return $this->belongsTo('App\Models\Material', 'materials_id', 'id');
    }
}
