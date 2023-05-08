<?php

namespace App\Models;

use App\Models\Traits\ObservesWrites;
use App\Observers\Observable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ReservationAccessory extends Pivot
{
    use HasFactory, ObservesWrites, Observable;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    public function quantity(): Attribute
    {
        return Attribute::set(fn ($value) => $this->quantity + $value);
    }

    public function accessory(): BelongsTo
    {
        return $this->belongsTo(Accessory::class);
    }
}
