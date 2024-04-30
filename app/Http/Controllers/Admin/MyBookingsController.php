<?php

namespace App\Http\Controllers\Admin;

use App\Booking;
use App\Http\Controllers\Controller;
use App\Mail\BookingConfirmation;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Response;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;

class MyBookingsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('My_Bookings'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $bookings = Booking::where('user_id', auth()->user()->id)->with('event')->get();
        return view('admin.mybookings.index', compact('bookings'));
    }


    public function show(Booking $booking)
    {
        abort_if(Gate::denies('My_Bookings'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $totalTicketQuantity = $booking->tickets()->sum('booking_tickets.quantity');

        // Generate QR code
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

        $qrCodeImage = base64_encode($result->getString());

        $booking->load('event');
        return view('admin.mybookings.show', compact('booking', 'totalTicketQuantity', 'qrCodeImage'));
    }
}
