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
        $counts = null;
        $revenueData = null;

        if ($user->isAdmin()) {
            $counts = [
                'totalEvents' => Event::count(),
                'totalTicketsSold' => Booking::sum('number_of_tickets'),
                'upcomingEvents' => Event::where('start_date', '>', now())->count(),
                'totalRevenue' => Booking::sum('amount')
            ];

            $revenueData = Booking::selectRaw('YEAR(booking_date_time) as year, MONTH(booking_date_time) as month, SUM(amount) as total_revenue')
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
                })->sum('number_of_tickets'),
                'upcomingEvents' => Event::where('organizer_id', $organizerId)
                    ->where('start_date', '>', now())
                    ->count(),
                'totalRevenue' => Booking::whereHas('event', function ($query) use ($organizerId) {
                    $query->where('organizer_id', $organizerId);
                })->sum('amount')
            ];

            $revenueData = Booking::whereHas('event', function ($query) use ($organizerId) {
                $query->where('organizer_id', $organizerId);
            })
                ->selectRaw('YEAR(booking_date_time) as year, MONTH(booking_date_time) as month, SUM(amount) as total_revenue')
                ->groupBy('year', 'month')
                ->orderBy('year')
                ->orderBy('month')
                ->get();
        }


        return view('admin.home', compact('counts', 'revenueData'));
    }
}
