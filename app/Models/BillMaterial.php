<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillMaterial extends Model
{
    // use HasFactory;
    public $table = 'bill_materials';

    protected $dates = [
        'updated_at',
        'created_at',
    ];

    protected $fillable = [
        'budget_plan_costs_id', 
        'materials_id', 
        'quantity', 
        'price', 
        'total_price', 
    ];

    public function budget_plan()
    {
        return $this->belongsTo('App\Models\BudgetPlanCost', 'budget_plan_costs_id', 'id');
    }

    public function material()
    {
        return $this->belongsTo('App\Models\Material', 'materials_id', 'id');
    }

    public function detail_bill_material()
    {
        return $this->hasOne('App\Models\DetailBillMaterial', 'bill_materials_id');
    }
}
