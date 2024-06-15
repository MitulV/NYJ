<?php

namespace App\Http\Controllers\Admin;

use App\Discount;
use App\Event;
use App\Http\Controllers\Controller;
use App\Services\BookingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DiscountController extends Controller
{
    public function __construct(private BookingService $bookingService)
    {
        
    }

    public function index(Request $request)
    {
         /** @var \App\User $user */
         $user = auth()->user();

        if ($user->isAdmin()) {
            $discounts = Discount::all();
        } elseif ($user->isOrganizer()) {
            $discounts = Discount::where('organizer_id', $user->id)->get();
        }
        return view('admin.Discount.index', compact('discounts'));
    }

    public function create()
    {
        $events = Event::with('tickets')->get();
        return view('admin.discount.create', compact('events'));
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
                'organizer_id' => auth()->id(),
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
        return view('admin.discount.show', compact('discount','events'));
    }

    public function edit(Discount $discount)
    {
        $events = Event::with('tickets')->get();
        return view('admin.discount.edit', compact('discount','events'));
    }

    public function update(Request $request, Discount $discount)
{
    // Validate the incoming request data if necessary

    DB::transaction(function () use ($request, $discount) {
        $valid_from_date = $request->valid_from_date;
        $valid_from_time = $request->valid_from_time;
        $valid_to_date = $request->valid_to_date;
        $valid_to_time = $request->valid_to_time;
        $quantity = $request->quantity_radio === 'limited' ? $request->quantity : null;

        // Update the discount details
        $discount->update([
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

        // Delete existing discount event tickets
        $discount->discountEventTickets()->delete();

        // Iterate over the selected events and their tickets
        $selectedEvents = json_decode($request->selectedEvents, true);

        foreach ($selectedEvents as $event) {
            $eventId = $event['id'];
            $selectedTickets = $event['selectedTickets'];

            foreach ($selectedTickets as $ticketId) {
                // Create new DiscountEventTicket records for each event and ticket combination
                $discount->discountEventTickets()->create([
                    'event_id' => $eventId,
                    'ticket_id' => $ticketId,
                ]);
            }
        }
    });

    return redirect()->route('admin.discount.index');
}


    public function destroy(Discount $discount)
    {

        $discount->discountEventTickets()->delete();
        $discount->delete();

        return back();
    }
        
}
