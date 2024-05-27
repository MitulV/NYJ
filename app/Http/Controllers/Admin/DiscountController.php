<?php

namespace App\Http\Controllers\Admin;

use App\Discount;
use App\Event;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DiscountController extends Controller
{
    public function index(Request $request)
    {
        $discounts = Discount::all();
        return view('admin.Discount.index', compact('discounts'));
    }

    public function create()
    {
        $events = Event::with('tickets')->get();
        return view('admin.Discount.create', compact('events'));
    }

    public function store(Request $request)
    {
        if (Discount::where('code', $request->code)->exists()) {
            return response()->json(['message' => 'The code already exists'], 422);
        }
        
        DB::transaction(function () use ($request) {
            $valid_from_date = $request->valid_from_date;
            $valid_from_time = $request->valid_from_time;
            $valid_to_date = $request->valid_to_date;
            $valid_to_time = $request->valid_to_time;
            $quantity = $request->quantity_radio === 'limited' ? $request->quantity : null;
        
            $discount = Discount::create([
                'code' => $request->code,
                'discount_amount_type' => $request->discount_amount_type,
                'discount_amount' => $request->discount_amount,
                'discount_amount_per_ticket_or_booking' => $request->discount_amount_per_ticket_or_booking,
                'valid_from_date' => $valid_from_date,
                'valid_from_time' => $valid_from_time,
                'valid_to_date' => $valid_to_date,
                'valid_to_time' => $valid_to_time,
                'quantity' => $quantity,
                'available_for' => $request->available_for,
            ]);
        
            // Iterate over the selected events and their tickets
            $selectedEvents = json_decode($request->selectedEvents, true);
            
            foreach ($selectedEvents as $event) {
                $eventId = $event['id'];
                $selectedTickets = $event['selectedTickets'];
        
                foreach ($selectedTickets as $ticketId) {
                    // Create a DiscountEventTicket record for each event and ticket combination
                    $discount->discountEventTickets()->create([
                        'event_id' => $eventId,
                        'ticket_id' => $ticketId,
                    ]);
                }
            }
        });
    }

    public function show(Discount $discount)
    {
        $events = Event::with('tickets')->get();
        return view('admin.cities.show', compact('discount','events'));
    }

    public function isDiscountCodeAvailable($code, $requestValue){
        $discount = Discount::where('code', $code)->first();
        
        if ($discount) {
            $now = Carbon::now();
    
            if ($discount->used < $discount->quantity) {
                if ($discount->available_for === $requestValue) {
                    if (is_null($discount->valid_from_date) && is_null($discount->valid_from_time)) {
                        if (is_null($discount->valid_to_date) && is_null($discount->valid_to_time)) {
                            return true;
                        } else if (!is_null($discount->valid_to_date) && !is_null($discount->valid_to_time)) {
                            $validTo = Carbon::createFromFormat('Y-m-d H:i:s', $discount->valid_to_date . ' ' . $discount->valid_to_time);
                            return $validTo >= $now;
                        }
                    }
                }
            }
        }
        return false;
    }
        
}
