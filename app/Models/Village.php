<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
    use HasFactory;
    protected $fillable = ['village_name', 'delivery_cost', 'area_id'];
    public function area()
    {
        return $this->belongsTo(Area::class,'area_id');
    }
    public function packages()
    {
        return $this->hasMany(Package::class);
    }
}
