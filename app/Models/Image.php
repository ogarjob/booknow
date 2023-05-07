<?php

namespace App\Models;

use App\Models\Traits\HasMediaAttribute;
use App\Models\Traits\ObservesWrites;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasMediaAttribute, ObservesWrites;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array<string>|bool
     */
    protected $guarded = [];

    public function src(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => cloudinary_url($value, [
                "height" => 500, "width" => 500, "crop" => "pad", "background" => "auto"
            ]),
            set: fn ($value) => $this->uploadAndReturnPath($value,
                config('cloudinary.folders.images')
            )
        )->withoutObjectCaching();
    }

    public function thumbnail(): Attribute
    {
        return Attribute::get(fn () => $this->transform([
            "width" => 200, "height" => 150, "crop" => "fill"
        ]));
    }

    /**
     * Get a transformed version of the image.
     */
    public function transform($transformation): string
    {
        return cloudinary_url($this->getRawOriginal('src'), $transformation);
    }
}
