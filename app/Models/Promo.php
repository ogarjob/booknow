<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Promo extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'expires_at' => 'datetime'
    ];

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'code';
    }

    public function code(): Attribute
    {
        return Attribute::set(fn ($value) => strtoupper($value));
    }

    public function forHumans(): string
    {
        return ($this->byAmount() ? 'N'.number_format($this->value) : $this->value.'%').' off';
    }

    /**
     * Scope the query to only include active promos.
     */
    public function scopeActive(Builder $builder)
    {
        $builder->where('expires_at', '>=', now());
    }

    /**
     * Determine if the promo should be applied by amount.
     */
    public function byAmount(): bool
    {
        return $this->by == 'amount';
    }

    /**
     * Determine if the promo should be applied by percentage.
     */
    public function byPercentage(): bool
    {
        return $this->by == 'percentage';
    }

    public function rooms(): BelongsToMany
    {
        return $this->belongsToMany(Room::class)->withTimestamps();
    }
}
