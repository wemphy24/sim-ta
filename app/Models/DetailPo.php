<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPo extends Model
{
    // use HasFactory;
    public $table = 'detail_pos';

    protected $dates = [
        'updated_at',
        'created_at',
    ];

    protected $fillable = [
        'purchase_orders_id', 
        'materials_id',
        'qty', 
        'price', 
        'total_price', 
        'status',  
        'updated_at',
        'created_at',
    ];

    public function material()
    {
        return $this->belongsTo('App\Models\Material', 'materials_id', 'id');
    }
}
