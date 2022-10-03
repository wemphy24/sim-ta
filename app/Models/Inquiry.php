<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    // use HasFactory;
    public $table = 'inquiries';

    protected $dates = [
        'updated_at',
        'created_at',
    ];

    protected $fillable = [
        'name', 
        'inquiry_file', 
        'purchase_order_file', 
        'date', 
        'address', 
        'customers_id', 
        'status_id', 
        'users_id',
        'updated_at',
        'created_at',
    ];

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer', 'customers_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo('App\Models\Status', 'status_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'users_id', 'id');
    }
}