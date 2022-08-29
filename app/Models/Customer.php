<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    // use HasFactory;
    public $table = 'customers';

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

    public function quotation()
    {
        return $this->hasMany('App\Models\Quotation', 'customers_id');
    }
}
