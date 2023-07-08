<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    // use HasFactory;
    public $table = 'purchase_orders';

    protected $dates = [
        'updated_at',
        'created_at',
    ];

    protected $fillable = [
        'purchase_order_code', 
        'name',
        'description', 
        'po_date', 
        'total_price',  
        'discount',  
        'suppliers_id',  
        'status_id', 
        'users_id', 
        'updated_at',
        'created_at',
    ];

    public function supplier()
    {
        return $this->belongsTo('App\Models\Supplier', 'suppliers_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo('App\Models\Status', 'status_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'users_id', 'id');
    }

    public function good_receive()
    {
        return $this->hasMany('App\Models\GoodReceive', 'purchase_orders_id');
    }

    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        $query->where(function($query) use ($term) {
            $query->where('purchase_order_code', 'like', $term)
            ->orWhere('name', 'like', $term)
            ->orWhere('description', 'like', $term)
            ->orWhere('po_date', 'like', $term)
            ->orWhere('total_price', 'like', $term)
            ->orWhereHas('supplier', function($query) use ($term) {
                $query->where('name', 'like', $term);
            })
            ->orWhereHas('status', function($query) use ($term) {
                $query->where('name', 'like', $term);
            });
        });
    }
}
