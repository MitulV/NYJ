<?php

namespace App\Http\Controllers\Admin;

use App\Booking;
use App\Event;

class HomeController
{
    public function index()
    {
        /** @var \App\User $user */
        $user = auth()->user();

        if ($user->isUser()) {
            return redirect()->route('admin.mybookings.index');
        }

        $counts = null;
        $revenueData = null;

        if ($user->isAdmin()) {
            $counts = [
                'totalEvents' => Event::count(),
                'totalTicketsSold' => Booking::where('status', 'complete')->with('tickets')->get()->sum(function ($booking) {
                    return $booking->tickets->sum('pivot.quantity');
                }),
                'upcomingEvents' => Event::where('start_date', '>', now())->count(),
                'totalRevenue' => Booking::where('status', 'complete')->sum('amount')
            ];

            $revenueData = Booking::where('status', 'complete')
                ->selectRaw('YEAR(booking_date_time) as year, MONTH(booking_date_time) as month, SUM(amount) as total_revenue')
                ->groupBy('year', 'month')
                ->orderBy('year')
                ->orderBy('month')
                ->get();
        } else {
            $organizerId = $user->id;
            $counts = [
                'totalEvents' => Event::where('organizer_id', $organizerId)->count(),
                'totalTicketsSold' => Booking::whereHas('event', function ($query) use ($organizerId) {
                    $query->where('organizer_id', $organizerId);
                })->where('status', 'complete')->with('tickets')->get()->sum(function ($booking) {
                    return $booking->tickets->sum('pivot.quantity');
                }),
                'upcomingEvents' => Event::where('organizer_id', $organizerId)
                    ->where('start_date', '>', now())
                    ->count(),
                'totalRevenue' => Booking::whereHas('event', function ($query) use ($organizerId) {
                    $query->where('organizer_id', $organizerId);
                })->where('status', 'complete')->sum('amount')
            ];

            $revenueData = Booking::whereHas('event', function ($query) use ($organizerId) {
                $query->where('organizer_id', $organizerId);
            })
                ->where('status', 'complete')
                ->selectRaw('YEAR(booking_date_time) as year, MONTH(booking_date_time) as month, SUM(amount) as total_revenue')
                ->groupBy('year', 'month')
                ->orderBy('year')
                ->orderBy('month')
                ->get();
        }


        return view('admin.home', compact('counts', 'revenueData'));
    }
}
