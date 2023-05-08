<?php

namespace App\Models;

use App\Models\Traits\ObservesWrites;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory, ObservesWrites;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var string[]|bool
     */
    protected $guarded = [];

    /**
     * Special roles attributes
     */
    const SUPER_ADMIN = 'super-admin';

    public function scopeAssignable(Builder $builder)
    {
        if (user()->isSuperAdmin()) return;

        $builder->whereKey(user()->role);
    }

    /**
     * @param  mixed  $ability
     * @return bool
     */
    public function permitted($ability): bool
    {
        if ($ability instanceof Model) {
            $ability = $ability->getKey();
        }

        return $this->isSuperAdmin() || $this->permissions->contains('ability_id', $ability);
    }

    public function isSuperAdmin()
    {
        return $this->attribute == self::SUPER_ADMIN;
    }

    /**
     * @return HasMany
     */
    public function permissions()
    {
        return $this->hasMany(Permission::class);
    }

    /**
     * @return HasMany
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
