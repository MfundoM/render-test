<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GaragingAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_id',
        'street',
        'city',
        'state',
        'zip'
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
