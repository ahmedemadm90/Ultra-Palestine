<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'to_name', 'to_phone', 'alter_phone', 'package_type','area_id',
        'city_id','village_id', 'street', 'total_cost', 'delivery_cost', 'plus_cost', 'description',
        'note', 'shipping_state', 'invoice_state', 'qr_code', 'package_location', 'is_back_to_owner', 'back_by_driver',
        'back_date', 'driver_id', 'driver_note','invoice_id'
    ];
    public function area()
    {
        return $this->belongsTo(Area::class);

    }public function village()
    {
        return $this->belongsTo(Village::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }
    public function log()
    {
        return $this->hasMany(PackageLog::class);
    }
}
