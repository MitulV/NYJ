<?php

namespace App\Http\Controllers\Admin;

use App\Event;

class HomeController
{
    public function index()
    {
         /** @var \App\User $user */
        $user=auth()->user();
        $totalCompletedEventsCount=0;
        if($user->isAdmin()){
            $totalCompletedEventsCount = Event::whereDate('end_date', '<=',  now())->count();
        }else if($user->isOrganizer()){
            $totalCompletedEventsCount = Event::where('organizer_id', $user->id)
            ->whereDate('end_date', '<=', now())
            ->count();
        }else if($user->isUser()){
            return redirect()->route('admin.mybookings.index');
        }
        

        return view('admin.home',compact('totalCompletedEventsCount','user'));
    }
}
