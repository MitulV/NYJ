<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Http\Controllers\Controller;
use App\Mail\BookingConfirmation;
use App\Transaction;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Webhook;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class WebhookController extends Controller
{
    public function handle(Request $request)
    {
        Log::info('inside WebhookController::Handle method');

        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');
        $endpoint_secret = config('stripe.api_keys.webhook_secret');

        try {
            $event = Webhook::constructEvent(
                $payload,
                $sig_header,
                $endpoint_secret
            );
        } catch (SignatureVerificationException $e) {
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        Log::info(['$event->type is' => $event->type]);
        switch ($event->type) {
            case 'checkout.session.async_payment_failed':
                $this->handleCheckoutSession($event->data->object,$request);
                break;
            case 'checkout.session.async_payment_succeeded':
                $this->handleCheckoutSession($event->data->object,$request);
                break;
            case 'checkout.session.completed':
                $this->handleCheckoutSession($event->data->object,$request);
                break;
            case 'checkout.session.expired':
                $this->handleCheckoutSession($event->data->object,$request);
                break;
            default:
                return response()->json(['error' => 'Received unknown event type'], 400);
        }

        Log::info('exit from handle Method');
        return response()->json(['success' => true], 200);
    }


    public function handleCheckoutSession($session,$request)
    {
        Log::info('inside handleAction Method');


        $transactionId = $session->metadata->transaction_id;
        $bookingId = $session->metadata->booking_id;
        $userId = $session->metadata->user_id;

        Log::info(['$transactionId' => $transactionId]);
        Log::info(['$bookingId' => $bookingId]);
        Log::info(['$userId' => $userId]);

        $transaction = Transaction::find($transactionId);
        $booking = Booking::find($bookingId);
        $user = User::find($userId);

        $wasBookingPending = $booking->status != 'Complete';

        $transaction->update([
            'status' => $session->status,
            'payment_status' =>  $session->payment_status
        ]);

        if ($session->payment_status == 'paid') {
            $booking->update([
                'status' => 'Complete'
            ]);

            $discount = $booking->discount;
            if ($discount) {
                $discount->increment('used');
            }
        } else if ($session->payment_status == 'no_payment_required') {
            $booking->update([
                'status' => 'Cancelled'
            ]);
        }

        if ($wasBookingPending && $booking->status == 'Complete') {

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
        }

        Log::info('exit from handleAction Method');
    }
}
