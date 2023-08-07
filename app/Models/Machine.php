<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    // use HasFactory;
    public $table = 'machines';

    protected $dates = [
        'updated_at',
        'created_at',
    ];

    protected $fillable = [
        'machine_code', 
        'name', 
        'cost', 
        'status', 
        'users_id', 
        'updated_at',
        'created_at',
    ];
}
