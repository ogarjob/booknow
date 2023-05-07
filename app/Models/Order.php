<?php

namespace App\Models;

use App\Models\Traits\InteractsWithOrderAttributes;
use App\Models\Traits\ObservesWrites;
use App\Observers\Observable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Traits\Tappable;

class Order extends Model
{
    use HasFactory, ObservesWrites, Observable, InteractsWithOrderAttributes, Tappable, SoftDeletes;

    /**
     * The attributes that aren't mass assignable.
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'delivered_at' => 'date'
    ];

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::addGlobalScope('order', fn ($builder) => $builder->latest());
    }

    /**
     * Scope the query to return only orders that are concerned with the auth user.
     */
    public function scopeManageable(Builder $builder): void
    {
        $builder->with(['reservation' => ['user', 'room'], 'user', 'products', 'transactions'])
            ->when(user()->isCustomer())->whereRelation('reservation.user', 'id', user('id'))
            ->when(user()->isAgent())->whereRelation('reservation', 'agent_user_id', user('id'))
            ->when(user()->isVendor())->whereRelation('products', 'vendor_id', user()->vendor?->id);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, OrderProduct::class)
            ->withPivot(['id', 'price', 'quantity'])
            ->withTimestamps();
    }

    public function reservation(): BelongsTo
    {
        return $this->belongsTo(Reservation::class)->withTrashed();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
