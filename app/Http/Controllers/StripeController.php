<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Stripe\Stripe;
use Stripe\StripeClient;


class StripeController extends Controller
{
    private $stripe;
    private $user;
    public function __construct()
    {
        $this->stripe = new StripeClient(config('stripe.api_keys.secret_key'));
        Stripe::setApiKey(config('stripe.api_keys.secret_key'));

         /** @var \App\User $user */
         $this->user=auth()->user();
    }

    public function createStripeAccount(){
       
        $account=$this->stripe->accounts->create([
          'type' => 'express',
          'country' => 'US',
          'email' => $this->user->email,
          'capabilities' => [
            'card_payments' => ['requested' => true],
            'transfers' => ['requested' => true],
          ],
        ]);

        $this->user->stripeSettings()->updateOrCreate([
            'user_id' => $this->user->id,
            'account_id'=> $account->id,
            'account_json' => $account
            ]);

        $accountLink=$this->stripe->accountLinks->create([
            'account' => $account->id,
            'refresh_url' => route('reauth'),
            'return_url' => route('return'),
            'type' => 'account_onboarding',
          ]);

          $this->user->stripeSettings()->updateOrCreate([
            'onboarding_url' =>$accountLink->url
            ]);

    }

    public function reauth(){
        /** @var \App\User $user */
        $user=auth()->user();
        $account=$this->stripe->accounts->retrieve($user->stripe_connected_account_id, []);

        $accountLink=$this->stripe->accountLinks->create([
            'account' => $account->id,
            'refresh_url' => route('reauth'),
            'return_url' => route('return'),
            'type' => 'account_onboarding',
          ]);

          $user->stripeSettings()->updateOrCreate([
            'onboarding_url' =>$accountLink->url
            ]);

    }

    public function return(){
         /** @var \App\User $user */
        $user=auth()->user();
        $account=$this->stripe->accounts->retrieve($user->stripe_connected_account_id, []);

        $user->stripeSettings()->updateOrCreate([
            'account_json' => $account,
            'details_submitted' =>$account->details_submitted
            ]);
    }

}
