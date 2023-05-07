<?php

namespace App\Models;

use App\Models\Enums\Gender;
use App\Models\Traits\HasMetaAttribute;
use App\Models\Traits\InteractsWithUserAttributes;
use App\Models\Traits\ObservesWrites;
use App\Models\Traits\UserScope;
use App\Observers\Observable;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Traits\Tappable;
use Lab404\Impersonate\Models\Impersonate;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, Observable, InteractsWithUserAttributes,
        ObservesWrites, HasMetaAttribute, UserScope, Impersonate, Tappable;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array<string>|bool
     */
    protected $guarded = ['login_count', 'email_verified_at'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ['password', 'remember_token', 'meta'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'banned_until'      => 'datetime',
        'last_login'        => 'datetime',
        'gender'            => Gender::class
    ];

    /**
     * The event map for the model.
     *
     * Allows for object-based events for native Eloquent events.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => Registered::class
    ];

    /**
     * The accessors to append to the model's array form.
     */
    protected $appends = ['name'];

    /**
     * Determine if the user can impersonate another user.
     */
    public function canImpersonate(): bool
    {
        return $this->isAdmin();
    }

    /**
     * Determine if the user can be impersonated by another user.
     */
    public function canBeImpersonated(): bool
    {
        return ! $this->isSuperAdmin() && user()->canImpersonate();
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class)->withoutEagerLoad(['user']);
    }

    public function vendor(): HasOne
    {
        return $this->hasOne(Vendor::class);
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }
}
