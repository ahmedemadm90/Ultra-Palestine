<?php

namespace App\Models;

use App\Models\Invoice;
use App\Models\Package;
use App\Models\Role;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'fname', 'lname','tm_name','fb_token',
        'email', 'password', 'phone','active','image',
        'area_id','village_id','city_id', 'delivery_cost_discount',
        'street', 'budget', 'role_id', 'state', 'returns_cost'
    ];

    public function invoices()
    {
        return $this->hasMany(Invoice::class,'user_id');
    }
    public function packages()
    {
        return $this->hasMany(Package::class,'user_id');
    }
    public function office()
    {
        return $this->belongsTo(Office::class);
    }
    public function role()
    {
        return $this->belongsTo(Role::class,'role_id');
    }
    public function area()
    {
        return $this->belongsTo(Area::class,'area_id');
    }
    public function city()
    {
        return $this->belongsTo(City::class);
    }
    public function village()
    {
        return $this->belongsTo(Village::class);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
