<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Route extends Model
{
    use HasFactory;

    protected $fillable = [
        'external_id',
        'invitation_code',
        'title',
    ];

    public function data(): HasMany
    {
        return $this->hasMany(RouteData::class);
    }

    public function latestData(): HasOne
    {
        return $this->hasOne(RouteData::class)->latestOfMany();
    }
}
