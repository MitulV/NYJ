@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.events.title_singular') }}
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
                                    <select id="category" name="category" class="form-control">
                                        <option selected>-- Select --</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="title">Title</label>
                                    <input type="text" name="title" class="form-control" id="title"
                                        placeholder="Enter Title">
                                </div>

                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="startDate">Start Date</label>
                                    <input type="date" class="form-control" name="startDate" id="startDate"
                                        min="{{ date('Y-m-d') }}">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="startTime">Start Time</label>
                                    <input type="time" class="form-control" name="startTime" id="startTime">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="endDate">End Date</label>
                                    <input type="date" class="form-control" name="endDate" id="endDate">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="endTime">End Time</label>
                                    <input type="time" class="form-control" name="endTime" id="endTime">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="booking_deadline">Booking Deadline</label>
                                    <input type="date" class="form-control" name="booking_deadline"
                                        id="booking_deadline" min="{{ date('Y-m-d') }}">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="description">Short Description (max 100 characters)</label>
                                    <textarea class="form-control" name="shortDescription" id="shortDescription" maxlength="100"></textarea>
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
                                        <option selected>-- Select --</option>
                                        @foreach ($cities as $city)
                                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="address">Address</label>
                                    <textarea class="form-control" name="address" id="address" rows="2" placeholder="Enter Address"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="longDescription">Long Description</label>
                                <textarea class="form-control" name="long_description" id="longDescription"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="termsConditions">Terms & Conditions</label>
                                <textarea class="form-control" name="terms_conditions" id="termsConditions" rows="3"
                                    placeholder="Enter Terms & Conditions"></textarea>
                            </div>


                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="ageRestrictions">Age Restrictions</label>
                                    <select id="ageRestrictions" name="age_restrictions" class="form-control">
                                        <option selected>None</option>
                                        <option>Minimum Age</option>
                                        <option>Maximum Age</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4" id="minAgeDiv">
                                    <label for="minAge">Minimum Age</label>
                                    <input type="number" name="min_age" class="form-control" id="minAge">
                                </div>
                                <div class="form-group col-md-4" id="maxAgeDiv">
                                    <label for="maxAge">Maximum Age</label>
                                    <input type="number" name="max_age" class="form-control" id="maxAge">
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary" onclick="stepper.previous()">Previous</button>
                            <button type="button" class="btn btn-primary" id="nextButton2">Next</button>
                        </div>

                        <div id="ticket-info" class="content" role="tabpanel" aria-labelledby="ticket-info-trigger">
                            <div id="ticket-info-container">
                                <div class="card shadow">
                                    <div class="card-body ticket-info-section">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="ticketName">Ticket Name</label>
                                                <input type="text" name="ticket_name[]" class="form-control"
                                                    placeholder="Enter Ticket Name">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="ticketDescription">Ticket Description</label>
                                                <input type="text" name="ticket_description[]" class="form-control"
                                                    placeholder="Enter Ticket Description">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="ticketPrice">Ticket Price</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">£</span>
                                                    </div>
                                                    <input type="number" name="ticket_price[]" class="form-control"
                                                        placeholder="Enter Ticket Price">
                                                </div>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="ticketQuantity">Number of Tickets</label>
                                                <input type="number" name="ticket_quantity[]" class="form-control"
                                                    placeholder="Enter Number of Tickets">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <button type="button" class="btn btn-primary" id="addTicketButton">Add+</button>
                            <button type="button" class="btn btn-primary" onclick="stepper.previous()">Previous</button>
                            <button type="button" class="btn btn-primary" id="nextButton3">Next</button>
                        </div>

                        <div id="additional-info" class="content" role="tabpanel"
                            aria-labelledby="additional-info-trigger">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="additionalInfo">Additional Info</label>
                                    <textarea class="form-control" name="additionalInfo" id="additionalInfo" rows="3"
                                        placeholder="Enter Additional Info (e.g., special instructions, event rules)"></textarea>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="banner1">Banner Image 1</label>
                                    <input type="file" class="form-control-file banner-input" id="banner1"
                                        name="banner1" accept="image/*">
                                    <img id="preview1" src="#" alt="Preview of Banner Image 1"
                                        style="display: none; max-width: 100%; height: auto;">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="banner2">Banner Image 2</label>
                                    <input type="file" class="form-control-file banner-input" id="banner2"
                                        name="banner2" accept="image/*">
                                    <img id="preview2" src="#" alt="Preview of Banner Image 2"
                                        style="display: none; max-width: 100%; height: auto;">
                                </div>
                            </div>

                            <div class="card card-success my-3">
                                <div class="card-header">
                                    <h3 class="card-title">Group Ticket</h3>
                                </div>

                                <div class="card-body">
                                    <div class="group_ticket-info-section">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="group_ticketName">Ticket Name</label>
                                                <input type="text" name="group_ticket_name" id="group_ticket_name"
                                                    class="form-control" placeholder="Enter Ticket Name">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="group_ticketDescription">Ticket Description</label>
                                                <input type="text" name="group_ticket_description"
                                                    id="group_ticket_description" class="form-control"
                                                    placeholder="Enter Ticket Description">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="group_ticketPrice">Ticket Price</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">£</span>
                                                    </div>
                                                    <input type="number" name="group_ticket_price"
                                                        id="group_ticket_price" class="form-control"
                                                        placeholder="Enter Ticket Price">
                                                </div>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="group_ticketQuantity">Number of Tickets</label>
                                                <input type="number" name="group_ticket_quantity"
                                                    id="group_ticket_quantity" class="form-control"
                                                    placeholder="Enter Number of Tickets">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="group_ticketQuantity">Number of Persons in Group</label>
                                                <input type="number" name="group_count" id="group_count"
                                                    class="form-control">
                                            </div>
                                        </div>
                                    </div>
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
                var bookingDeadline = $('#booking_deadline').val();
                var description = $('#shortDescription').val();
                if (category === '-- Select --' || title.trim() === '' || startDate.trim() === '' ||
                    startTime.trim() === '' || endDate.trim() === '' || endTime.trim() === '' ||
                    bookingDeadline.trim() === '' || $(
                        '#shortDescription').summernote('isEmpty')) {
                    alert('Please fill out all required fields.');
                    return;
                }

                //Check if endDate is after startDate
                if (endDate < startDate || (endDate === startDate && endTime <= startTime)) {
                    alert('End date and time should be after start date and time.');
                    return;
                }

                if (bookingDeadline >= startDate) {
                    alert('Booking deadline should be before the start date.');
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
                if (ageRestrictions === 'Minimum Age') {
                    if (minAge.trim() === '') {
                        alert('Please fill out the Minimum Age field.');
                        return;
                    }

                    if (parseFloat(minAge) < 0) {
                        alert('Minimum Age cannot be negative.');
                        event.preventDefault(); // Prevent default form submission if validation fails
                        return;
                    }

                }

                if (ageRestrictions === 'Maximum Age') {
                    if (maxAge.trim() === '') {
                        alert('Please fill out the Maximum Age field.');
                        return;
                    }

                    if (parseFloat(maxAge) < 0) {
                        alert('Maximum Age cannot be negative.');
                        event.preventDefault(); // Prevent default form submission if validation fails
                        return;
                    }

                }

                stepper.next();
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
                        alert('Please fill out all required fields');
                        return false;
                    }

                    // Validate that the price is not negative
                    if (parseFloat(ticketPrice) < 0) {
                        isValid = false;
                        alert('Ticket price cannot be negative');
                        return false;
                    }
                    if (parseFloat(ticketQuantity) < 0) {
                        isValid = false;
                        alert('Number of Tickets cannot be negative');
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
                    return;
                }

                var banner1 = $('#banner1').prop('files')[0];
                var banner2 = $('#banner2').prop('files')[0];
                if (!banner1 || !banner2) {
                    alert('Please upload both banner images.');
                    event.preventDefault(); // Prevent default form submission if validation fails
                    return;
                }

                // Validate group ticket fields
                var group_ticketName = $('#group_ticket_name').val();
                var group_ticketDescription = $('#group_ticket_description').val();
                var group_ticketPrice = $('#group_ticket_price').val();
                var group_ticketQuantity = $('#group_ticket_quantity').val();
                var group_count = $('#group_count').val();



                // Check if any of the fields is filled
                if (group_ticketName.trim() !== '' || group_ticketDescription.trim() !== '' ||
                    group_ticketPrice
                    .trim() !== '' || group_ticketQuantity.trim() !== '' || group_count.trim() !== '') {
                    // Validate if all fields are filled
                    if (group_ticketName.trim() === '' || group_ticketDescription.trim() === '' ||
                        group_ticketPrice
                        .trim() === '' || group_ticketQuantity.trim() === '' || group_count.trim() === '') {
                        alert('Please fill out all group ticket fields.');
                        event.preventDefault(); // Prevent default form submission if validation fails
                        return;
                    }
                    // Validate that price is not negative
                    if (parseFloat(group_ticketPrice) < 0) {
                        alert('Group ticket price cannot be negative.');
                        event.preventDefault(); // Prevent default form submission if validation fails
                        return;
                    }

                    if (parseFloat(group_ticketQuantity) < 0) {
                        alert('Group ticket Number of Tickets cannot be negative.');
                        event.preventDefault(); // Prevent default form submission if validation fails
                        return;
                    }

                    if (parseFloat(group_count) < 0) {
                        alert('Group ticket Number of Persons in Group cannot be negative.');
                        event.preventDefault(); // Prevent default form submission if validation fails
                        return;
                    }
                }
            });

            $('.banner-input').change(function() {
                var file = this.files[0];
                var reader = new FileReader();
                var preview = $(this).siblings('img');
                reader.onload = function(e) {
                    preview.attr('src', e.target.result);
                    preview.show();
                };
                reader.readAsDataURL(file);
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

            // Append the delete button to the cloned section
            var deleteButton = $('<button type="button" class="btn btn-danger delete-button">Delete</button>');
            ticketSection.append(deleteButton);

            // Add Bootstrap card and shadow classes to the cloned section
            ticketSection.addClass('card shadow');

            // Append the cloned section to the ticket-info-container div
            $('#ticket-info-container').append(ticketSection);
        });

        // Event delegation to handle click on close icon
        $('#ticket-info-container').on('click', '.delete-button', function() {
            $(this).closest('.ticket-info-section').remove();
        });
    </script>
@endsection
