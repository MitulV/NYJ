<?php

namespace App\Http\Controllers;

use App\Booking;
use App\BookingTicket;
use App\Event;
use App\Http\Controllers\Controller;
use App\Ticket;
use App\Transaction;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Stripe\StripeClient;
use Illuminate\Support\Str;



class UserEventBookingController extends Controller
{
  public function eventDetails(Request $request)
  {
    $eventId = $request->query('eventId');
    $event = Event::find($eventId);
    return view('details', compact('event'));
  }

  public function registerUser(Request $request)
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

    return view('registerUser', compact('event', 'normalTickets', 'groupTickets'));
  }

  public function calculateTotalBookedTicketsForTicket($ticketId){
    $totalBookedTickets = BookingTicket::where('ticket_id', $ticketId)->sum('quantity');
    
    return $totalBookedTickets;
  }

  public function bookEvent(Request $request)
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

    $lineItems = [];
    $totalAmount = 0;

    // Create the booking
    $booking = Booking::create([
      'event_id' => $request->event_id,
      'user_id' => $user->id,
      'status' => 'Pending',
      'amount' => $totalAmount,
      'booking_date_time' => now(),
    ]);

    foreach ($request->except('_token', 'event_id', 'name', 'email') as $ticketId => $quantity) {
      // Ensure the request parameter represents a ticket ID
      if (Str::startsWith($ticketId, 'ticket_id_')) {
        // Extract the ticket ID from the parameter name
        $ticketId = substr($ticketId, strlen('ticket_id_'));

        $ticket = Ticket::findOrFail($ticketId);
        if ($quantity > 0) {

          $amount = $ticket->price * $quantity;
          $totalAmount += $amount;

          $price_in_cents = (int)($ticket->price * 100);

          // Create the booking ticket
          BookingTicket::create([
            'booking_id' => $booking->id,
            'ticket_id' => $ticketId,
            'quantity' => $quantity,
          ]);

          // Create the line item array for this ticket
          $lineItems[] = [
            'price_data' => [
              'currency' => 'GBP',
              'unit_amount' => $price_in_cents, // Amount in cents
              'product_data' => [
                'name' =>  $ticket->name, // You can customize the name here
              ],
            ],
            'quantity' => $quantity, // Quantity of this item
          ];
        }
      }
    }
    
    $booking->update(['amount' => $totalAmount]);

    $event = Event::find($request->event_id);

    $checkoutSessionUrl = $this->createCheckoutSession($lineItems, $event, $booking,$user);

    return redirect($checkoutSessionUrl);
  }

  public function createCheckoutSession($lineItems, $event, $booking,$user)
  {
    $organizer = User::find($event->organizer_id);
    $stripeSettings = $organizer->stripeSettings;
    $stripe = new StripeClient(config('stripe.api_keys.secret_key'));


    $transaction = Transaction::create([
      'booking_id' => $booking->id,
      'user_id' => $user->id,
      'payment_status' => 'unpaid'
    ]);

    $checkoutSession = $stripe->checkout->sessions->create([
      'mode' => 'payment',
      'line_items' =>  $lineItems,
      'metadata' => [
        'transaction_id' => $transaction->id,
        'booking_id' => $booking->id,
        'user_id' => $user->id,
      ],
      'payment_intent_data' => [
        'application_fee_amount' => 100, // Commission of Plateform (1$) but sent as cents
        'transfer_data' => ['destination' => $stripeSettings->account_id],
      ],
      'success_url' => route('paymentSuccess'),
      'cancel_url' => route('paymentCancel'),
    ]);

    $transaction->update([
      'stripe_checkout_id' => $checkoutSession->id,
      'amount_total' => $checkoutSession->amount_total,
      'status' => $checkoutSession->status
    ]);

    return $checkoutSession->url;
  }


  public function paymentSuccess()
  {
    return view('payment-success');
  }

  public function paymentCancel()
  {
    return view('payment-failure');
  }

  public function isValidUser(Request $request)
    {
        $email = $request->input('email');

        $user = User::where('email', $email)->first();

        if ($user) {
            // Check if the user is neither an admin nor an organizer
            $isValidUser = !$user->isAdmin() && !$user->isOrganizer();
            return response()->json(['isValidUser' => $isValidUser], $isValidUser ? 200 : 403);
        } else {
          return response()->json(['isValidUser' => true], 200);
        }
    }
}
