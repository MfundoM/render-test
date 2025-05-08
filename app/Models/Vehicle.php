<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'policy_id',
        'year',
        'make',
        'model',
        'vin',
        'usage',
        'primary_use',
        'annual_mileage',
        'ownership'
    ];

    public function policy()
    {
        return $this->belongsTo(Policy::class);
    }

    public function garagingAddress()
    {
        return $this->hasOne(GaragingAddress::class);
    }

    public function coverages()
    {
        return $this->hasMany(Coverage::class);
    }
}
