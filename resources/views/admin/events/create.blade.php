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
                                <input type="text" name="title" class="form-control" id="title">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label>Event Category</label>
                                <select id="category" name="category" class="form-control">
                                    <option>-- Select --</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
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
                            <div class="form-group col-md-12">
                                <label for="booking_deadline">Booking Deadline</label>
                                <input type="date" class="form-control" name="booking_deadline" id="booking_deadline"
                                    min="{{ date('Y-m-d') }}">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label>Short Description</label>
                                <textarea class="form-control" name="shortDescription" id="shortDescription" maxlength="100"></textarea>
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
                                <select id="city" name="city" class="form-control">
                                    <option>-- Select --</option>
                                    @foreach ($cities as $city)
                                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label>Address</label>
                                <textarea class="form-control" name="address" id="address" rows="2" placeholder="Enter Address"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Long Description</label>
                            <textarea class="form-control" name="long_description" id="longDescription" placeholder="Enter Long Description"></textarea>
                        </div>

                        <div class="form-group">
                            <label>Terms & Conditions</label>
                            <textarea class="form-control" name="terms_conditions" id="termsConditions" rows="3"
                                placeholder="Enter Terms & Conditions"></textarea>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Age Restrictions</label>
                                <select id="ageRestrictions" name="age_restrictions" class="form-control">
                                    <option selected>None</option>
                                    <option>Minimum Age</option>
                                    <option>Maximum Age</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4" id="minAgeDiv">
                                <label>Minimum Age</label>
                                <input type="number" name="min_age" class="form-control" id="minAge">
                            </div>
                            <div class="form-group col-md-4" id="maxAgeDiv">
                                <label>Maximum Age</label>
                                <input type="number" name="max_age" class="form-control" id="maxAge">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-success my-3">
                    <div class="card-header">
                        <h3 class="card-title">Ticket Details</h3>
                    </div>
                    <div class="card-body">

                        <div id="ticket-section">
                            <div id="ticket-info-container">
                                <div class="card shadow">
                                    <div class="card-body ticket-info-section">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>Ticket Name</label>
                                                <input type="text" name="ticket_name[]" class="form-control"
                                                    placeholder="Enter Ticket Name">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Ticket Description</label>
                                                <input type="text" name="ticket_description[]" class="form-control"
                                                    placeholder="Enter Ticket Description">
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
                                                            placeholder="Enter Ticket Price">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Number of Tickets</label>
                                                <input type="number" name="ticket_quantity[]" class="form-control"
                                                    placeholder="Enter Number of Tickets">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <button type="button" class="btn btn-primary" id="addTicketButton">Add+</button>
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
                                    <label>Ticket Name</label>
                                    <input type="text" name="group_ticket_name" id="group_ticket_name"
                                        class="form-control" placeholder="Enter Ticket Name">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Ticket Description</label>
                                    <input type="text" name="group_ticket_description" id="group_ticket_description"
                                        class="form-control" placeholder="Enter Ticket Description">
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
                                            <input type="number" name="group_ticket_price" id="group_ticket_price"
                                                class="form-control" placeholder="Enter Ticket Price">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Number of Tickets</label>
                                    <input type="number" name="group_ticket_quantity" id="group_ticket_quantity"
                                        class="form-control" placeholder="Enter Number of Tickets">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Number of Persons in Group</label>
                                    <input type="number" name="group_count" id="group_count" class="form-control"
                                        placeholder="Number of Persons in Group">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <button type="submit" class="btn btn-danger">Submit</button>
            </form>
        </div>
    </div>
@endsection


