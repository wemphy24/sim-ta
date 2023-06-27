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
        'set_goods_id', 
        'retur_code', 
        'materials_id',
        'qty', 
        'price', 
        'status_id',  
        'users_id',  
        'updated_at',
        'created_at',
    ];
}
