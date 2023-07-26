<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoodReceive extends Model
{
    // use HasFactory;
    public $table = 'good_receives';

    protected $dates = [
        'updated_at',
        'created_at',
    ];

    protected $fillable = [
        'purchase_orders_id', 
        'good_receive_code', 
        'materials_id',
        'qty', 
        'qty_order', 
        'qty_accept', 
        'price', 
        'print_date', 
        'suppliers_id',  
        'status_id',  
        'users_id',  
        'updated_at',
        'created_at',
    ];

    public function purhcase_order()
    {
        return $this->belongsTo('App\Models\PurchaseOrder', 'purchase_orders_id', 'id');
    }

    public function material()
    {
        return $this->belongsTo('App\Models\Material', 'materials_id', 'id');
    }

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

    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        $query->where(function($query) use ($term) {
            $query->where('good_receive_code', 'like', $term)
            ->orWhere('print_date', 'like', $term)
            ->orWhere('qty', 'like', $term)
            ->orWhereHas('supplier', function($query) use ($term) {
                $query->where('name', 'like', $term);
            })
            ->orWhereHas('material', function($query) use ($term) {
                $query->where('name', 'like', $term);
            })
            ->orWhereHas('status', function($query) use ($term) {
                $query->where('name', 'like', $term);
            });
        });
    }
}
