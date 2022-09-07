<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetPlan extends Model
{
    // use HasFactory;
    public $table = 'budget_plans';

    protected $dates = [
        'updated_at',
        'created_at',
    ];

    protected $fillable = [
        'quotations_id', 
        'budget_plan_code', 
        'description', 
        'date', 
        'quotations_id', 
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

    public function bill_material()
    {
        return $this->hasMany('App\Models\BillMaterial', 'budget_plans_id');
    }
}
