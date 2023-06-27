<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoodReceive extends Model
{
    // use HasFactory;
    public $table = 'good_receives';

    protected $dates = [
        'updated_at',
        'created_at',
    ];

    protected $fillable = [
        'purchase_orders_id', 
        'good_receive_code', 
        'materials_id',
        'qty', 
        'price', 
        'print_date', 
        'suppliers_id',  
        'status_id',  
        'users_id',  
        'updated_at',
        'created_at',
    ];
}
