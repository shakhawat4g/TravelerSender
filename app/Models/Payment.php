<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'trip_user_id',
        'booking_id',
        'amount',
        'net_amount',
        'commission',
        'currency',
        'payment_status',
        'stripe_session_id',
        'trxref',
        'status'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
    public function trip()
    {
        return $this->belongsTo(Trip::class, 'trip_user_id', 'user_id');
    }
}
