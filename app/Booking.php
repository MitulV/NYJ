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
    'is_offline',
    'payment_mode',
    'checked_in',
    'discount_id',
  ];

  public function discount()
  {
    return $this->belongsTo(Discount::class);
  }

  public function tickets()
  {
    return $this->belongsToMany(Ticket::class, 'booking_tickets')->withPivot('quantity');
  }

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
      $booking->reference_number = strtoupper(Str::random(12)); // Generate an 12-character alphanumeric code

    });
  }


  protected $casts = [
    'booking_date_time' => 'datetime',
  ];
}
