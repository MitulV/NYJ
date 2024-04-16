<?php

namespace App\Http\Controllers;

use App\Category;
use App\Event;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function events(){
        $events = Event::where('status', 'Published')->get();
        $categories = Category::all();
        return view('events',compact('events','categories'));
    }

    public function pricing(){
        return view('pricing');
    }

    
}
