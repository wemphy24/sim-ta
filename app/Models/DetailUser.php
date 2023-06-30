<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailUser extends Model
{
    public $table = 'detail_users';

    protected $dates = [
        'updated_at',
        'created_at',
    ];

    protected $fillable = [
        'users_id', 
        'phone', 
        'address', 
        'photo', 
        'departement', 
        'roles_id', 
        'updated_at',
        'created_at',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'users_id', 'id');
    }

    public function role()
    {
        return $this->belongsTo('App\Models\Role', 'roles_id', 'id');
    }
}
