<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    // use HasFactory;
    public $table = 'suppliers';

    protected $dates = [
        'updated_at',
        'created_at',
    ];

    protected $fillable = [
        'name', 
        'email', 
        'phone', 
        'address', 
        'updated_at',
        'created_at',
    ];
}
