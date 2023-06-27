<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QualityControl extends Model
{
    // use HasFactory;
    public $table = 'quality_controls';

    protected $dates = [
        'updated_at',
        'created_at',
    ];

    protected $fillable = [
        'productions_id', 
        'rabps_id',
        'quality_control_code', 
        'name', 
        'description',  
        'start_qc',  
        'end_qc',  
        'status_id', 
        'users_id', 
        'updated_at',
        'created_at',
    ];

    public function production()
    {
        return $this->belongsTo('App\Models\Production', 'productions_id', 'id');
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
            $query->where('quality_control_code', 'like', $term)
            ->orWhere('name', 'like', $term)
            ->orWhere('description', 'like', $term)
            ->orWhere('start_qc', 'like', $term)
            ->orWhere('end_qc', 'like', $term)
            ->orWhereHas('production', function($query) use ($term) {
                $query->where('name', 'like', $term);
            })
            ->orWhereHas('status', function($query) use ($term) {
                $query->where('name', 'like', $term);
            });
        });
    }
}
