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

    public function inquiry()
    {
        return $this->hasMany('App\Models\Inquiry', 'customers_id');
    }

    public function good()
    {
        return $this->hasMany('App\Models\Good', 'customers_id');
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
