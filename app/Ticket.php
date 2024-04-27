<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'event_id',
        'name',
        'description',
        'price',
        'quantity',
        'stripe_product_id',
        'stripe_price_id',
        'is_group_ticket',
        'group_count'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
