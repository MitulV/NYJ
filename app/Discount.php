<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 
        'discount_amount_type', 
        'discount_amount',
        'discount_amount_per_ticket_or_booking',
        'valid_from_date', 
        'valid_from_time', 
        'valid_to_date', 
        'valid_to_time', 
        'quantity', 
        'available_for'
    ];

    public function discountEventTickets()
    {
        return $this->hasMany(DiscountEventTicket::class);
    }
}
