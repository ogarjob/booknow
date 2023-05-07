<?php

namespace App\Models;

use App\Models\Scopes\ScopesTimestamps;
use App\Models\Traits\ObservesWrites;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class OrderProduct extends Pivot
{
    use HasFactory, ObservesWrites, ScopesTimestamps;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    public function amount(): Attribute
    {
        return Attribute::get(fn () => $this->price * $this->quantity);
    }

    /**
     * Scope the query to only include products that belong to the given vendor.
     */
    public function scopeWhereBelongsToVendor(Builder $builder, Vendor $vendor)
    {
        $builder->whereRelation('product.vendor', 'id', $vendor->id);
    }

    /**
     * Scope the query to group the products by purchase rate per month.
     */
    public function scopeYearStats(Builder $builder)
    {
        $builder->selectRaw("DATE_FORMAT(created_at, '%b') as month, SUM(price * quantity) as total")
            ->whereYear('created_at', now())
            ->groupByRaw('DATE_FORMAT(created_at, "%b")');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
