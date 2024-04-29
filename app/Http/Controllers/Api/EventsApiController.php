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
        // Retrieve all the bookings for the specified event
        $bookings = Booking::where('event_id', $eventId)->get();

        // If there are no bookings for the event, return an empty response
        if ($bookings->isEmpty()) {
            return response()->json(['message' => 'No bookings found for this event'], 404);
        }

        // Extract user IDs from bookings
        $userIds = $bookings->pluck('user_id')->unique();

        // Fetch user data for the extracted user IDs along with their booking details
        $users = User::whereIn('id', $userIds)->with(['bookings' => function ($query) use ($eventId) {
            $query->where('event_id', $eventId)->select('user_id', 'reference_number', 'status');
        }])->get();

        return response()->json(['data' => $users]);
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
