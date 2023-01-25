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
}
