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
        'officer', 
        'updated_at',
        'created_at',
    ];

    public function purchase_order()
    {
        return $this->hasMany('App\Models\PurchaseOrder', 'suppliers_id');
    }

    public function good_receive()
    {
        return $this->hasMany('App\Models\GoodReceive', 'suppliers_id');
    }

    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        $query->where(function($query) use ($term) {
            $query->where('name', 'like', $term)
            ->orWhere('email', 'like', $term)
            ->orWhere('phone', 'like', $term)
            ->orWhere('address', 'like', $term);
        });
    }
}
