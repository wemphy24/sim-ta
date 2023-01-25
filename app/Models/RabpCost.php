<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RabpCost extends Model
{
    // use HasFactory;
    public $table = 'rabp_costs';

    protected $dates = [
        'updated_at',
        'created_at',
    ];

    protected $fillable = [
        'rabps_id', 
        'overhead', 
        'preliminary', 
        'profit', 
        'ppn', 
        'total_price', 
        'updated_at',
        'created_at',
    ];

    public function rabp()
    {
        return $this->belongsTo('App\Models\Rabp', 'rabps_id', 'id');
    }
}
