<?php

namespace App\Models;

use App\Models\Traits\InteractsWithReservationAttributes;
use App\Models\Traits\ObservesWrites;
use App\Models\Traits\ReservationScope;
use App\Observers\Observable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
    use SoftDeletes, ObservesWrites, InteractsWithReservationAttributes, ReservationScope, Observable;

    /**
     * The attributes that aren't mass assignable.
     */
    protected $guarded = [];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['room', 'user'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'checkin_at'  => 'datetime',
        'checkout_at' => 'datetime',
    ];

    /**
     * Get the users that can be notified for this reservation.
     */
    public function notifiables(): mixed
    {
        return collect([$this->user, $this->agent])->filter()->merge(
            User::admin()->notifiable()->get()
        );
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function agent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'agent_user_id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function voucher(): HasOne
    {
        return $this->hasOne(Voucher::class);
    }

    public function accessories(): BelongsToMany
    {
        return $this->belongsToMany(Accessory::class, ReservationAccessory::class)
            ->withPivot(['id', 'quantity', 'created_by', 'updated_by'])
            ->withTimestamps();
    }

    public function promo(): BelongsTo
    {
        return $this->belongsTo(Promo::class);
    }
}

