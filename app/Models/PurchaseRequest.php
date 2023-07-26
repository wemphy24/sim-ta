<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseRequest extends Model
{
    // use HasFactory;
    public $table = 'purchase_requests';

    protected $dates = [
        'updated_at',
        'created_at',
    ];

    protected $fillable = [
        'productions_id', 
        'purchase_request_code', 
        'materials_id',
        'stock_logistic', 
        'qty_ask', 
        'description', 
        'deadline', 
        'categories_id',  
        'measurements_id',  
        'status_id', 
        'users_id', 
        'updated_at',
        'created_at',
    ];

    // public function production()
    // {
    //     return $this->belongsTo('App\Models\Production', 'productions_id', 'id');
    // }

    public function material()
    {
        return $this->belongsTo('App\Models\Material', 'materials_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'categories_id', 'id');
    }

    public function measurement()
    {
        return $this->belongsTo('App\Models\Measurement', 'measurements_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo('App\Models\Status', 'status_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'users_id', 'id');
    }

    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        $query->where(function($query) use ($term) {
            $query->where('purchase_request_code', 'like', $term)
            ->orWhere('description', 'like', $term)
            ->orWhere('deadline', 'like', $term)
            ->orWhereHas('status', function($query) use ($term) {
                $query->where('name', 'like', $term);
            });
        });
    }
}
