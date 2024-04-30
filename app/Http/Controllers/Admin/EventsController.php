<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\City;
use App\Event;
use App\Http\Controllers\Controller;
use App\Ticket;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Stripe\StripeClient;

class EventsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('Event_Management'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        /** @var \App\User $user */
        $user = auth()->user();

        if ($user->isAdmin()) {
            $events = Event::all();
        } elseif ($user->isOrganizer()) {
            $events = Event::where('organizer_id', $user->id)->get();
        }

        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        abort_if(Gate::denies('Event_Management'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $categories = Category::all();
        $cities = City::all();

        return view('admin.events.create', compact('categories', 'cities'));
    }

    public function store(Request $request)
    {

        abort_if(Gate::denies('Event_Management'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $validator = Validator::make($request->all(), [
            'category' => 'required|numeric', // Example validation rule for category (required and numeric)
            'title' => 'required|string|max:255', // Example validation rule for title (required, string, max length 255)
            'startDate' => 'required|date', // Example validation rule for startDate (required and date)
            'startTime' => 'nullable|date_format:H:i', // Example validation rule for startTime (optional and time in format HH:MM)
            'endDate' => 'required|date', // Example validation rule for endDate (required and date)
            'endTime' => 'nullable|date_format:H:i', // Example validation rule for endTime (optional and time in format HH:MM)
            'shortDescription' => 'nullable|string|max:255', // Example validation rule for shortDescription (optional, string, max length 255)
            'city' => 'required|numeric', // Example validation rule for city (required and numeric)
            'address' => 'nullable|string|max:255', // Example validation rule for address (optional, string, max length 255)
            'long_description' => 'nullable|string', // Example validation rule for long_description (optional string)
            'terms_conditions' => 'nullable|string', // Example validation rule for terms_conditions (optional string)
            'age_restrictions' => 'nullable|in:Minimum Age,Maximum Age,None', // Example validation rule for age_restrictions (optional and must be one of the given values)
            'min_age' => 'nullable|required_if:age_restrictions,Minimum Age|integer|min:0', // Example validation rule for min_age (optional, required if age_restrictions is Minimum Age, integer, min value 0)
            'max_age' => 'nullable|required_if:age_restrictions,Maximum Age|integer|min:0', // Example validation rule for max_age (optional, required if age_restrictions is Maximum Age, integer, min value 0)
            'additionalInfo' => 'nullable|string', // Example validation rule for additionalInfo (optional string)
            'banner1' => 'required|image',
            'banner2' => 'required|image',
            'booking_deadline' => 'required',
            'ticket_name.*' => 'required|string|max:255',
            'ticket_description.*' => 'required|string|max:255',
            'ticket_price.*' => 'required|numeric|min:0',
            'ticket_quantity.*' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $banner1 = $request->file('banner1');
        $banner2 = $request->file('banner2');

        $filename1 = date('mdYHis') . uniqid() . '.' . $banner1->getClientOriginalExtension();
        $path1 = $banner1->storeAs('public/images', $filename1);
        $url1 = $request->getSchemeAndHttpHost() . env('PROJECT_FOLDER_PREFIX') . '/public' . Storage::url($path1);


        $filename2 = date('mdYHis') . uniqid() . '.' . $banner2->getClientOriginalExtension();
        $path2 = $banner2->storeAs('public/images', $filename2);
        $url2 = $request->getSchemeAndHttpHost() . env('PROJECT_FOLDER_PREFIX') . '/public' . Storage::url($path2);


        $event = Event::create([
            'organizer_id' => auth()->id(),
            'title' => $request->input('title'),
            'short_description' => $request->input('shortDescription'),
            'start_date' => $request->input('startDate'),
            'start_time' => $request->input('startTime'),
            'end_date' => $request->input('endDate'),
            'end_time' => $request->input('endTime'),
            'address' => $request->input('address'),
            'city_id' => $request->input('city'),
            'category_id' => $request->input('category'),
            'long_description' => $request->input('long_description'),
            'terms_and_conditions' => $request->input('terms_conditions'),
            'age_restrictions' => $request->input('age_restrictions'),
            'min_age' => $request->input('min_age'),
            'max_age' => $request->input('max_age'),
            'additional_info' => $request->input('additionalInfo'),
            'image1' => $url1,
            'image2' => $url2,
            'booking_deadline' => $request->input('booking_deadline'),
            'status' => 'Published'
        ]);

        $ticketNames = $request->input('ticket_name');
        $ticketDescriptions = $request->input('ticket_description');
        $ticketPrices = $request->input('ticket_price');
        $ticketQuantities = $request->input('ticket_quantity');

        /** @var \App\User $user */
        $user = auth()->user();
        $stripe = new StripeClient(config('stripe.api_keys.secret_key'));

        // Iterate through the arrays and create Ticket records
        foreach ($ticketNames as $key => $ticketName) {
            $price = $ticketPrices[$key];
            $price_in_cents = (int)($price * 100);
            $productObj = $stripe->products->create(['name' => $ticketName]);
            $priceObj = $stripe->prices->create([
                'currency' => 'GBP',
                'unit_amount' => $price_in_cents,
                'product' => $productObj->id
            ]);

            Ticket::create([
                'event_id' => $event->id,
                'name' => $ticketName,
                'description' => $ticketDescriptions[$key],
                'price' => $price,
                'quantity' => $ticketQuantities[$key],
                'stripe_product_id' => $productObj->id,
                'stripe_price_id' => $priceObj->id
            ]);
        }

        if ($request->has('group_ticket_name')) {
            $price=$request->input('group_ticket_price');
            $price_in_cents = (int)($price* 100);
            $productObj = $stripe->products->create(['name' => $request->input('group_ticket_name')]);
            $priceObj = $stripe->prices->create([
                'currency' => 'GBP',
                'unit_amount' => $price_in_cents,
                'product' => $productObj->id
            ]);

            Ticket::create([
                'event_id' => $event->id,
                'name' => $request->input('group_ticket_name'),
                'description' => $request->input('group_ticket_description'),
                'price' => $price,
                'quantity' => $request->input('group_ticket_quantity'),
                'group_count' =>$request->input('group_count'),
                'stripe_product_id' => $productObj->id,
                'stripe_price_id' => $priceObj->id
            ]);
        }

        

        return redirect()->route('admin.events.index');
    }

    public function edit(Event $event)
    {
        abort_if(Gate::denies('Event_Management'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = Category::all();
        $cities = City::all();

        return view('admin.events.edit', compact('event', 'categories', 'cities'));
    }

    public function update(Request $request, Event $event)
    {
        abort_if(Gate::denies('Event_Management'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $validator = Validator::make($request->all(), [
            'category' => 'required|numeric', // Example validation rule for category (required and numeric)
            'title' => 'required|string|max:255', // Example validation rule for title (required, string, max length 255)
            'startDate' => 'required|date', // Example validation rule for startDate (required and date)
            'startTime' => 'nullable|date_format:H:i:s', // Example validation rule for startTime (optional and time in format HH:MM)
            'endDate' => 'required|date', // Example validation rule for endDate (required and date)
            'endTime' => 'nullable|date_format:H:i:s', // Example validation rule for endTime (optional and time in format HH:MM)
            'shortDescription' => 'nullable|string|max:255', // Example validation rule for shortDescription (optional, string, max length 255)
            'city' => 'required|numeric', // Example validation rule for city (required and numeric)
            'address' => 'nullable|string|max:255', // Example validation rule for address (optional, string, max length 255)
            'long_description' => 'nullable|string', // Example validation rule for long_description (optional string)
            'terms_conditions' => 'nullable|string', // Example validation rule for terms_conditions (optional string)
            'age_restrictions' => 'nullable|in:Minimum Age,Maximum Age,None', // Example validation rule for age_restrictions (optional and must be one of the given values)
            'min_age' => 'nullable|required_if:age_restrictions,Minimum Age|integer|min:0', // Example validation rule for min_age (optional, required if age_restrictions is Minimum Age, integer, min value 0)
            'max_age' => 'nullable|required_if:age_restrictions,Maximum Age|integer|min:0', // Example validation rule for max_age (optional, required if age_restrictions is Maximum Age, integer, min value 0)
            'additionalInfo' => 'nullable|string', // Example validation rule for additionalInfo (optional string)
            'booking_deadline' => 'required',
            'ticket_name.*' => 'required|string|max:255',
            'ticket_description.*' => 'required|string|max:255',
            'ticket_price.*' => 'required|numeric|min:0',
            'ticket_quantity.*' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $event->update([
            'title' => $request->input('title'),
            'short_description' => $request->input('shortDescription'),
            'start_date' => $request->input('startDate'),
            'start_time' => $request->input('startTime'),
            'end_date' => $request->input('endDate'),
            'end_time' => $request->input('endTime'),
            'address' => $request->input('address'),
            'city_id' => $request->input('city'),
            'category_id' => $request->input('category'),
            'long_description' => $request->input('long_description'),
            'terms_and_conditions' => $request->input('terms_conditions'),
            'age_restrictions' => $request->input('age_restrictions'),
            'min_age' => $request->input('min_age'),
            'max_age' => $request->input('max_age'),
            'additional_info' => $request->input('additionalInfo'),
            'booking_deadline' => $request->input('booking_deadline'),
        ]);

        $stripe = new StripeClient(config('stripe.api_keys.secret_key'));

        foreach ($request->input('tickets', []) as $ticketData) {
            if (isset($ticketData['id'])) {
                // If the ticket has an ID, it already exists, so update it
                $ticket = Ticket::findOrFail($ticketData['id']);
                $ticket->update([
                    'name' => $ticketData['name'],
                    'description' => $ticketData['description'],
                    'price' => $ticketData['price'],
                    'quantity' => $ticketData['quantity'],
                ]);
            } else {
                // If the ticket does not have an ID, it's a new ticket, so create it


                $price_in_cents = (int)($ticketData['price'] * 100);
                $product = $stripe->products->create(['name' => $ticketData['name']]);
                $price = $stripe->prices->create([
                    'currency' => 'GBP',
                    'unit_amount' => $price_in_cents,
                    'product' => $product->id
                ]);

                Ticket::create([
                    'event_id' => $event->id,
                    'name' => $ticketData['name'],
                    'description' => $ticketData['description'],
                    'price' => $ticketData['price'],
                    'quantity' => $ticketData['quantity'],
                    'stripe_product_id' => $product->id,
                    'stripe_price_id' => $price->id
                ]);
            }
        }


        return redirect()->route('admin.events.index');
    }

    public function show(Event $event)
    {
        abort_if(Gate::denies('Event_Management'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('admin.events.show', compact('event'));
    }

    public function destroy(Event $event)
    {
        abort_if(Gate::denies('Event_Management'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $event->tickets()->delete();
        $event->delete();

        return back();
    }

    public function massDestroy(Request $request)
    {
        abort_if(Gate::denies('Event_Management'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $validator = Validator::make($request->all(), [
            'ids'   => 'required|array',
            'ids.*' => 'exists:amenities,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], Response::HTTP_BAD_REQUEST);
        }

        Event::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
