<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rabp extends Model
{
    // use HasFactory;
    public $table = 'rabps';

    protected $dates = [
        'updated_at',
        'created_at',
    ];

    protected $fillable = [
        'quotations_id', 
        'rabp_code', 
        'name', 
        'description', 
        'date', 
        'status_id', 
        'users_id', 
        'updated_at',
        'created_at',
    ];

    public function quotation()
    {
        return $this->belongsTo('App\Models\Quotation', 'quotations_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo('App\Models\Status', 'status_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'users_id', 'id');
    }

    public function detail_rabp()
    {
        return $this->hasMany('App\Models\DetailRabp', 'rabps_id');
    }

    public function rabp_cost()
    {
        return $this->hasMany('App\Models\RabpCost', 'rabps_id');
    }

    public function production()
    {
        return $this->hasOne('App\Models\Production', 'rabps_id');
    }

    public function quality_control()
    {
        return $this->hasOne('App\Models\QualityControl', 'rabps_id');
    }

    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        $query->where(function($query) use ($term) {
            $query->where('rabp_code', 'like', $term)
            ->orWhere('name', 'like', $term)
            ->orWhere('description', 'like', $term)
            ->orWhere('date', 'like', $term)
            ->orWhereHas('status', function($query) use ($term) {
                $query->where('name', 'like', $term);
            })
            ->orWhereHas('quotation', function($query) use ($term) {
                $query->where('name', 'like', $term);
            });
        });
    }
}
