<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','packages_ids','invoice_cost', 'invoice_state', 'pay_date','paid_to'];
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function packages()
    {
        return $this->hasMany(Package::class);
    }
    protected $casts = [
        'packages_ids'=>'array'
    ];

}
