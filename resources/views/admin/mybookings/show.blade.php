@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.city.title') }}
    </div>

    <div class="card-body">
        <div class="mb-2">
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>Event ID</th>
                        <td>{{ $booking->event_id }}</td>
                    </tr>
                    <tr>
                        <th>Booking Reference Number</th>
                        <td>{{ $booking->reference_number }}</td>
                    </tr>
                    <tr>
                        <th>No. of Tickets</th>
                        <td>{{ $booking->number_of_tickets }}</td>
                    </tr>
                    <tr>
                        <th>Amount</th>
                        <td>{{ $booking->amount }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>{{ $booking->status }}</td>
                    </tr>
                    <tr>
                        <th>Booking Time</th>
                        <td>{{ \Carbon\Carbon::parse($booking->booking_date_time)->format('Y-m-d H:i:s') }}</td>
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