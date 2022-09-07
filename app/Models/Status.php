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

    public function budget_plan()
    {
        return $this->hasMany('App\Models\BudgetPlan', 'status_id');
    }
}