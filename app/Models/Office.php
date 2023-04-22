<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    use HasFactory;
    protected $fillable = ['office_name', 'office_phone','budget'];
    public function employees()
    {
        return $this->hasMany(User::class, 'office_id');
    }
}
