<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    // use HasFactory;
    public $table = 'status';

    protected $dates = [
        'updated_at',
        'created_at',
    ];

    protected $fillable = [
        'name', 
        'updated_at',
        'created_at',
    ];

    public function quotation()
    {
        return $this->hasMany('App\Models\Quotation', 'status_id');
    }

    // public function budget_plan()
    // {
    //     return $this->hasMany('App\Models\BudgetPlan', 'status_id');
    // }

    public function inquiry()
    {
        return $this->hasMany('App\Models\Inquiry', 'status_id');
    }

    public function contract()
    {
        return $this->hasMany('App\Models\Contract', 'status_id');
    }

    public function planning_cost()
    {
        return $this->hasMany('App\Models\PlanningCost', 'status_id');
    }

    public function rabp()
    {
        return $this->hasMany('App\Models\Rabp', 'status_id');
    }

    public function production()
    {
        return $this->hasMany('App\Models\Production', 'status_id');
    }

    public function logistic_material()
    {
        return $this->hasMany('App\Models\LogisticMaterial', 'status_id');
    }

    public function purchase_request()
    {
        return $this->hasMany('App\Models\PurchaseRequest', 'status_id');
    }

    public function purchase_order()
    {
        return $this->hasMany('App\Models\PurchaseOrder', 'status_id');
    }

    public function quality_control()
    {
        return $this->hasMany('App\Models\QualityCotrol', 'status_id');
    }

    public function good_receive()
    {
        return $this->hasMany('App\Models\GoodReceive', 'status_id');
    }

    public function retur()
    {
        return $this->hasMany('App\Models\Retur', 'status_id');
    }

    public function delivery()
    {
        return $this->hasMany('App\Models\Delivery', 'status_id');
    }
}
