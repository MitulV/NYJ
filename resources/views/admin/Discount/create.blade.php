@extends('layouts.admin')
@section('content')
    <div class="card" style="background-color: #FBFBFB">
        <div class="card-header">
            Create Discount Code
        </div>
        <div class="card-body">
            <form id="discountForm" action="{{ route('admin.discount.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <input type="text" name="code" class="form-control" id="code"
                            placeholder="Discount Code">
                    </div>
                </div>

                <div class="form-row">
                    <div class="container">
                        <div class="scrollable-list" style="max-height: 300px;overflow-y: auto;border: 1px solid #ccc;padding: 10px;">
                            <ul style="list-style: none">
                                <li>
                                    <li>
                                        <label class="m-1">
                                            <input type="checkbox" class="subOption" id="all"> 
                                            All events
                                        </label>
                                    </li>
                                    <ul style="list-style: none">
                                        @foreach($events as $event)
                                            <li>
                                                <input type="checkbox" id="event-{{ $event->id }}">
                                                <label class="m-1" for="event-{{ $event->id }}">{{ $event->title }}</label>
                                                <ul style="list-style: none">
                                                    @foreach($event->tickets as $ticket)
                                                        <li>
                                                            <label class="m-1">
                                                                <input type="checkbox" class="subOption" id="ticket-{{ $ticket->id }}"> 
                                                                {{ $ticket->name }}
                                                            </label>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            </ul>        
                        </div>
                    </div>
                </div>
                
                

                <div class="form-row align-items-center mt-5">
                   
                    <div class="form-group col-auto">
                        <span>Discount amount</span>
                    </div>
                    <div class="form-group col-auto">
                        <select id="currency" name="currency" class="form-control">
                            <option value="fixed" selected>£</option>
                            <option value="percentage">%</option>
                        </select>
                    </div>
                    <div class="form-group col-auto">
                        <input type="number" class="form-control" name="value" id="endDavaluete">
                    </div>
                    <div class="form-group col-auto">
                        <select id="currency" name="currency" class="form-control">
                            <option value="per_ticket" selected>Per Ticket</option>
                            <option value="per_booking">Per Booking</option>
                        </select>
                    </div>
                </div>


                <div class="form-row align-items-center">
                    <div class="form-group col-auto">
                        <input type="checkbox" name="remember" id="remember">
                    </div>
                    <div class="form-group col-auto">
                        <span>Set discount code valid from</span>
                    </div>
                    <div class="form-group col-auto">
                        <input type="date" class="form-control" name="startDate" id="startDate"
                            min="{{ date('Y-m-d') }}">
                    </div>
                    <div class="form-group col-auto">
                        <span>at</span>
                    </div>
                    <div class="form-group col-auto">
                        <input type="time" class="form-control" name="startTime" id="startTime">
                    </div>
                </div>

                <div class="form-row align-items-center">
                    <div class="form-group col-auto">
                        <input type="checkbox" name="remember" id="remember">
                    </div>
                    <div class="form-group col-auto">
                        <span>Set discount code expiry to</span>
                    </div>
                    <div class="form-group col-auto">
                        <input type="date" class="form-control" name="endDate" id="endDate"
                            min="{{ date('Y-m-d') }}">
                    </div>
                    <div class="form-group col-auto">
                        <span>at</span>
                    </div>
                    <div class="form-group col-auto">
                        <input type="time" class="form-control" name="endTime" id="endTime">
                    </div>
                </div>


                <div class="form-row align-items-center">
                    <div class="form-group col-auto">
                        <input type="radio" name="remember" id="remember">
                    </div>
                    <div class="form-group col-auto">
                        <span>Discount code can be used unlimited number of times</span>
                    </div>
                </div>

                <div class="form-row align-items-center">
                    <div class="form-group col-auto">
                        <input type="radio" name="remember" id="remember">
                    </div>
                    <div class="form-group col-auto">
                        <span>Discount code can be used</span>
                    </div>
                    <div class="form-group col-auto">
                        <input type="number" class="form-control" name="value" id="endDavaluete">
                    </div>
                    <div class="form-group col-auto">
                        <span>times in total</span>
                    </div>
                </div>

                <div class="form-row align-items-center">
                    <div class="form-group col-auto">
                        <input type="radio" name="available_for" id="available_for">
                    </div>
                    <div class="form-group col-auto">
                        <span>Discount code available on all bookings</span>
                    </div>
                </div>
                <div class="form-row align-items-center">
                    <div class="form-group col-auto">
                        <input type="radio" name="available_for" id="available_for">
                    </div>
                    <div class="form-group col-auto">
                        <span>Discount code available on in-house bookings only</span>
                    </div>
                </div>
                <button type="submit" class="btn btn-success">Submit</button>
            </form>
        </div>
    </div>
@endsection
