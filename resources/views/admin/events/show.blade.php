@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.events.title_singular') }} Details
        </div>
        <div class="card-body">
            <form id="eventForm" action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="bs-stepper">
                    <div class="bs-stepper-header" role="tablist">
                        <!-- your steps here -->
                        <div class="step" data-target="#basic-info">
                            <button type="button" class="step-trigger" role="tab" aria-controls="basic-info"
                                id="basic-info-trigger">
                                <span class="bs-stepper-circle">1</span>
                                <span class="bs-stepper-label">Basic Information</span>
                            </button>
                        </div>
                        <div class="line"></div>
                        <div class="step" data-target="#location-details">
                            <button type="button" class="step-trigger" role="tab" aria-controls="location-details"
                                id="location-details-trigger">
                                <span class="bs-stepper-circle">2</span>
                                <span class="bs-stepper-label">Location and Details</span>
                            </button>
                        </div>
                        <div class="line"></div>
                        <div class="step" data-target="#ticket-info">
                            <button type="button" class="step-trigger" role="tab" aria-controls="ticket-info"
                                id="ticket-info-trigger" aria-selected="false" disabled="disabled">
                                <span class="bs-stepper-circle">3</span>
                                <span class="bs-stepper-label">Ticket Information</span>
                            </button>
                        </div>
                        <div class="line"></div>
                        <div class="step" data-target="#additional-info">
                            <button type="button" class="step-trigger" role="tab" aria-controls="additional-info"
                                id="additional-info-trigger" aria-selected="false" disabled="disabled">
                                <span class="bs-stepper-circle">4</span>
                                <span class="bs-stepper-label">Additional Information</span>
                            </button>
                        </div>
                    </div>
                    <div class="bs-stepper-content">
                        <!-- your steps content here -->
                        <div id="basic-info" class="content" role="tabpanel" aria-labelledby="basic-info-trigger">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="category">Category</label>
                                    <select id="category" name="category" class="form-control" disabled>
                                        @if ($event->category)
                                            <option value="{{ $event->category->id }}">{{ $event->category->name }}</option>
                                        @endif
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="title">Title</label>
                                    <input type="text" name="title" class="form-control" id="title"
                                        value="{{ $event->title }}" disabled>
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
                                    <input type="time" class="form-control" name="startTime" id="startTime"
                                        value="{{ $event->start_time }}" disabled>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="endDate">End Date</label>
                                    <input type="date" class="form-control" name="endDate" id="endDate"
                                        value="{{ date('Y-m-d', strtotime($event->end_date)) }}" disabled>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="endTime">End Time</label>
                                    <input type="time" class="form-control" name="endTime" id="endTime"
                                        value="{{ $event->end_time }}" disabled>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="booking_deadline">Booking Deadline</label>
                                    <input type="date" class="form-control" name="booking_deadline"
                                        id="booking_deadline" value="{{ date('Y-m-d', strtotime($event->booking_deadline)) }}" disabled>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="description">Short Description (max 100 characters)</label>
                                    <textarea class="form-control" name="shortDescription" id="shortDescription" rows="2" maxlength="100"
                                        style="resize: none;">{{ $event->short_description }}</textarea>
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary" id="nextButton1">Next</button>
                        </div>
                        <div id="location-details" class="content" role="tabpanel"
                            aria-labelledby="location-details-trigger">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="city">City</label>
                                    <select id="city" name="city" class="form-control" disabled>
                                        @if ($event->city)
                                            <option value="{{ $event->city->id }}">{{ $event->city->name }}</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="address">Address</label>
                                    <textarea class="form-control" name="address" id="address" rows="2" disabled>{{ $event->address }}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="longDescription">Long Description</label>
                                <textarea class="form-control" name="long_description" id="longDescription" rows="5">{{ $event->long_description }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="termsConditions">Terms & Conditions</label>
                                <textarea class="form-control" name="terms_conditions" id="termsConditions" rows="3"
                                    placeholder="Enter Terms & Conditions">{{ $event->terms_and_conditions }}</textarea>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="ageRestrictions">Age Restrictions</label>
                                    <select id="ageRestrictions" name="age_restrictions" class="form-control" disabled>
                                        <option value="{{ $event->age_restrictions }}">{{ $event->age_restrictions }}
                                        </option>
                                    </select>
                                </div>
                                @if ($event->min_age > 0)
                                    <div class="form-group col-md-4" id="minAgeDiv">
                                        <label for="minAge">Minimum Age</label>
                                        <input type="number" name="min_age" class="form-control" id="minAge"
                                            value="$event->min_age">
                                    </div>
                                @endif

                                @if ($event->max_age > 0)
                                    <div class="form-group col-md-4" id="maxAgeDiv">
                                        <label for="maxAge">Maximum Age</label>
                                        <input type="number" name="max_age" class="form-control" id="maxAge"
                                            value="$event->max_age">
                                    </div>
                                @endif
                            </div>
                            <button type="button" class="btn btn-primary" onclick="stepper.previous()">Previous</button>
                            <button type="button" class="btn btn-primary" id="nextButton2">Next</button>
                        </div>

                        <div id="ticket-info" class="content" role="tabpanel" aria-labelledby="ticket-info-trigger">
                            @foreach($event->tickets as $ticket)
                                <div class="ticket-info-section">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="ticketName">Ticket Name</label>
                                            <input type="text" name="ticket_name[]" class="form-control"
                                                placeholder="Enter Ticket Name" value="{{ $ticket->name }}" disabled>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="ticketDescription">Ticket Description</label>
                                            <input type="text" name="ticket_description[]" class="form-control"
                                                placeholder="Enter Ticket Description" value="{{ $ticket->description }}" disabled>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="ticketPrice">Ticket Price</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">$</span>
                                                </div>
                                                <input type="number" name="ticket_price[]" class="form-control"
                                                    placeholder="Enter Ticket Price" value="{{ $ticket->price }}" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="ticketQuantity">Number of Tickets</label>
                                            <input type="number" name="ticket_quantity[]" class="form-control"
                                                placeholder="Enter Number of Tickets" value="{{ $ticket->quantity }}" disabled>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        
                            <button type="button" class="btn btn-primary" onclick="stepper.previous()">Previous</button>
                            <button type="button" class="btn btn-primary" id="nextButton3">Next</button>
                        </div>
                        

                        <div id="additional-info" class="content" role="tabpanel"
                            aria-labelledby="additional-info-trigger">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="additionalInfo">Additional Info</label>
                                    <textarea class="form-control" name="additionalInfo" id="additionalInfo" rows="3" disabled>{{ $event->additional_info }}</textarea>
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
                            
                            <button type="button" class="btn btn-primary" onclick="stepper.previous()">Previous</button>
                        </div>


                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Initially hide both Minimum Age and Maximum Age inputs
            $('#minAgeDiv').hide();
            $('#maxAgeDiv').hide();

            // Event listener for Age Restrictions dropdown change
            $('#ageRestrictions').change(function() {
                var selectedOption = $(this).val();

                // Hide both inputs if "None" is selected
                if (selectedOption === 'None') {
                    $('#minAgeDiv').hide();
                    $('#maxAgeDiv').hide();
                }
                // Show only Minimum Age input if "Minimum Age" is selected
                else if (selectedOption === 'Minimum Age') {
                    $('#minAgeDiv').show();
                    $('#maxAgeDiv').hide();
                }
                // Show only Maximum Age input if "Maximum Age" is selected
                else if (selectedOption === 'Maximum Age') {
                    $('#minAgeDiv').hide();
                    $('#maxAgeDiv').show();
                }
            });

            $('#nextButton1').click(function() {
                stepper.next(); // Assuming you have a stepper object
            });


            $('#nextButton2').click(function() {
                stepper.next(); // Assuming you have a stepper object
            });

            $('#nextButton3').click(function() {
                stepper.next(); // Assuming you have a stepper object
            });

            $('#longDescription').summernote({height: 150,});
            $('#longDescription').summernote('disable');

            $('#shortDescription').summernote({height: 100});
            $('#shortDescription').summernote('disable');

            $('#termsConditions').summernote({height: 150});
            $('#termsConditions').summernote('disable');

        });
    </script>
@endsection
