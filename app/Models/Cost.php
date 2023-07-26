<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cost extends Model
{
    public $table = 'costs';

    protected $dates = [
        'updated_at',
        'created_at',
    ];

    protected $fillable = [
        'overhead', 
        'preliminary', 
        'profit', 
        // 'discount', 
        'goods_id', 
        'updated_at',
        'created_at',
    ];

    public function good()
    {
        return $this->belongsTo('App\Models\Good', 'goods_id', 'id');
    }
}
