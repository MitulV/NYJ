@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            Edit {{ trans('cruds.events.title_singular') }}
        </div>
        <div class="card-body">
            <form id="eventForm" action="{{ route('admin.events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
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
                                    <select id="category" name="category" class="form-control">
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ $event->category_id == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="title">Title</label>
                                    <input type="text" name="title" class="form-control" id="title"
                                        value="{{ $event->title }}">
                                </div>

                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="startDate">Start Date</label>
                                    <input type="date" class="form-control" name="startDate" id="startDate"
                                        value="{{ date('Y-m-d', strtotime($event->start_date)) }}" min="{{ date('Y-m-d') }}">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="startTime">Start Time</label>
                                    <input type="time" class="form-control" name="startTime" id="startTime"
                                        value="{{ $event->start_time }}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="endDate">End Date</label>
                                    <input type="date" class="form-control" name="endDate" id="endDate"
                                        value="{{ date('Y-m-d', strtotime($event->end_date)) }}">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="endTime">End Time</label>
                                    <input type="time" class="form-control" name="endTime" id="endTime"
                                        value="{{ $event->end_time }}">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="booking_deadline">Booking Deadline</label>
                                    <input type="date" class="form-control" name="booking_deadline"
                                        id="booking_deadline" value="{{ date('Y-m-d', strtotime($event->booking_deadline)) }}">
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
                                    <select id="city" name="city" class="form-control">
                                        <option value="">Select City</option>
                                        @foreach ($cities as $city)
                                            <option value="{{ $city->id }}" {{ $event->city_id == $city->id ? 'selected' : '' }}>
                                                {{ $city->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="address">Address</label>
                                    <textarea class="form-control" name="address" id="address" rows="2">{{ $event->address }}</textarea>
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
                                    <select id="ageRestrictions" name="age_restrictions" class="form-control">
                                        <option {{ $event->age_restrictions == 'None' ? 'selected' : '' }}>None</option>
                                        <option {{ $event->age_restrictions == 'Minimum Age' ? 'selected' : '' }}>Minimum Age</option>
                                        <option {{ $event->age_restrictions == 'Maximum Age' ? 'selected' : '' }}>Maximum Age</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4" id="minAgeDiv" style="{{ $event->age_restrictions == 'Minimum Age' ? '' : 'display: none;' }}">
                                    <label for="minAge">Minimum Age</label>
                                    <input type="number" name="min_age" class="form-control" id="minAge" value="{{ $event->min_age }}">
                                </div>
                                <div class="form-group col-md-4" id="maxAgeDiv" style="{{ $event->age_restrictions == 'Maximum Age' ? '' : 'display: none;' }}">
                                    <label for="maxAge">Maximum Age</label>
                                    <input type="number" name="max_age" class="form-control" id="maxAge" value="{{ $event->max_age }}">
                                </div>
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
                                                placeholder="Enter Ticket Name" value="{{ $ticket->name }}">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="ticketDescription">Ticket Description</label>
                                            <input type="text" name="ticket_description[]" class="form-control"
                                                placeholder="Enter Ticket Description" value="{{ $ticket->description }}">
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
                                                    placeholder="Enter Ticket Price" value="{{ $ticket->price }}">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="ticketQuantity">Number of Tickets</label>
                                            <input type="number" name="ticket_quantity[]" class="form-control"
                                                placeholder="Enter Number of Tickets" value="{{ $ticket->quantity }}">
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
                                    <textarea class="form-control" name="additionalInfo" id="additionalInfo" rows="3">{{ $event->additional_info }}</textarea>
                                </div>
                            </div>
                            
                            <button type="button" class="btn btn-primary" onclick="stepper.previous()">Previous</button>
                            <button type="submit" class="btn btn-danger">Submit</button>
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
            var category = $('#category').val();
            var title = $('#title').val();
            var startDate = $('#startDate').val();
            var startTime = $('#startTime').val();
            var endDate = $('#endDate').val();
            var endTime = $('#endTime').val();
            var description = $('#shortDescription').val();
            if (category === '-- Select --' || title.trim() === '' || startDate.trim() === '' ||
                startTime.trim() === '' || endDate.trim() === '' || endTime.trim() === '' || $(
                    '#shortDescription').summernote('isEmpty')) {
                alert('Please fill out all required fields.');
                return;
            }

            // Proceed to the next step if all fields are filled
            stepper.next(); // Assuming you have a stepper object
        });


        $('#nextButton2').click(function() {
            var city = $('#city').val();
            var address = $('#address').val();
            var longDescription = $('#longDescription').val();
            var termsConditions = $('#termsConditions').val();
            var ageRestrictions = $('#ageRestrictions').val();
            var minAge = $('#minAge').val();
            var maxAge = $('#maxAge').val();

            if (city === '-- Select --' || address.trim() === '' || $('#longDescription').summernote(
                    'isEmpty') ||
                $('#termsConditions').summernote('isEmpty') || ageRestrictions === '-- Select --') {
                alert('Please fill out all required fields.');
                return;
            }

            // Validate age restrictions
            if (ageRestrictions === 'Minimum Age' && minAge.trim() === '') {
                alert('Please fill out the Minimum Age field.');
                return;
            }
            if (ageRestrictions === 'Maximum Age' && maxAge.trim() === '') {
                alert('Please fill out the Maximum Age field.');
                return;
            }

            // Proceed to the next step if all fields are filled
            stepper.next(); // Assuming you have a stepper object
        });

        $('#nextButton3').click(function() {
            var ticketSections = $('.ticket-info-section');

            var isValid = true;
            ticketSections.each(function(index, section) {
                var ticketName = $(section).find('.form-group input[name="ticket_name[]"]')
                    .val();
                var ticketDescription = $(section).find(
                    '.form-group input[name="ticket_description[]"]').val();
                var ticketPrice = $(section).find('.form-group input[name="ticket_price[]"]')
                    .val();
                var ticketQuantity = $(section).find(
                    '.form-group input[name="ticket_quantity[]"]').val();

                if (ticketName.trim() === '' || ticketDescription.trim() === '' || ticketPrice
                    .trim() === '' || ticketQuantity.trim() === '') {
                    isValid = false;
                    alert('Please fill out all required fields in Ticket ' + (index + 1) + '.');
                    return false;
                }
            });

            if (isValid) {
                stepper.next(); // Assuming you have a stepper object
            }
        });

        $('#eventForm').submit(function(event) {

            var shortDescriptionHtml = $('#shortDescription').summernote('code');
            $('#shortDescription').val(shortDescriptionHtml);
            var longDescriptionHtml = $('#longDescription').summernote('code');
            $('#longDescription').val(longDescriptionHtml);
            var termsConditionsHtml = $('#termsConditions').summernote('code');
            $('#termsConditions').val(termsConditionsHtml);
            
            

            var additionalInfo = $('#additionalInfo').val();
            if (additionalInfo.trim() === '') {
                alert('Please fill out all required fields.');
                event.preventDefault(); // Prevent default form submission if validation fails
            }
        });


        $('#longDescription').summernote({
            height: 150
        });

        $('#shortDescription').summernote({
            height: 100
        });

        $('#termsConditions').summernote({
            height: 150
        });

    });
</script>


<script>
    $('#addTicketButton').click(function() {
        // Clone the ticket-info-section
        var ticketSection = $('.ticket-info-section').first().clone(true);

        // Clear input values in the cloned section
        var inputs = ticketSection.find('input');
        inputs.each(function() {
            $(this).val('');
        });

        // Append the cloned section to the ticket-info-container div
        $('.ticket-info-section').append(ticketSection);
    });
</script>
@endsection
