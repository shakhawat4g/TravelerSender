<?php

namespace App\Models;

use App\Enam\BookingStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'trip_user_id',
        'trip_id',
        'tracking_number',
        'sender_name',
        'sender_email',
        'sender_phone',
        'collection_type',
        'flexible_place',
        'pickup_address_1',
        'pickup_address_2',
        'pickup_country_id',
        'pickup_state_id',
        'pickup_city_id',
        'pickup_postcode',
        'pickup_location_type',
        'pickup_date',
        'receiver_name',
        'receiver_email',
        'receiver_phone',
        'delivery_type',
        'flexible_delivery_place',
        'delivery_address_1',
        'delivery_address_2',
        'delivery_country_id',
        'delivery_state_id',
        'delivery_city_id',
        'delivery_postcode',
        'delivery_location_type',
        'delivery_date',
        'otp',
        'note',
        'admin_note',
        'package_condition',
        'status',
    ];

//    protected $casts = [
//        'status' => BookingStatus::class,
//    ];

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }


    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function tracking()
    {
        return $this->hasMany(Tracking::class);
    }
    public function latestTracking()
    {
        return $this->hasOne(Tracking::class)->latest('id');
    }

    public function rating()
    {
        return $this->hasOne(Rating::class);
    }

    public function pickupCountry(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'pickup_country_id');
    }
    public function pickupState(): BelongsTo
    {
        return $this->belongsTo(State::class, 'pickup_state_id');
    }
    public function pickupCity(): BelongsTo
    {
        return $this->belongsTo(City::class, 'pickup_city_id');
    }

    public function deliveryCountry(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'delivery_country_id');
    }
    public function deliveryState(): BelongsTo
    {
        return $this->belongsTo(State::class, 'delivery_state_id');
    }
    public function deliveryCity(): BelongsTo
    {
        return $this->belongsTo(City::class, 'delivery_city_id');
    }
    public function payment()
    {
        return $this->hasOne(Payment::class, 'booking_id');
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
