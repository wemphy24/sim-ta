<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanningCost extends Model
{
    // use HasFactory;
    public $table = 'planning_costs';

    protected $dates = [
        'updated_at',
        'created_at',
    ];

    protected $fillable = [
        'quotations_id', 
        'rabp_code', 
        'rap_code', 
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

    public function finish_good()
    {
        return $this->hasOne('App\Models\FinishGood', 'planning_costs_id');
    }

    public function detail_cost()
    {
        return $this->hasOne('App\Models\DetailCost', 'planning_costs_id');
    }

    public function production()
    {
        return $this->hasOne('App\Models\Production', 'planning_costs_id');
    }

    public function bill_material()
    {
        return $this->hasOne('App\Models\BillMaterial', 'planning_costs_id');
    }
}
