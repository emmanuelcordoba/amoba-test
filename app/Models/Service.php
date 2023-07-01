<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'external_id',
        'external_budget_id',
        'external_route_id',
        'name',
        'notes',
        'timestamp',
        'arrival_address',
        'arrival_timestamp',
        'departure_address',
        'departure_timestamp',
        'capacity',
        'confirmed_pax_count',
        'status'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'timestamp' => 'date',
        'arrival_timestamp' => 'datetime',
        'departure_timestamp' => 'datetime',
    ];
}
