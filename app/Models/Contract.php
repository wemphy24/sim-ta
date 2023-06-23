<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    // use HasFactory;
    public $table = 'contracts';

    protected $dates = [
        'updated_at',
        'created_at',
    ];

    protected $fillable = [
        'quotations_id', 
        'contract_code', 
        'project_code', 
        'name', 
        'contract_value', 
        'start_date', 
        'finish_date', 
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

    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        $query->where(function($query) use ($term) {
            $query->where('name', 'like', $term)
            ->orWhere('contract_code', 'like', $term)
            ->orWhere('name', 'like', $term)
            ->orWhere('contract_value', 'like', $term)
            ->orWhere('finish_date', 'like', $term)
            ->orWhereHas('quotation', function($query) use ($term) {
                $query->where('name', 'like', $term);
            })
            ->orWhereHas('status', function($query) use ($term) {
                $query->where('name', 'like', $term);
            });
        });
    }
}
