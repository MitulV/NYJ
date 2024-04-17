<?php

namespace App\Http\Controllers\Admin;

use App\Booking;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Response;

class MyBookingsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('My_Bookings'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $bookings = Booking::where('user_id', auth()->user()->id)->with('event')->get();
        return view('admin.mybookings.index',compact('bookings'));
    }


    public function show(Booking $booking)
    {
        abort_if(Gate::denies('My_Bookings'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('admin.mybookings.show', compact('booking'));
    }

}
