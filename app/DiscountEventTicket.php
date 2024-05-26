<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountEventTicket extends Model
{
    use HasFactory;

    protected $fillable = ['discount_id', 'event_id', 'ticket_id'];

    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
