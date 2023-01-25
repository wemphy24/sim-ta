<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    // use HasFactory;
    public $table = 'quotations';

    protected $dates = [
        'updated_at',
        'created_at',
    ];

    protected $fillable = [
        'inquiries_id', 
        'quotation_code', 
        'name', 
        'project', 
        'date', 
        'location', 
        'customers_id', 
        'status_id', 
        'users_id', 
        'updated_at',
        'created_at',
    ];

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer', 'customers_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo('App\Models\Status', 'status_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'users_id', 'id');
    }

    public function inquiry()
    {
        return $this->belongsTo('App\Models\Inquiry', 'inquiries_id', 'id');
    }
    

    // tabel budget_plans hanya mempunyai 1 quotations_id
    // public function budget_plan()
    // {
    //     return $this->hasOne('App\Models\BudgetPlan', 'quotations_id');
    // }

    // tabel contract hanya mempunyai 1 quotations_id
    public function contract()
    {
        return $this->hasOne('App\Models\Contract', 'quotations_id');
    }

    public function planning_cost()
    {
        return $this->hasMany('App\Models\PlanningCost', 'quotations_id');
    }

    public function rabp()
    {
        return $this->hasMany('App\Models\Rabp', 'quotations_id');
    }
    
}
