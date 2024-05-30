@extends('layouts.admin')
@section('content')
    <style>
        .scrollable-list {
            max-height: 300px;
            overflow-y: auto;
            border: 1px solid #ccc;
            padding: 10px;
        }
    </style>

    <div class="card" style="background-color: #FBFBFB">
        <div class="card-header">
           Discount Code Details
        </div>
        <div class="card-body">
            <form @submit.prevent="submitForm" id="discountForm" action="{{ route('admin.discount.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <input type="text" name="code" class="form-control" id="code" placeholder="Discount Code" value="{{$discount->code}}" disabled>
                    </div>
                </div>

                <div class="form-row">
                    <div class="container">
                        <div class="scrollable-list">
                            <ul style="list-style: none">
                                <li>
                                    <label class="m-1">
                                        <input type="checkbox" id="select_all_events" disabled>
                                        All events
                                    </label>
                                </li>
                                <ul style="list-style: none" id="event_list">
                                    @foreach($events as $event)
                                        @php
                                            $allTicketsChecked = true;
                                        @endphp
                                        <li>
                                            <input type="checkbox" class="event-checkbox" id="event-{{ $event->id }}" data-event-id="{{ $event->id }}" disabled>
                                            <label class="m-1" for="event-{{ $event->id }}">{{ $event->title }}</label>
                                            <ul style="list-style: none">
                                                @foreach($event->tickets as $ticket)
                                                    @php
                                                        $checked = $discount->discountEventTickets->contains('ticket_id', $ticket->id) ? 'checked' : '';
                                                        if (!$checked) {
                                                            $allTicketsChecked = false;
                                                        }
                                                    @endphp
                                                    <li>
                                                        <label class="m-1">
                                                            <input type="checkbox" class="ticket-checkbox" id="ticket-{{ $ticket->id }}" data-ticket-id="{{ $ticket->id }}" {{ $checked }} disabled>
                                                            <span>{{ $ticket->name }}</span>
                                                        </label>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                        @if ($allTicketsChecked)
                                            <script>
                                                $('#event-{{ $event->id }}').prop('checked', true);
                                            </script>
                                        @endif
                                    @endforeach
                                </ul>
                            </ul>
                        </div>
                        <h6 class="m-1">Price categories selected: <span id="selected_tickets_count">none</span></h6>
                    </div>
                </div>
                
            

                <div class="form-row align-items-center mt-5">

                    <div class="form-group col-auto">
                        <span>Discount amount</span>
                    </div>
                    <div class="form-group col-auto">
                        <select id="discount_amount_type" name="discount_amount_type" class="form-control" disabled>
                            <option value="fixed" {{ $discount->discount_amount_type == 'fixed' ? 'selected' : '' }}>£</option>
                            <option value="percentage" {{ $discount->discount_amount_type == 'percentage' ? 'selected' : '' }}>%</option>
                        </select>                        
                    </div>
                    <div class="form-group col-auto">
                        <input type="number" class="form-control" name="discount_amount" id="discount_amount" value="{{ $discount->discount_amount}}" disabled>
                    </div>
                    <div class="form-group col-auto">
                        <select id="discount_amount_per_ticket_or_booking" name="discount_amount_per_ticket_or_booking"
                            class="form-control" disabled>
                            <option value="per_ticket" {{ $discount->discount_amount_per_ticket_or_booking == 'per_ticket' ? 'selected' : '' }}>Per Ticket</option>
                            <option value="per_booking" {{ $discount->discount_amount_per_ticket_or_booking == 'per_booking' ? 'selected' : '' }}>Per Booking</option>
                        </select>
                    </div>
                </div>


                <div class="form-row align-items-center">
                    <div class="form-group col-auto">
                        <input type="checkbox" name="chk_valid_from" id="chk_valid_from" 
               {{ $discount->valid_from_date && $discount->valid_from_time ? 'checked' : '' }} disabled>
                    </div>
                    <div class="form-group col-auto">
                        <span>Set discount code valid from</span>
                    </div>
                    <div class="form-group col-auto">
                        <input type="date" class="form-control" name="valid_from_date" id="valid_from_date"
               value="{{ $discount->valid_from_date }}" min="{{ date('Y-m-d') }}" disabled>
                    </div>
                    <div class="form-group col-auto">
                        <span>at</span>
                    </div>
                    <div class="form-group col-auto">
                        <input type="time" class="form-control" name="valid_from_time" id="valid_from_time"
               value="{{ $discount->valid_from_time }}" disabled>
                    </div>
                </div>

                <div class="form-row align-items-center">
                    <div class="form-group col-auto">
                        <input type="checkbox" name="chk_valid_to" id="chk_valid_to" 
                               {{ $discount->valid_to_date && $discount->valid_to_time ? 'checked' : '' }} disabled>
                    </div>
                    <div class="form-group col-auto">
                        <span>Set discount code expiry to</span>
                    </div>
                    <div class="form-group col-auto">
                        <input type="date" class="form-control" name="valid_to_date" id="valid_to_date"
                               value="{{ $discount->valid_to_date }}" min="{{ date('Y-m-d') }}" disabled>
                    </div>
                    <div class="form-group col-auto">
                        <span>at</span>
                    </div>
                    <div class="form-group col-auto">
                        <input type="time" class="form-control" name="valid_to_time" id="valid_to_time"
                               value="{{ $discount->valid_to_time }}" disabled>
                    </div>
                </div>
                


                <div class="form-row align-items-center">
                    <div class="form-group col-auto">
                        <input type="radio" name="quantity_radio" id="quantity_radio1" value="unlimited" 
                               {{ is_null($discount->quantity) ? 'checked' : '' }} disabled>
                    </div>
                    <div class="form-group col-auto">
                        <span>Discount code can be used unlimited number of times</span>
                    </div>
                </div>
                
                <div class="form-row align-items-center">
                    <div class="form-group col-auto">
                        <input type="radio" name="quantity_radio" id="quantity_radio2" value="limited" 
                               {{ !is_null($discount->quantity) ? 'checked' : '' }} disabled>
                    </div>
                    <div class="form-group col-auto">
                        <span>Discount code can be used</span>
                    </div>
                    <div class="form-group col-auto">
                        <input type="number" class="form-control" name="quantity" id="quantity" 
                               value="{{ $discount->quantity }}" disabled>
                    </div>
                    <div class="form-group col-auto">
                        <span>times in total</span>
                    </div>
                </div>
                


                <div class="form-row align-items-center">
                    <div class="form-group col-auto">
                        <input type="radio" name="available_for" id="available_for_all" value="all" 
                               {{ $discount->available_for == 'all' ? 'checked' : '' }} disabled>
                    </div>
                    <div class="form-group col-auto">
                        <label for="available_for_all">Discount code available on all bookings</label>
                    </div>
                </div>
                <div class="form-row align-items-center">
                    <div class="form-group col-auto">
                        <input type="radio" name="available_for" id="available_for_in_house" value="in_house" 
                               {{ $discount->available_for == 'in_house' ? 'checked' : '' }} disabled>
                    </div>
                    <div class="form-group col-auto">
                        <label for="available_for_in_house">Discount code available on in-house bookings only</label>
                    </div>
                </div>
                
            </form>
        </div>
    </div>

    
@endsection

@section('scripts')
<script>
    $(document).ready(function() {

        updateSelectedTicketsCount();

            $('.ticket-checkbox').change(function() {
                updateSelectedTicketsCount();
            });

            function updateSelectedTicketsCount() {
                var selectedTicketsCount = $('.ticket-checkbox:checked').length;
                $('#selected_tickets_count').text(selectedTicketsCount > 0 ? selectedTicketsCount : 'none');
            }
    });
</script>

@endsection