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

    public function finish_good()
    {
        return $this->hasMany('App\Models\FinishGood', 'measurements_id');
    }

    public function set_good()
    {
        return $this->hasMany('App\Models\SetGood', 'measurements_id');
    }

    public function logistic_material()
    {
        return $this->hasMany('App\Models\LogisticMaterial', 'measurements_id');
    }

    public function purchase_request()
    {
        return $this->hasMany('App\Models\PurchaseRequest', 'measurements_id');
    }

    // AFTER REVISION
    public function good()
    {
        return $this->hasMany('App\Models\Good', 'measurements_id');
    }
}
