<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailBillMaterial extends Model
{
    // use HasFactory;
    public $table = 'detail_bill_materials';

    protected $dates = [
        'updated_at',
        'created_at',
    ];

    protected $fillable = [
        'bill_materials_id', 
        'total_price_rap', 
        'overhead_cost', 
        'profit', 
        'ppn', 
        'total_price_rabp', 
    ];

    public function bill_material()
    {
        return $this->belongsTo('App\Models\BillMaterial', 'bill_materials_id', 'id');
    }
}
