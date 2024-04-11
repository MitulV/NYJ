<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'user_id',
        'reference_number',
        'amount',
        'status',
        'booking_date_time',
        'number_of_tickets',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function boot()
    {
        parent::boot();

        // Define event listeners or actions here
        static::creating(function ($booking) {
            $booking->reference_number = strtoupper(Str::random(8)); // Generate an 8-character alphanumeric code

        });
    }
}
