<?php

namespace App\Http\Controllers\Admin;

use App\Booking;
use App\BookingTicket;
use App\Category;
use App\City;
use App\Discount;
use App\Event;
use App\Http\Controllers\Controller;
use App\Mail\BookingConfirmation;
use App\Services\BookingService;
use App\Ticket;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Mail;

class EventsController extends Controller
{
  public function __construct(private BookingService $bookingService) {}
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
      'shortDescription' => 'nullable|string', // Example validation rule for shortDescription (optional, string, max length 255)
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
      'ticket_name.*' => 'required|string|max:255',
      'ticket_description.*' => 'required|string',
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

    $startDateTime = Carbon::parse($request->input('startDate') . ' ' . $request->input('startTime'));
    $bookingDeadline = $startDateTime->subHour();

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
      'booking_deadline' => $bookingDeadline,
      'status' => 'Published'
    ]);

    $ticketNames = $request->input('ticket_name');
    $ticketDescriptions = $request->input('ticket_description');
    $ticketPrices = $request->input('ticket_price');
    $ticketQuantities = $request->input('ticket_quantity');

    // Iterate through the arrays and create Ticket records
    foreach ($ticketNames as $key => $ticketName) {
      $price = $ticketPrices[$key];

      Ticket::create([
        'event_id' => $event->id,
        'name' => $ticketName,
        'description' => $ticketDescriptions[$key],
        'price' => $price,
        'quantity' => $ticketQuantities[$key],
      ]);
    }

    if ($request->filled('group_ticket_name')) {
      $price = $request->input('group_ticket_price');

      Ticket::create([
        'event_id' => $event->id,
        'name' => $request->input('group_ticket_name'),
        'description' => $request->input('group_ticket_description'),
        'price' => $price,
        'quantity' => $request->input('group_ticket_quantity'),
        'group_count' => $request->input('group_count'),
        'is_group_ticket' => 1,
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

    $startDateTime = Carbon::parse($request->input('startDate') . ' ' . $request->input('startTime'));
    $bookingDeadline = $startDateTime->subHour();

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
      'booking_deadline' => $bookingDeadline
    ]);

    $ticketIds = $request->input('ticket_id');
    $ticketNames = $request->input('ticket_name');
    $ticketDescriptions = $request->input('ticket_description');
    $ticketPrices = $request->input('ticket_price');
    $ticketQuantities = $request->input('ticket_quantity');


    // Iterate through the arrays and create Ticket records
    foreach ($ticketNames as $key => $ticketName) {

      $ticketId = $ticketIds[$key];
      $price = $ticketPrices[$key];
      if ($ticketId == null) {
        Ticket::create([
          'event_id' => $event->id,
          'name' => $ticketName,
          'description' => $ticketDescriptions[$key],
          'price' => $price,
          'quantity' => $ticketQuantities[$key]
        ]);
      } else {
        $ticket = Ticket::find($ticketId);
        $ticket->update([
          'name' => $ticketName,
          'description' => $ticketDescriptions[$key],
          'price' => $price,
          'quantity' => $ticketQuantities[$key],
        ]);
      }
    }

    if ($request->filled('group_ticket_name')) {
      $ticketId = $request->input('group_ticket_id');
      $price = $request->input('group_ticket_price');
      if ($ticketId == null) {
        Ticket::create([
          'event_id' => $event->id,
          'name' => $request->input('group_ticket_name'),
          'description' => $request->input('group_ticket_description'),
          'price' => $price,
          'quantity' => $request->input('group_ticket_quantity'),
          'group_count' => $request->input('group_count'),
          'is_group_ticket' => 1
        ]);
      } else {
        $ticket = Ticket::find($ticketId);
        $ticket->update([
          'name' => $request->input('group_ticket_name'),
          'description' => $request->input('group_ticket_description'),
          'price' => $price,
          'quantity' => $request->input('group_ticket_quantity'),
          'group_count' => $request->input('group_count')
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

  public function book(Request $request)
  {
    $eventId = $request->input('event_id');
    $event = Event::find($eventId);
    $tickets = $event->tickets->map(function ($ticket) {
      $totalBookedTickets = $this->calculateTotalBookedTicketsForTicket($ticket->id); // Calculate total booked tickets for this ticket
      $ticket->total_booked_tickets = $totalBookedTickets; // Add total booked tickets to the ticket object
      return $ticket;
    });

    $normalTickets = $tickets->where('is_group_ticket', false)->values()->all();
    $groupTickets = $tickets->where('is_group_ticket', true)->values()->all();

    return view('admin.events.book', compact('event', 'normalTickets', 'groupTickets'));
  }

  public function calculateTotalBookedTicketsForTicket($ticketId)
  {
    $totalBookedTickets = BookingTicket::whereHas('booking', function ($query) {
      $query->where('status', 'Complete');
    })->where('ticket_id', $ticketId)->sum('quantity');

    return $totalBookedTickets;
  }

  public function handleBooking(Request $request)
  {
    $user = User::where('email', $request->email)->first();
    if (!$user) {
      $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'mobile' => $request->mobile,
        'password' => Hash::make('Welcome@123'),
      ]);

      $user->roles()->attach(3);
    }

    $totalAmount = 0;

    // Create the booking
    $booking = Booking::create([
      'event_id' => $request->event_id,
      'user_id' => $user->id,
      'status' => 'Pending',
      'is_offline' => true,
      'payment_mode' => $request->payment_mode,
      'amount' => $totalAmount,
      'booking_date_time' => now(),
    ]);

    $request['available_for'] = 'in_house';
    $discount = Discount::where('code', $request->code)->first();
    if ($request->filled('code') && $this->bookingService->isDiscountCodeActive($discount, $request)) {
      $totalAmount = $this->bookingService->handleOfflineDiscount($request, $booking, $discount);
    } else {
      foreach ($request->except('_token', 'event_id', 'name', 'email', 'mobile', 'payment_mode', 'code', 'available_for') as $ticketId => $quantity) {
        $ticketId = substr($ticketId, strlen('ticket_id_'));
        $ticket = Ticket::findOrFail($ticketId);

        if ($quantity > 0) {
          $amount = $ticket->price * $quantity;
          $totalAmount += $amount;

          BookingTicket::create([
            'booking_id' => $booking->id,
            'ticket_id' => $ticketId,
            'quantity' => $quantity,
          ]);
        }
      }
    }

    $booking->update([
      'amount' => $totalAmount,
      'status' => 'Complete'
    ]);

    $result = Builder::create()
      ->writer(new PngWriter())
      ->writerOptions([])
      ->data($booking->reference_number)
      ->encoding(new Encoding('UTF-8'))
      ->errorCorrectionLevel(ErrorCorrectionLevel::High)
      ->size(300)
      ->margin(10)
      ->roundBlockSizeMode(RoundBlockSizeMode::Margin)
      ->build();

    // Save the QR code image to storage
    $filename = 'qrcode_' . $booking->reference_number . '.png';
    $path = 'public/qrcodes/' . $filename;
    Storage::put($path, $result->getString());

    // Generate the URL for the QR code image
    $url = Storage::url($path);
    $qrCodeUrl = $request->getSchemeAndHttpHost() . $url;
    $totalTicketQuantity = $booking->tickets()->sum('booking_tickets.quantity');

    $booking->load('event');
    Mail::to($user->email)->send(new BookingConfirmation($booking, $totalTicketQuantity, $qrCodeUrl));

    return redirect()->route('admin.bookings.index')->with('payment_success', 'Your booking has been confirmed.');
  }
}
