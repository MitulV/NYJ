<?php

namespace App\Services;

use App\BookingTicket;
use App\Discount;
use App\DiscountEventTicket;
use App\Ticket;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class BookingService
{
  public function __construct()
  {
  }

  public function handleOnlineDiscount($request, $booking, $discount)
  {

    if ($discount->discount_amount_per_ticket_or_booking == 'per_ticket') {

      $lineItems = [];
      $totalAmount = 0;
      foreach ($request->except('_token', 'event_id', 'name', 'email', 'code', 'available_for') as $ticketId => $quantity) {
        if (Str::startsWith($ticketId, 'ticket_id_')) {

          // Extract the ticket ID from the parameter name
          $ticketId = substr($ticketId, strlen('ticket_id_'));

          $ticket = Ticket::findOrFail($ticketId);
          if ($quantity > 0) {

            $price = $ticket->price;
            if ($this->isCodeAvailableForTicket($discount, $ticketId)) {
              if ($discount->discount_amount_type == 'fixed') {
                $price = ($ticket->price) - $discount->discount_amount;
              } else if ($discount->discount_amount_type == 'percentage') {
                $price = $ticket->price - ($ticket->price * ($discount->discount_amount / 100));
              }

              $booking->update([
                'discount_id' => $discount->id
              ]);
            }

            $amount = $price * $quantity;
            $totalAmount += $amount;

            BookingTicket::create([
              'booking_id' => $booking->id,
              'ticket_id' => $ticketId,
              'quantity' => $quantity,
            ]);

            $lineItems[] = [
              'price_data' => [
                'currency' => 'GBP',
                'unit_amount' => (int)($price * 100), // Amount in cents
                'product_data' => [
                  'name' =>  $ticket->name,
                ],
              ],
              'quantity' => $quantity,
            ];
          }
        }
      }

      return ['liteItems' => $lineItems, 'totalAmount' => $totalAmount];
    } else if ($discount->discount_amount_per_ticket_or_booking == 'per_booking') {

      $lineItems = [];
      $totalAmount = 0;
      $ticketsNames = '';
      $firstTicket = true;
      foreach ($request->except('_token', 'event_id', 'name', 'email', 'code', 'available_for') as $ticketId => $quantity) {
        if (Str::startsWith($ticketId, 'ticket_id_')) {

          // Extract the ticket ID from the parameter name
          $ticketId = substr($ticketId, strlen('ticket_id_'));

          $ticket = Ticket::findOrFail($ticketId);
          if ($quantity > 0) {

            $price = $ticket->price;

            $amount = $price * $quantity;
            $totalAmount += $amount;

            $ticketsNames .= !$firstTicket ? ', ' : '';
            $ticketsNames .= $ticket->name;
            $firstTicket = false;

            BookingTicket::create([
              'booking_id' => $booking->id,
              'ticket_id' => $ticketId,
              'quantity' => $quantity,
            ]);
          }
        }
      }

      if ($discount->discount_amount_type == 'fixed') {
        $totalAmount = $totalAmount - $discount->discount_amount;
      } else if ($discount->discount_amount_type == 'percentage') {
        $totalAmount = $totalAmount - ($totalAmount * ($discount->discount_amount / 100));
      }

      $booking->update([
        'discount_id' => $discount->id
      ]);


      $lineItems[] = [
        'price_data' => [
          'currency' => 'GBP',
          'unit_amount' => (int)($totalAmount * 100), // Amount in cents
          'product_data' => [
            'name' =>  $ticketsNames,
          ],
        ],
        'quantity' => 1,
      ];

      return ['liteItems' => $lineItems, 'totalAmount' => $totalAmount];
    }
  }

  public function handleOfflineDiscount($request, $booking, $discount)
  {
    if ($discount->discount_amount_per_ticket_or_booking == 'per_ticket') {
      $totalAmount = 0;
      foreach ($request->except('_token', 'event_id', 'name', 'email', 'mobile', 'payment_mode', 'code', 'available_for') as $ticketId => $quantity) {
        $ticketId = substr($ticketId, strlen('ticket_id_'));

        $ticket = Ticket::findOrFail($ticketId);
        if ($quantity > 0) {

          $price = $ticket->price;
          if ($this->isCodeAvailableForTicket($discount, $ticketId)) {
            if ($discount->discount_amount_type == 'fixed') {
              $price = ($ticket->price) - $discount->discount_amount;
            } else if ($discount->discount_amount_type == 'percentage') {
              $price = $ticket->price - ($ticket->price * ($discount->discount_amount / 100));
            }

            $booking->update([
              'discount_id' => $discount->id
            ]);
            $discount->increment('used');
          }

          $amount = $price * $quantity;
          $totalAmount += $amount;

          BookingTicket::create([
            'booking_id' => $booking->id,
            'ticket_id' => $ticketId,
            'quantity' => $quantity,
          ]);
        }
      }
      return $totalAmount;
    } else if ($discount->discount_amount_per_ticket_or_booking == 'per_booking') {
      $totalAmount = 0;
      foreach ($request->except('_token', 'event_id', 'name', 'email', 'mobile', 'payment_mode', 'code', 'available_for') as $ticketId => $quantity) {
        $ticketId = substr($ticketId, strlen('ticket_id_'));

        $ticket = Ticket::findOrFail($ticketId);
        if ($quantity > 0) {

          $price = $ticket->price;

          $amount = $price * $quantity;
          $totalAmount += $amount;

          BookingTicket::create([
            'booking_id' => $booking->id,
            'ticket_id' => $ticketId,
            'quantity' => $quantity,
          ]);
        }
      }

      if ($discount->discount_amount_type == 'fixed') {
        $totalAmount = ($totalAmount) - $discount->discount_amount;
      } else if ($discount->discount_amount_type == 'percentage') {
        $totalAmount = $totalAmount - ($totalAmount * ($discount->discount_amount / 100));
      }

      $booking->update([
        'discount_id' => $discount->id
      ]);
      $discount->increment('used');
      return $totalAmount;
    }
  }

  public function isDiscountCodeActive($discount, $request)
  {
    Log::info(json_encode($discount));
    if ($discount) {
      Log::info('if ($discount) -> true');
    } else {
      Log::info('if ($discount) -> false');
    }

    if ($discount) {
      $now = Carbon::now();
      if (is_null($discount->valid_from_date) && is_null($discount->valid_from_time)) {
        Log::info('at 206');
        if (is_null($discount->valid_to_date) && is_null($discount->valid_to_time)) {
          Log::info('at 208');
          if (($discount->used < $discount->quantity) || $discount->quantity == null) {
            Log::info('at 210');
            if (($discount->available_for == 'all') || ($discount->available_for == $request->available_for)) {
              Log::info('at 212');
              return true;
            }
          }
        } else if (!is_null($discount->valid_to_date) && !is_null($discount->valid_to_time)) {
          Log::info('at 217');
          $validTo = Carbon::createFromFormat('Y-m-d H:i:s', $discount->valid_to_date . ' ' . $discount->valid_to_time);
          if (($validTo >= $now) && (($discount->used < $discount->quantity) || $discount->quantity == null)) {
            Log::info('at 220');
            if (($discount->available_for == 'all') || ($discount->available_for == $request->available_for)) {
              Log::info('at 222');
              return true;
            }
          }
        }
      }
    }
    Log::info('at 229');
    return false;
  }

  public function isCodeAvailableForTicket($discount, $ticketId)
  {
    return DiscountEventTicket::where('discount_id', $discount->id)
      ->where('ticket_id', $ticketId)
      ->exists();
  }
}
