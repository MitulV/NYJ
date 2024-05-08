<?php

namespace App\Http\Controllers;

use App\Category;
use App\Event;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function events(Request $request)
    {
        $events = Event::where('status', 'Published')
               ->where(function ($query) {
                   $query->whereDate('start_date', '>=', now())
                         ->orWhere(function ($query) {
                             $query->whereDate('start_date', now()->format('Y-m-d'))
                                   ->whereTime('start_time', '>=', now()->format('H:i:s'));
                         });
               });

        if ($request->filled('location')) {
            $location = $request->input('location');
            $events->whereHas('city', function ($query) use ($location) {
                $query->where('name', 'like', '%' . $location . '%');
            });
        }

        if ($request->filled('category')) {
            $category = $request->input('category');
            $events->whereHas('category', function ($query) use ($category) {
                $query->where('name', 'like', '%' . $category . '%');
            });
        }        

        if ($request->filled('event')) {
            $eventTitle = $request->input('event');
            $events->where('title', 'like', '%' . $eventTitle . '%');
        }

        $events = $events->get();
        
        $categories = Category::all();
        return view('events', compact('events', 'categories'));
    }


    public function pricing()
    {
        return view('pricing');
    }

    public function stepper()
    {
        return view('stepper');
    }
}
