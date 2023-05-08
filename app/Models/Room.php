<?php

namespace App\Models;

use App\Models\Scopes\RoomScope;
use App\Models\Traits\HasMetaAttribute;
use App\Models\Traits\ObservesWrites;
use App\Observers\Observable;
use App\Support\Key;
use Exception;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Room extends Model
{
    use ObservesWrites, RoomScope, Observable, HasMetaAttribute;

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'published_at' => 'datetime'
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var string[]|bool
     */
    protected $guarded = [];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function typeString(): Attribute
    {
        return Attribute::get(fn () => __("room.$this->type"));
    }

    /**
     * @return Key
     * @throws Exception
     * @deprecated Todo: Take advantage of dependency injection while creating a convenient wrapper around `Key`
     */
    public static function qrm(): Key
    {
        return tap(new Key([
            'accountSid' => config('qrm.sid'),
            'authToken'  => config('qrm.token'),
        ]), function ($key) {
            $key->setCommunityNo(config('qrm.community_no'));
            $key->setCommunityTimezone(config('app.timezone'));
        });
    }

    /**
     * Determine if the room is marked as published.
     */
    public function isPublished(): bool
    {
        return (bool) $this->published_at;
    }

    /**
     * Determine if the room is marked as featured.
     */
    public function isFeatured(): bool
    {
        return (bool) $this->featured_at;
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    public function currentReservation(): HasOne
    {
        return $this->hasOne(Reservation::class)->activeToday();
    }

    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }

    public function image(): HasOne
    {
        return $this->hasOne(Image::class)->inRandomOrder();
    }

    public function promos(): BelongsToMany
    {
        return $this->belongsToMany(Promo::class)->withTimestamps();
    }

    public function similarRooms(): HasMany
    {
        return $this->hasMany(Room::class, 'type', 'type')->available();
    }
}