@section('scripts')
    <script>
        $('#eventForm').submit(function(event) {
            var shortDescriptionHtml = $('#shortDescription').summernote('code');
            $('#shortDescription').val(shortDescriptionHtml);
            var longDescriptionHtml = $('#longDescription').summernote('code');
            $('#longDescription').val(longDescriptionHtml);
            var termsConditionsHtml = $('#termsConditions').summernote('code');
            $('#termsConditions').val(termsConditionsHtml);

            if (validateForm()) {
                return true;
            } else {
                event.preventDefault();
                return false;
            }
        });


        $(document).ready(function() {

            $('#minAgeDiv').hide();
            $('#maxAgeDiv').hide();

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
                height: 150,
                inheritPlaceholder: true
            });

            $('#shortDescription').summernote({
                height: 100,
                inheritPlaceholder: true
            });

            $('#termsConditions').summernote({
                height: 150,
                inheritPlaceholder: true
            });


            $('#addTicketButton').click(function() {
                var ticketSection = $('.ticket-info-section').first().clone(true);

                var inputs = ticketSection.find('input');
                inputs.each(function() {
                    $(this).val('');
                });

                var deleteButton = $(
                    '<button type="button" class="btn btn-danger delete-button">Delete</button>');
                ticketSection.append(deleteButton);
                ticketSection.addClass('card shadow');
                $('#ticket-info-container').append(ticketSection);
            });

            $('#ticket-info-container').on('click', '.delete-button', function() {
                $(this).closest('.ticket-info-section').remove();
            });

        });

        function validateForm() {
            var isValid = true;

            var category = $('#category').val();
            var title = $('#title').val();
            var startDate = $('#startDate').val();
            var startTime = $('#startTime').val();
            var endDate = $('#endDate').val();
            var endTime = $('#endTime').val();
            var bookingDeadline = $('#booking_deadline').val();
            var description = $('#shortDescription').val();
            if (category === '-- Select --' || title === '' || startDate === '' ||
                startTime === '' || endDate === '' || endTime === '' ||
                $('#shortDescription').summernote('isEmpty')) {
                alert('Please fill out all required fields');
                isValid = false;
                return isValid;
            }

            if (endDate < startDate || (endDate === startDate && endTime <= startTime)) {
                alert('End date and time should be after start date and time.');
                isValid = false;
                return isValid;
            }

            if (bookingDeadline && (bookingDeadline >= startDate)) {
                alert('Booking deadline should be before the start date.');
                isValid = false;
                return isValid;
            }

            var city = $('#city').val();
            var address = $('#address').val();
            var longDescription = $('#longDescription').val();
            var termsConditions = $('#termsConditions').val();
            var ageRestrictions = $('#ageRestrictions').val();
            var minAge = $('#minAge').val();
            var maxAge = $('#maxAge').val();

            if (city === '-- Select --' || address === '' || $('#longDescription').summernote(
                    'isEmpty') ||
                $('#termsConditions').summernote('isEmpty') || ageRestrictions === '-- Select --') {
                alert('Please fill out all required fields.');
                isValid = false;
                return isValid;
            }

            if (ageRestrictions === 'Minimum Age') {
                if (minAge === '') {
                    alert('Please fill out the Minimum Age field.');
                    isValid = false;
                    return isValid;
                }

                if (parseFloat(minAge) < 0) {
                    alert('Minimum Age cannot be negative.');
                    isValid = false;
                    return isValid;
                }
            }

            if (ageRestrictions === 'Maximum Age') {
                if (maxAge === '') {
                    alert('Please fill out the Maximum Age field.');
                    isValid = false;
                    return isValid;
                }

                if (parseFloat(maxAge) < 0) {
                    alert('Maximum Age cannot be negative.');
                    isValid = false;
                    return isValid;
                }

            }

            var ticketSections = $('.ticket-info-section');
            ticketSections.each(function(index, section) {
                var ticketName = $(section).find('.form-group input[name="ticket_name[]"]').val();
                var ticketDescription = $(section).find(
                    '.form-group input[name="ticket_description[]"]').val();
                var ticketPrice = $(section).find('.form-group input[name="ticket_price[]"]').val();
                var ticketQuantity = $(section).find('.form-group input[name="ticket_quantity[]"]')
                    .val();

                if (ticketName === '' || ticketDescription === '' || ticketPrice === '' ||
                    ticketQuantity === '') {
                    isValid = false;
                    alert('Please fill out all required fields.');
                    return isValid;
                }

                // Validate that the price is not negative
                if (parseFloat(ticketPrice) < 0) {
                    isValid = false;
                    alert('Ticket price cannot be negative.');
                    return isValid;
                }

                if (parseFloat(ticketQuantity) < 0) {
                    isValid = false;
                    alert('Number of Tickets cannot be negative.');
                    return isValid;
                }
            });

            var group_ticketName = $('#group_ticket_name').val();
            var group_ticketDescription = $('#group_ticket_description').val();
            var group_ticketPrice = $('#group_ticket_price').val();
            var group_ticketQuantity = $('#group_ticket_quantity').val();
            var group_count = $('#group_count').val();

            if (group_ticketName !== '' || group_ticketDescription !== '' ||
                group_ticketPrice !== '' || group_ticketQuantity !== '' || group_count !==
                '') {
                // Validate if all fields are filled
                if (group_ticketName === '' || group_ticketDescription === '' ||
                    group_ticketPrice === '' || group_ticketQuantity === '' ||
                    group_count === '') {
                    alert('Please fill out all group ticket fields.');
                    isValid = false;
                    return isValid;
                }
                // Validate that price is not negative
                if (parseFloat(group_ticketPrice) < 0) {
                    alert('Group ticket price cannot be negative.');
                    isValid = false;
                    return isValid;
                }

                if (parseFloat(group_ticketQuantity) < 0) {
                    alert('Group ticket Number of Tickets cannot be negative.');
                    isValid = false;
                    return isValid;
                }

                if (parseFloat(group_count) < 0) {
                    alert('Group ticket Number of Persons in Group cannot be negative.');
                    isValid = false;
                    return isValid;
                }
            }

            var additionalInfo = $('#additionalInfo').val();
            if (additionalInfo === '') {
                alert('Please fill out all required fields.');
                isValid = false;
                return isValid;
            }

            var banner1 = $('#banner1').prop('files')[0];
            var banner2 = $('#banner2').prop('files')[0];
            if (!banner1 || !banner2) {
                alert('Please upload both banner images.');
                isValid = false;
                return isValid;
            }

            return isValid;
        }
    </script>
@endsection
