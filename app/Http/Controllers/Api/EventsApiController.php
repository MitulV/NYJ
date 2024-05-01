<?php

namespace App\Http\Controllers\Api;

use App\Booking;
use App\Event;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class EventsApiController extends Controller
{
    public function index(Request $request)
    {
        /** @var \App\User $user */
        $user = auth()->user();

        if ($user->isAdmin()) {
            $events = Event::all();
        } elseif ($user->isOrganizer()) {
            $events = Event::where('organizer_id', $user->id)->get();
        } else {
            return response()->json(['error' => 'Invalid user'], 401);
        }

        return response()->json(['data' => $events], 200);
    }

    public function guests(Request $request, $eventId)
    {
        $status = $request->input('status');

        $query = Booking::where('event_id', $eventId);

        if ($status) {
            $query->where('status', $status);
        }

        $bookings = $query->with('user')->get();

        if ($bookings->isEmpty()) {
            return response()->json(['message' => 'No bookings found for this event'], 404);
        }

        $bookingData = [];

        foreach ($bookings as $booking) {
            $userDetails = [
                'user_name' => $booking->user->name,
                'user_email' => $booking->user->email,
                'booking_reference_number' => $booking->reference_number,
                'booking_status' => $booking->status,
                'is_checked_in' => $booking->checked_in
            ];
            // Add user details to booking data array
            $bookingData[] = $userDetails;
        }

        return response()->json(['data' => $bookingData]);
    }

    public function checkIn(Request $request, $referenceNumber)
    {
        // Find the booking by its ID
        $booking = Booking::findOrFail($referenceNumber);

        // Update the checked_in status to true
        $booking->update(['checked_in' => true]);

        return response()->json(['message' => 'User checked in successfully']);
    }

    public function bookingDetails(Request $request, $referenceNumber)
    {
        $booking = Booking::with('event', 'user', 'tickets')->where('reference_number', $referenceNumber)->firstOrFail();
        return response()->json(['data' => $booking]);
    }
}
