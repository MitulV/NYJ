<?php

namespace App\Services;

use App\BookingTicket;
use App\Discount;
use App\DiscountEventTicket;
use App\Ticket;
use Carbon\Carbon;
use Illuminate\Support\Str;

class BookingService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        
    }

    public function discount($request){
        $discount = Discount::where('code', $request->code)->first();
        if($this->isDiscountCodeActive($discount)){

            if(($discount->used < $discount->quantity) || $discount->quantity==null){

                if($discount->available_for==$request->available_for){

                    if($discount->discount_amount_per_ticket_or_booking=='per_ticket'){

                    }else if($discount->discount_amount_per_ticket_or_booking=='per_booking'){
                        //$totalAmount=$this->calculateTotalAmount($request,$booking);
                    }
                    
                }

                }

        }
    }

    public function calculateTotalAmount($request,$booking){
       
        $totalAmount = 0;
        
        foreach ($request->except('_token', 'event_id', 'name', 'email') as $ticketId => $quantity) {
            if (Str::startsWith($ticketId, 'ticket_id_')) {
      
              // Extract the ticket ID from the parameter name
              $ticketId = substr($ticketId, strlen('ticket_id_'));
              
              $ticket = Ticket::findOrFail($ticketId);
              
              if ($quantity > 0) {
                $amount = $ticket->price * $quantity;
                $totalAmount += $amount;
              }

            }
          }
          return $totalAmount;
    }

    public function isDiscountCodeActive($discount){
        
        if ($discount) {
            $now = Carbon::now();
            if (is_null($discount->valid_from_date) && is_null($discount->valid_from_time)) {
                if (is_null($discount->valid_to_date) && is_null($discount->valid_to_time)) {
                    return true;
                } else if (!is_null($discount->valid_to_date) && !is_null($discount->valid_to_time)) {
                    $validTo = Carbon::createFromFormat('Y-m-d H:i:s', $discount->valid_to_date . ' ' . $discount->valid_to_time);
                    return $validTo >= $now;
                }
            }
            
        }
        return false;
    }

    public function isCodeAvailableForTicket($discount,$ticketId){
        return DiscountEventTicket::where('discount_id', $discount->id)
                                              ->where('ticket_id', $ticketId)
                                              ->exist();
    }
}
