<?php

namespace App\Http\Controllers;

use App\Setting;


class HomeController extends Controller
{
    public function index()
    {
       // $settings = Setting::pluck('value', 'key');

        return view('home', 
        //compact('settings', 'speakers', 'schedules', 'venues', 'hotels', 'galleries', 'sponsors', 'faqs', 'prices', 'amenities')
    );
    }

    
}
