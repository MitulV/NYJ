<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Event;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserEventBookingController extends Controller
{
    public function eventDetails(Request $request)
    {
        $eventId = $request->query('eventId');
        $event = Event::find($eventId);
        return view('details', compact('event'));
    }

    public function bookEvent(Request $request)
    {

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->roles()->attach(3);

        Auth::login($user);

        $booking = Booking::create([
            'event_id' => $request->event_id,
            'user_id' => $user->id,
            'amount' => $request->amount,
            'status' => 'Success',
            'booking_date_time' => $request->booking_date_time,
            'number_of_tickets' => $request->number_of_tickets,
        ]);


        return redirect()->route('admin.mybookings.index');
    }
}
