<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    // use HasFactory;
    public $table = 'materials';

    protected $dates = [
        'updated_at',
        'created_at',
    ];

    protected $fillable = [
        'categories_id', 
        'measurements_id', 
        'name', 
        'stock', 
        'price', 
        'min_stock', 
        'max_stock', 
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
}
