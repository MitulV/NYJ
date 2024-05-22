<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AutomaticDiscountController extends Controller
{
    public function index(Request $request){
        return view('admin.Discount.index');
    }

    public function create()
    {
        return view('admin.Discount.create');
    }
}
