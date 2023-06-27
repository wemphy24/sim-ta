<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function quotation()
    {
        return $this->hasMany('App\Models\Quotation', 'users_id');
    }

    // public function budget_plan()
    // {
    //     return $this->hasMany('App\Models\BudgetPlan', 'users_id');
    // }

    public function inquiry()
    {
        return $this->hasMany('App\Models\Inquiry', 'users_id');
    }

    public function contract()
    {
        return $this->hasMany('App\Models\Contract', 'users_id');
    }

    public function planning_cost()
    {
        return $this->hasMany('App\Models\PlanningCost', 'users_id');
    }

    public function rabp()
    {
        return $this->hasMany('App\Models\Rabp', 'users_id');
    }

    public function production()
    {
        return $this->hasMany('App\Models\Production', 'users_id');
    }

    public function logistic_material()
    {
        return $this->hasMany('App\Models\LogisticMaterial', 'users_id');
    }

    public function purchase_request()
    {
        return $this->hasMany('App\Models\PurchaseRequest', 'users_id');
    }

    public function purchase_order()
    {
        return $this->hasMany('App\Models\PurchaseOrder', 'users_id');
    }

    public function quality_control()
    {
        return $this->hasMany('App\Models\QualityControl', 'users_id');
    }
}
