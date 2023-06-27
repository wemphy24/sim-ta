<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Production extends Model
{
    public $table = 'productions';

    protected $dates = [
        'updated_at',
        'created_at',
    ];

    protected $fillable = [
        'rabps_id', 
        'production_code', 
        'name', 
        'description', 
        'deadline', 
        'status_id',
        'users_id',
    ];

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

    public function purchase_request()
    {
        return $this->hasMany('App\Models\PurchaseRequest', 'productions_id');
    }

    public function quality_control()
    {
        return $this->hasOne('App\Models\QualityControl', 'productions_id');
    }

    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        $query->where(function($query) use ($term) {
            $query->where('name', 'like', $term)
            ->orWhere('description', 'like', $term)
            ->orWhere('deadline', 'like', $term)
            ->orWhereHas('rabp', function($query) use ($term) {
                $query->where('name', 'like', $term);
            })
            ->orWhereHas('status', function($query) use ($term) {
                $query->where('name', 'like', $term);
            });
        });
    }
}
