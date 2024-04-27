<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Event;
use App\Http\Controllers\Controller;
use App\Ticket;
use App\Transaction;
use App\User;
use Stripe\Stripe;
use Stripe\StripeClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class StripeController extends Controller
{
  private $stripe;
  private $user;
  public function __construct()
  {
    $this->stripe = new StripeClient(config('stripe.api_keys.secret_key'));
    Stripe::setApiKey(config('stripe.api_keys.secret_key'));

    /** @var \App\User $user */
    $this->user = auth()->user();
  }

  public function createStripeAccount()
  {

    $account = $this->stripe->accounts->create([
      'type' => 'express',
      'country' => 'GB',
      'email' => $this->user->email,
      'capabilities' => [
        'card_payments' => ['requested' => true],
        'transfers' => ['requested' => true],
      ],
    ]);

    $this->user->stripeSettings()->create([
      'user_id' => $this->user->id,
      'account_id' => $account->id,
    ]);

    $accountLink = $this->stripe->accountLinks->create([
      'account' => $account->id,
      'refresh_url' => route('refresh'),
      'return_url' => route('return'),
      'type' => 'account_onboarding',
    ]);


    $this->user->stripeSettings()->update([
      'onboarding_url' => $accountLink->url
    ]);
  }

  public function refresh(Request $request)
  {
    /** @var \App\User $user */
    $user = auth()->user();
    $stripeSettings = $user->stripeSettings;

    $accountLink = $this->stripe->accountLinks->create([
      'account' => $stripeSettings->account_id,
      'refresh_url' => route('refresh'),
      'return_url' => route('return'),
      'type' => 'account_onboarding',
    ]);

    $user->stripeSettings()->update([
      'onboarding_url' => $accountLink->url
    ]);

    return redirect($accountLink->url);
  }

  public function return()
  {
    /** @var \App\User $user */
    $user = auth()->user();
    $stripeSettings = $user->stripeSettings;
    $account = $this->stripe->accounts->retrieve($stripeSettings->account_id, []);

    $user->stripeSettings()->update([
      'details_submitted' => $account->details_submitted
    ]);

    return redirect()->route('admin.home');
  }

  public function deleteAccount(Request $request)
  {

    $validator = Validator::make($request->all(), [
      'stripe_connected_account_id' => 'required'
    ]);

    if ($validator->fails()) {
      return redirect()->back()->withErrors($validator)->withInput();
    }

    $stripe_connected_account_id = $request->input('stripe_connected_account_id');

    return $this->stripe->accounts->delete($stripe_connected_account_id, []);
  }


  
}
