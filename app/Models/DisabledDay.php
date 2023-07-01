<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DisabledDay extends Model
{
    use HasFactory;

    protected $table = 'calendar_disabled_days';

    protected $fillable = [
        'day',
        'enabled',
    ];

    protected $casts = [
        'day' => 'date',
        'enabled' => 'boolean',
    ];

    public function calendar(): BelongsTo
    {
        return $this->belongsTo(Calendar::class);
    }
}
