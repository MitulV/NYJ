<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 
        'event_id', 
        'ticket_id', 
        'discount_amount_type', 
        'valid_from_date', 
        'valid_from_time', 
        'valid_to_date', 
        'valid_to_time', 
        'quantity', 
        'available_for'
    ];
}
