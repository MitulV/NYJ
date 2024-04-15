<?php

namespace App\Http\Controllers;

use App\Event;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function events(){
        $events = Event::where('status', 'Published')->get();
        return view('events',compact('events'));
    }

    public function pricing(){
        return view('pricing');
    }

    
}
