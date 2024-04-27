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
use Illuminate\Support\Facades\Auth;
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
    $tickets = $event->tickets;

    $normalTickets = $tickets->where('is_group_ticket', false)->values()->all();
    $groupTickets = $tickets->where('is_group_ticket', true)->values()->all();

    return view('registerUser', compact('event', 'normalTickets', 'groupTickets'));
  }

  public function bookEvent(Request $request)
  {

    $user = User::create([
      'name' => $request->name,
      'email' => $request->email,
      'password' => Hash::make($request->password),
    ]);

    $user->roles()->attach(3);

    Auth::login($user);

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

    foreach ($request->except('_token', 'event_id', 'name', 'email', 'password', 'password_confirmation') as $ticketId => $quantity) {
      // Ensure the request parameter represents a ticket ID
      if (Str::startsWith($ticketId, 'ticket_id_')) {
        // Extract the ticket ID from the parameter name
        $ticketId = substr($ticketId, strlen('ticket_id_'));

        $ticket = Ticket::findOrFail($ticketId);
        if ($quantity > 0) 
        {

          $amount = $ticket->price * $quantity;

          $totalAmount += $amount;

          // Create the booking ticket
          BookingTicket::create([
            'booking_id' => $booking->id,
            'ticket_id' => $ticketId,
            'quantity' => $quantity,
          ]);

          // Create the line item array for this ticket
          $lineItems[] = [
            'price' => $ticket->stripe_price_id,
            'quantity' => $quantity,
          ];
        }
      }
    }

    $booking->update(['amount' => $totalAmount]);

    $event = Event::find($request->event_id);

    $checkoutSessionUrl = $this->createCheckoutSession($lineItems, $event, $booking);

    return redirect($checkoutSessionUrl);
  }

  public function createCheckoutSession($lineItems, $event, $booking)
  {
    /** @var \App\User $user */
    $user = auth()->user();

    $organizer = User::find($event->organizer_id);
    $stripeSettings = $organizer->stripeSettings;
    $stripe = new StripeClient(config('stripe.api_keys.secret_key'));
    $checkoutSession = $stripe->checkout->sessions->create([
      'mode' => 'payment',
      'line_items' =>  $lineItems,
      'payment_intent_data' => [
        'application_fee_amount' => 100,
        'transfer_data' => ['destination' => $stripeSettings->account_id],
      ],
      'success_url' => route('paymentSuccess'),
      'cancel_url' => route('paymentCancel'),
    ]);

    Transaction::create([
      'stripe_checkout_id' => $checkoutSession->id,
      'booking_id' => $booking->id,
      'user_id' => $user->id,
      'amount_total' => $checkoutSession->amount_total,
      'status' => $checkoutSession->status
    ]);

    return $checkoutSession->url;
  }


  public function paymentSuccess(Request $request)
  {
    /** @var \App\User $user */
    $user = auth()->user();
    $transaction = Transaction::where('user_id', $user->id)
      ->latest('created_at')
      ->firstOrFail();

    $booking = Booking::where('user_id', $user->id)
      ->latest('created_at')
      ->firstOrFail();

    $stripe = new StripeClient(config('stripe.api_keys.secret_key'));
    $checkoutSession = $stripe->checkout->sessions->retrieve(
      $transaction->stripe_checkout_id,
      []
    );

    $transaction->update([
      'status' => $checkoutSession->status
    ]);

    if ($checkoutSession->status == 'complete') {
      $booking->update([
        'status' => 'complete'
      ]);
    }

    return redirect()->route('admin.mybookings.index')->with('payment_success', 'Your booking has been confirmed.');
  }

  public function paymentCancel(Request $request)
  {
    return redirect()->route('admin.mybookings.index')->with('payment_fail', 'Your  Payment has been Failed.');
  }
}
