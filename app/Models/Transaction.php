<?php

namespace App\Models;

use App\Models\Scopes\TransactionScope;
use App\Models\Traits\ObservesWrites;
use App\Observers\Observable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Traits\Tappable;

class Transaction extends Model
{
    use ObservesWrites, TransactionScope, Observable, Tappable;

    /**
     * Channels
     */
    const PAYSTACK = 'paystack';

    const CASH = 'cash';

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'paid_at' => 'datetime'
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var string[]|bool
     */
    protected $guarded = ['paid_at'];

    /**
     * Mark the transaction as paid.
     */
    public function markAsPaid(): static
    {
        return $this->tap(function ($transaction) {
            $transaction->paid_at ??= now();
            $transaction->save();
        });
    }

    /**
     * @deprecated
     */
    public function markAsPaidViaCash(): static
    {
        return $this->markAsPaid();
    }

    public function isCash(): bool
    {
        return $this->channel == self::CASH;
    }

    public function isPaid(): bool
    {
        return (bool) $this->paid_at;
    }

    public function reservation(): BelongsTo
    {
        return $this->belongsTo(Reservation::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by')->withTrashed();
    }
}
