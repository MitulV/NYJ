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

        $adminCounts = [
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

        

        return view('admin.home', compact('adminCounts','revenueData'));
    }
}
