<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;
    protected $fillable = ['area_name'];
    public function villages()
    {
        return $this->hasMany(Village::class,'area_id');
    }
    public function packages()
    {
        return $this->hasMany(Package::class);
    }
}
