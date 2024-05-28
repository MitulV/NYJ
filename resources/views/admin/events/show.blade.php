@extends('layouts.admin')
@section('content')
    <div class="card" style="background-color: #FBFBFB">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.events.title_singular') }}
        </div>
        <div class="card-body">
            <form id="eventForm" action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="card card-success my-3">
                    <div class="card-header">
                        <h3 class="card-title">Basic Details</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label>Event Name</label>
                                <input type="text" name="title" class="form-control" id="title" value="{{ $event->title }}" disabled>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label>Event Category</label>
                                <select id="category" name="category" class="form-control" disabled>
                                    @if ($event->category)
                                            <option value="{{ $event->category->id }}">{{ $event->category->name }}</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="startDate">Start Date</label>
                                <input type="date" class="form-control" name="startDate" id="startDate"
                                value="{{ date('Y-m-d', strtotime($event->start_date)) }}" disabled>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="startTime">Start Time</label>
                                <input type="time" class="form-control" name="startTime" id="startTime" value="{{ $event->start_time }}" disabled>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="endDate">End Date</label>
                                <input type="date" class="form-control" name="endDate" id="endDate" value="{{ date('Y-m-d', strtotime($event->end_date)) }}" disabled>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="endTime">End Time</label>
                                <input type="time" class="form-control" name="endTime" id="endTime" value="{{ $event->end_time }}" disabled>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="booking_deadline">Booking Deadline</label>
                                <input type="date" class="form-control" name="booking_deadline" id="booking_deadline"
                                value="{{ date('Y-m-d', strtotime($event->booking_deadline)) }}" disabled>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label>Short Description</label>
                                <textarea class="form-control" name="shortDescription" id="shortDescription" maxlength="100" disabled>{!! htmlspecialchars_decode($event->short_description) !!}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-success my-3">
                    <div class="card-header">
                        <h3 class="card-title">Location Details</h3>
                    </div>
                    <div class="card-body">

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label>Event City</label>
                                <select id="city" name="city" class="form-control" disabled>
                                    @if ($event->city)
                                            <option value="{{ $event->city->id }}">{{ $event->city->name }}</option>
                                        @endif
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label>Address</label>
                                <textarea class="form-control" name="address" id="address" rows="2" placeholder="Enter Address" disabled>{{ $event->address }}</textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Long Description</label>
                            <textarea class="form-control" name="long_description" id="longDescription" placeholder="Enter Long Description">{!! htmlspecialchars_decode($event->long_description) !!}</textarea>
                        </div>

                        <div class="form-group">
                            <label>Terms & Conditions</label>
                            <textarea class="form-control" name="terms_conditions" id="termsConditions" rows="3"
                                placeholder="Enter Terms & Conditions">{!! htmlspecialchars_decode($event->terms_and_conditions) !!}</textarea>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Age Restrictions</label>
                                <select id="ageRestrictions" name="age_restrictions" class="form-control" disabled>
                                    <option value="{{ $event->age_restrictions }}">{{ $event->age_restrictions }}
                                    </option>
                                </select>
                            </div>
                            @if ($event->min_age > 0)
                                    <div class="form-group col-md-4" id="minAgeDiv" style="{{ $event->age_restrictions == 'Minimum Age' ? '' : 'display: none;' }}">
                                        <label for="minAge">Minimum Age</label>
                                        <input type="number" name="min_age" class="form-control" id="minAge"
                                            value="{{$event->min_age}}" disabled>
                                    </div>
                                @endif

                                @if ($event->max_age > 0)
                                    <div class="form-group col-md-4" id="maxAgeDiv" style="{{ $event->age_restrictions == 'Maximum Age' ? '' : 'display: none;' }}">
                                        <label for="maxAge">Maximum Age</label>
                                        <input type="number" name="max_age" class="form-control" id="maxAge"
                                            value="{{$event->max_age}}" disabled>
                                    </div>
                                @endif
                        </div>
                    </div>
                </div>

                <div class="card card-success my-3">
                    <div class="card-header">
                        <h3 class="card-title">Ticket Details</h3>
                    </div>
                    <div class="card-body">

                        <div id="ticket-section">
                            @foreach($event->tickets as $ticket)
                                @if ($ticket->is_group_ticket==0)
                                <div id="ticket-info-container">
                                    <div class="card shadow">
                                        <div class="card-body ticket-info-section">
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label>Ticket Name</label>
                                                    <input type="text" name="ticket_name[]" class="form-control"
                                                        placeholder="Enter Ticket Name" value="{{ $ticket->name }}" disabled>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>Ticket Description</label>
                                                    <input type="text" name="ticket_description[]" class="form-control"
                                                        placeholder="Enter Ticket Description" value="{{ $ticket->description }}" disabled>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
    
                                                    <div class="input-group">
                                                        <label for="ticketPrice">Ticket Price</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">£</span>
                                                            </div>
                                                            <input type="number" name="ticket_price[]" class="form-control"
                                                                placeholder="Enter Ticket Price" value="{{ $ticket->price }}" disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>Number of Tickets</label>
                                                    <input type="number" name="ticket_quantity[]" class="form-control"
                                                        placeholder="Enter Number of Tickets" value="{{ $ticket->quantity }}" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>


                <div class="card card-success my-3">
                    <div class="card-header">
                        <h3 class="card-title">Additional Details</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-row" style="margin-top: 25px">
                            <div class="form-group col-md-12">
                                <label>Additional Info</label>
                                <textarea class="form-control" name="additionalInfo" id="additionalInfo" rows="3"
                                    placeholder="Enter Additional Info (e.g., special instructions, event rules)" disabled>{{ $event->additional_info }}</textarea>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="banner1">Banner Image 1</label>
                                <img src="{{ $event->image1 }}" alt="Banner Image 1" style="max-width: 100%; height: auto;">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="banner2">Banner Image 2</label>
                                <img src="{{ $event->image2 }}" alt="Banner Image 2" style="max-width: 100%; height: auto;">
                            </div>
                        </div>
                    </div>

                </div>

                <div class="card card-success my-3">
                    <div class="card-header">
                        <h3 class="card-title">Group Ticket</h3>
                    </div>

                    <div class="card-body">
                        @foreach($event->tickets as $ticket)
                            @if ($ticket->is_group_ticket==1)
                            <div class="group_ticket-info-section">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>Ticket Name</label>
                                        <input type="text" name="group_ticket_name" id="group_ticket_name"
                                            class="form-control" placeholder="Enter Ticket Name" value="{{ $ticket->name }}" disabled>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Ticket Description</label>
                                        <input type="text" name="group_ticket_description" id="group_ticket_description"
                                            class="form-control" placeholder="Enter Ticket Description" value="{{ $ticket->description }}" disabled>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
    
                                        <div class="input-group">
                                            <label for="ticketPrice">Ticket Price</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">£</span>
                                                </div>
                                                <input type="number" name="group_ticket_price"
                                                            id="group_ticket_price" class="form-control"
                                                            placeholder="Enter Ticket Price" value="{{ $ticket->price }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Number of Tickets</label>
                                        <input type="number" name="group_ticket_quantity" id="group_ticket_quantity"
                                            class="form-control" placeholder="Enter Number of Tickets" value="{{ $ticket->quantity }}" disabled>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>Number of Persons in Group</label>
                                        <input type="number" name="group_count" id="group_count" class="form-control"
                                            placeholder="Number of Persons in Group" value="{{ $ticket->group_count }}" disabled>
                                    </div>
                                </div>
                            </div>
                            @endif
                        @endforeach
                        
                    </div>

                </div>
            </form>
        </div>
    </div>
@endsection


@section('scripts')
    <script>
        $('#eventForm').submit(function(event) {
                if (validateForm()) {
                    return true;
                } else {
                    event.preventDefault();
                    return false;
                }
        });


        $(document).ready(function() {

            $('#ageRestrictions').change(function() {
                var selectedOption = $(this).val();
                if (selectedOption === 'None') {
                    $('#minAgeDiv').hide();
                    $('#maxAgeDiv').hide();
                } else if (selectedOption === 'Minimum Age') {
                    $('#minAgeDiv').show();
                    $('#maxAgeDiv').hide();
                } else if (selectedOption === 'Maximum Age') {
                    $('#minAgeDiv').hide();
                    $('#maxAgeDiv').show();
                }
            });
        });
           </script>
@endsection
