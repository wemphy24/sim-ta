<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // use HasFactory;
    public $table = 'categories';

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
        return $this->hasMany('App\Models\Material', 'categories_id');
    }

    public function finish_good()
    {
        return $this->hasMany('App\Models\FinishGood', 'categories_id');
    }

    public function set_good()
    {
        return $this->hasMany('App\Models\SetGood', 'categories_id');
    }

    public function logistic_material()
    {
        return $this->hasMany('App\Models\LogisticMaterial', 'categories_id');
    }

    public function purchase_request()
    {
        return $this->hasMany('App\Models\PurchaseRequest', 'categories_id');
    }

    // AFTER REVISION
    public function good()
    {
        return $this->hasMany('App\Models\Good', 'categories_id');
    }
}
