<?php

namespace App\Models;

use App\Models\Traits\InteractsWithStock;
use App\Models\Traits\ObservesWrites;
use App\Observers\Observable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Accessory extends Model
{
    use HasFactory, SoftDeletes, Observable, ObservesWrites, InteractsWithStock;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array<string>|bool
     */
    protected $guarded = [];

    public function reservations(): BelongsToMany
    {
        return $this->belongsToMany(Reservation::class, ReservationAccessory::class)
            ->withPivot(['id', 'quantity', 'created_by', 'updated_by'])
            ->withTimestamps();
    }
}
