<?php

namespace App\Services;

use App\BookingTicket;
use App\Discount;
use App\DiscountEventTicket;
use App\Ticket;
use Carbon\Carbon;
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
    if (!$discount) {
      return false;
    }

    $now = Carbon::now();
    $validFrom = is_null($discount->valid_from_date) ? null : Carbon::createFromFormat('Y-m-d H:i:s', $discount->valid_from_date . ' ' . ($discount->valid_from_time ?? '00:00:00'));
    $validTo = is_null($discount->valid_to_date) ? null : Carbon::createFromFormat('Y-m-d H:i:s', $discount->valid_to_date . ' ' . ($discount->valid_to_time ?? '23:59:59'));

    // Check date conditions
    if (is_null($validFrom) && is_null($validTo)) {
      // Condition 1: both dates are null
      $dateValid = true;
    } elseif (!is_null($validFrom) && !is_null($validTo)) {
      // Condition 2: both dates are not null
      $dateValid = $now->between($validFrom, $validTo);
    } elseif (is_null($validFrom) && !is_null($validTo)) {
      // Condition 3: valid_from_date is null but valid_to_date is not null
      $dateValid = $now <= $validTo;
    } elseif (!is_null($validFrom) && is_null($validTo)) {
      // Condition 4: valid_from_date is not null but valid_to_date is null
      $dateValid = $now >= $validFrom;
    } else {
      $dateValid = false;
    }

    // Check other conditions
    if ($dateValid) {
      $quantityValid = ($discount->used < $discount->quantity) || is_null($discount->quantity);
      $availabilityValid = ($discount->available_for == 'all') || ($discount->available_for == $request->available_for);

      if ($quantityValid && $availabilityValid) {
        return true;
      }
    }

    return false;
  }


  public function isCodeAvailableForTicket($discount, $ticketId)
  {
    return DiscountEventTicket::where('discount_id', $discount->id)
      ->where('ticket_id', $ticketId)
      ->exists();
  }
}
