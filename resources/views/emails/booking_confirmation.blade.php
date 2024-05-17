<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NYJ Tickets Booking Confirmation</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
    <div
        style="max-width: 600px; margin: auto; background-color: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">

        <h1 style="color: green; text-align: center;">Ticket Booked Successfully !</h1>

        <div style="text-align: center; margin-top: 20px;">
            <img src="{{ $qrCodeUrl }}" alt="Ticket QR Code"
                style="width: 150px; height: 150px;">
        </div>

        <div style="margin-top: 30px; overflow-x: auto;">
            <table style="border-collapse: collapse; width: 100%; max-width: 100%;">
                <tr>
                    <th
                        style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2; text-align: left; max-width: 50%;">
                        Booking Reference Number</th>
                    <td style="border: 1px solid #ddd; padding: 8px; max-width: 50%;">{{ $booking->reference_number }}
                    </td>
                </tr>
                <tr>
                    <th
                        style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2; text-align: left; max-width: 50%;">
                        Event</th>
                    <td style="border: 1px solid #ddd; padding: 8px; max-width: 50%;">{{ $booking->event->title }}</td>
                </tr>
                <tr>
                    <th
                        style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2; text-align: left; max-width: 50%;">
                        Total Tickets</th>
                    <td style="border: 1px solid #ddd; padding: 8px; max-width: 50%;">{{ $totalTicketQuantity }}</td>
                </tr>
                <tr>
                    <th
                        style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2; text-align: left; max-width: 50%;">
                        Event Date & Time</th>
                    <td>{{ \Carbon\Carbon::parse($booking->event->start_date)->format('d F Y') }}
                        {{ \Carbon\Carbon::parse($booking->event->start_time)->format('g:iA') }}
                    </td>
                </tr>

            </table>
        </div>

        <p style="margin-top: 30px; text-align: center; color: #666;">Thank you for booking with us!</p>
    </div>
</body>

</html>
