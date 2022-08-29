<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Measurement extends Model
{
    // use HasFactory;
    public $table = 'measurements';

    protected $dates = [
        'updated_at',
        'created_at',
    ];

    protected $fillable = [
        'name', 
        'updated_at',
        'created_at',
    ];

    public function material()
    {
        return $this->hasMany('App\Models\Material', 'measurements_id');
    }
}
