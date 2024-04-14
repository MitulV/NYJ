<?php

namespace App\Http\Controllers;



class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function events(){
        return view('events');
    }

    public function pricing(){
        return view('pricing');
    }

    
}
