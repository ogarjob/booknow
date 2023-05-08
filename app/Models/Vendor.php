<?php

namespace App\Models;

use App\Models\Traits\ObservesWrites;
use App\Observers\Observable;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vendor extends Model
{
    use SoftDeletes, ObservesWrites, Observable;

    /**
     * The attributes that aren't mass assignable.
     */
    protected $guarded = [];

    public function logo(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                $value ??= config('cloudinary.defaults.logo');

                return cloudinary_url($value, 200, true);
            },

            set: function ($value) {
                if (str($value)->startsWith(['/', 'http'])) {
                    return Cloudinary::upload((string) $value, [
                        'folder' => config('cloudinary.folders.logo')
                    ])->getFileName();
                }

                return $value;
            }
        )->withoutObjectCaching();
    }

    public function getBankAccountNameAttribute(): ?string
    {
        if (is_null($bank = $this->meta->bank ?? null)) return null;

        return "$bank->bank_name - $bank->account_number ($bank->account_name)";
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function products(): HasMany
    {
        // Todo: Should be $this->throughCategories()->hasProducts();
        return $this->hasMany(Product::class);
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }
}
