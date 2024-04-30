<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Http\Controllers\Controller;
use App\Transaction;
use App\User;
use Illuminate\Http\Request;
use Stripe\StripeClient;

class WebhookController extends Controller
{
  public function handle(Request $request)
  {

    $transactionId = '';
    $bookingId = '';
    $userId = '';
    $transaction = Transaction::find($transactionId);
    $booking = Booking::find($bookingId);
    $user = User::find($userId);

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
  }
}
