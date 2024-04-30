<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;


class BookingConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public $totalTicketQuantity;
    public $qrCodeImage;

    /**
     * Create a new message instance.
     * @param $booking
     * @param $totalTicketQuantity
      * @param $qrCodeImage
     */
    public function __construct($booking, $totalTicketQuantity,$qrCodeImage)
    {
        $this->booking = $booking;
        $this->totalTicketQuantity = $totalTicketQuantity;
        $this->qrCodeImage = $qrCodeImage;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('admin@NyjTickets.com', 'Admin'),
            subject: 'Booking Confirmation',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.booking_confirmation',
            with: [
                'booking' => $this->booking,
                'totalTicketQuantity' => $this->totalTicketQuantity,
                'qrCodeImage' => $this->qrCodeImage
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
