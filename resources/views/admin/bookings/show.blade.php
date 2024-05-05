@extends('layouts.admin')
@section('content')
    @if (session('payment_success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close text-light" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-check"></i> Payment successful!</h5>
            {{ session('success') }}
        </div>
    @endif

    @if (session('payment_fail'))
        <div class="alert alert-danger alert-dismissible">
            <h5><i class="icon fas fa-info"></i> Payment Failed!</h5>
            {{ session('payment_fail') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            Booking Details
        </div>

        <div class="card-body">
            <div class="mb-2">
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <div style="text-align: center;margin-bottom:10px">
                                @if (isset($qrCodeImage))
                                    <img src="data:image/png;base64,{{ $qrCodeImage }}" alt="QR Code"
                                        style="max-width: 100%; height: auto; width: 200px;">
                                @endif
                            </div>
                        </tr>
                        <tr>
                            <th>Booking Reference Number</th>
                            <td>{{ $booking->reference_number }}</td>
                        </tr>
                        <tr>
                            <th>Event</th>
                            <td>{{ $booking->event->title }}</td>
                        </tr>
                        <tr>
                            <th>Total Tickets</th>
                            <td>{{ $totalTicketQuantity }}</td>
                        </tr>
                        <tr>
                            <th>Total Amount</th>
                            <td>{{ $booking->amount }}</td>
                        </tr>
                        <tr>
                            <th>Booking Payment Status</th>
                            <td>{{ $booking->status }}</td>
                        </tr>
                        @if ($booking->is_offline)
                            <tr>
                                <th>Payment Mode</th>
                                <td>Offline, {{ $booking->payment_mode }}</td>
                            </tr>
                        @else
                            <tr>
                                <th>Payment Mode</th>
                                <td>Online</td>
                            </tr>
                        @endif
                        <tr>
                            <th>Event Date & Time</th>
                            <td>{{ \Carbon\Carbon::parse($booking->event->start_date)->format('d F Y') }}
                                {{ \Carbon\Carbon::parse($booking->event->start_time)->format('g:iA') }}
                            </td>
                        </tr>
                    </tbody>
                </table>

                <a style="margin-top:20px;" class="btn btn-default" href="{{ url()->previous() }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>

            <nav class="mb-3">
                <div class="nav nav-tabs">

                </div>
            </nav>
            <div class="tab-content">

            </div>
        </div>
    </div>
@endsection
