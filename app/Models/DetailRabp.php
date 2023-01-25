<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailRabp extends Model
{
     // use HasFactory;
    public $table = 'detail_rabps';

    protected $dates = [
        'updated_at',
        'created_at',
    ];

    protected $fillable = [
        'rabps_id', 
        'set_goods_id', 
        'updated_at',
        'created_at',
    ];

    public function rabp()
    {
        return $this->belongsTo('App\Models\Rabp', 'rabps_id', 'id');
    }

    public function set_good()
    {
        return $this->belongsTo('App\Models\SetGood', 'set_goods_id', 'id');
    }
}
