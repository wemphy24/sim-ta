<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    // use HasFactory;
    public $table = 'deliverys';

    protected $dates = [
        'updated_at',
        'created_at',
    ];

    protected $fillable = [
        'contracts_id', 
        'rabps_id', 
        'delivery_code',
        'name', 
        'description', 
        'send_date', 
        'received_date',  
        'status_id',  
        'users_id',  
        'updated_at',
        'created_at',
    ];

    public function contract()
    {
        return $this->belongsTo('App\Models\Contract', 'contracts_id', 'id');
    }

    public function rabp()
    {
        return $this->belongsTo('App\Models\Rabp', 'rabps_id', 'id');
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
            $query->where('name', 'like', $term)
            ->orWhere('delivery_code', 'like', $term)
            ->orWhere('name', 'like', $term)
            ->orWhere('description', 'like', $term)
            ->orWhere('send_date', 'like', $term)
            ->orWhereHas('contract', function($query) use ($term) {
                $query->where('name', 'like', $term);
            })
            ->orWhereHas('status', function($query) use ($term) {
                $query->where('name', 'like', $term);
            });
        });
    }
}
