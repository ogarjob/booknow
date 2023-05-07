<?php

namespace App\Models;

use App\Models\Traits\HasMetaAttribute;
use App\Models\Traits\InteractsWithCart;
use App\Models\Traits\InteractsWithStock;
use App\Models\Traits\ObservesWrites;
use App\Observers\Observable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Traits\Tappable;

class Product extends Model
{
    use SoftDeletes, ObservesWrites, Observable, Tappable, InteractsWithCart, HasMetaAttribute, InteractsWithStock;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var string[]|bool
     */
    protected $guarded = [];

    public function thumbnail(): Attribute
    {
        return Attribute::get(function () {
            if ($this->images->isEmpty()) {
                return cloudinary_url('cecilia/product/default', 200);
            }

            return $this->images->first()->transform(["width" => 200, "height" => 200, "crop" => "fill"]);
        });
    }

    /**
     * @deprecated
     */
    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, OrderProduct::class)
            ->withPivot(['id', 'price', 'quantity'])
            ->withTimestamps();
    }

    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }

    public function image(): HasOne
    {
        return $this->hasOne(Image::class);
    }
}
