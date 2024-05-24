<?php

namespace App\Http\Controllers\Admin;

use App\Discount;
use App\Event;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DiscountController extends Controller
{
    public function index(Request $request){
       
        return view('admin.Discount.index');
    }

    public function create()
    {
        $events = Event::with('tickets')->get();
        return view('admin.Discount.create',compact('events'));
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'code' => 'required|string|unique:discounts,code',
            'event_id' => 'required|exists:events,id',
            'ticket_id' => 'required|exists:tickets,id',
            'discount_amount_type' => 'required|in:fixed,percentage',
            'valid_from_date' => 'nullable|date',
            'valid_from_time' => 'nullable|date_format:H:i:s',
            'valid_to_date' => 'nullable|date',
            'valid_to_time' => 'nullable|date_format:H:i:s',
            'quantity' => 'nullable|integer|min:0',
            'available_for' => 'required|in:all,in_house',
        ]);
    
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        // Create new Discount record using mass assignment
        $discount = Discount::create($request->all());
    
        return response()->json(['message' => 'Discount created successfully', 'discount' => $discount], 201);
    }
}
