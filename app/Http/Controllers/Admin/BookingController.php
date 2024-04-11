<?php

namespace App\Http\Controllers\Admin;

use App\Booking;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class BookingController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('Bookings'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $bookings = Booking::all();

        return view('admin.bookings.index', compact('bookings'));
    }

    public function create()
    {
        abort_if(Gate::denies('Bookings'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.bookings.create');
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('Bookings'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            // Add other validation rules as needed
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $booking = Booking::create($request->all());

        return redirect()->route('admin.bookings.index');
    }

    public function edit(Booking $category)
    {
        abort_if(Gate::denies('Bookings'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.bookings.edit', compact('booking'));
    }

    public function update(Request $request, Booking $booking)
    {
        abort_if(Gate::denies('Bookings'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            // Add other validation rules as needed
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $booking->update($request->all());

        return redirect()->route('admin.bookings.index');
    }

    public function show(Booking $booking)
    {
        abort_if(Gate::denies('Bookings'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.bookings.show', compact('booking'));
    }

    public function destroy(Booking $booking)
    {
        abort_if(Gate::denies('Bookings'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $booking->delete();

        return back();
    }

    public function massDestroy(Request $request)
    {
        abort_if(Gate::denies('Bookings'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $validator = Validator::make($request->all(), [
            'ids'   => 'required|array',
            'ids.*' => 'exists:amenities,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], Response::HTTP_BAD_REQUEST);
        }

        Booking::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
