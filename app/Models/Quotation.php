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

    // tabel budget_plans hanya mempunyai 1 quotations_id
    public function budget_plan()
    {
        return $this->hasOne('App\Models\BudgetPlan', 'quotations_id');
    }
}
