<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserPlan extends Model
{
    use HasFactory;

    const LENGUAGES = [
        'en_US',
        'es_ES',
        'ca_ES'
    ];

    protected $fillable = [
        'start_timestamp',
        'end_timestamp',
        'renewal_timestamp',
        'renewal_price',
        'language',
        'proxim_start_timestamp',
        'proxim_end_timestamp',
        'proxim_renewal_timestamp',
        'proxim_renewal_price'
    ];

    protected $casts = [
        'start_timestamp' => 'datetime',
        'end_timestamp' => 'datetime',
        'renewal_timestamp' => 'datetime',
        'pending_payment' => 'boolean',
        'date_max_payment' => 'date',
        'proxim_start_timestamp' => 'datetime',
        'proxim_end_timestamp' => 'datetime',
        'proxim_renewal_timestamp' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

}
