<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PolicyHolder extends Model
{
    use HasFactory;

    protected $fillable = [
        'policy_id',
        'first_name',
        'last_name',
        'street',
        'city',
        'state',
        'zip'
    ];

    protected $appends = ['address'];

    protected $hidden = ['street', 'city', 'state', 'zip'];

    public function getAddressAttribute()
    {
        return [
            'street' => $this->street,
            'city' => $this->city,
            'state' => $this->state,
            'zip' => $this->zip,
        ];
    }

    public function policy()
    {
        return $this->belongsTo(Policy::class);
    }
}
