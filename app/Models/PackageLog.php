<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageLog extends Model
{
    use HasFactory;
    protected $fillable = ['user','package_id', 'package_location', 'shipping_state', 'details','note'];
    public function packackage()
    {
        return $this->belongsTo(Package::class);
    }
}
