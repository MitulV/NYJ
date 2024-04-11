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
                                    <select id="category"  name="category" class="form-control">
                                        <option selected>-- Select --</option>
                                        @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="title">Title</label>
                                    <input type="text" name="title" class="form-control" id="title" placeholder="Enter Title">
                                </div>

                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="startDate">Start Date</label>
                                    <input type="date" class="form-control" name="startDate" id="startDate">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="startTime">Start Time</label>
                                    <input type="time" class="form-control" name="startTime" id="startTime">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="endDate">End Date</label>
                                    <input type="date" class="form-control" name="endDate"  id="endDate">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="endTime">End Time</label>
                                    <input type="time" class="form-control" name="endTime" id="endTime">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="description">Short Description (max 100 characters)</label>
                                    <textarea class="form-control" name="shortDescription" id="description" rows="2" maxlength="100" style="resize: none;"
                                        placeholder="Enter Short Description"></textarea>
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary" id="nextButton1">Next</button>
                        </div>
                        <div id="location-details" class="content" role="tabpanel" aria-labelledby="location-details-trigger">
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
                                <textarea class="form-control" name="long_description" id="longDescription" rows="5" placeholder="Enter Long Description"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="termsConditions">Terms & Conditions</label>
                                <textarea class="form-control" name="terms_conditions" id="termsConditions" rows="3" placeholder="Enter Terms & Conditions"></textarea>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="ageRestrictions">Age Restrictions</label>
                                    <select id="ageRestrictions" name="age_restrictions" class="form-control">
                                        <option selected>-- Select --</option>
                                        <option>None</option>
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
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="ticketName">Ticket Name (formerly Ticket Type)</label>
                                    <input type="text" name="ticket_name" class="form-control" id="ticketName" placeholder="Enter Ticket Name">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="ticketDescription">Ticket Description</label>
                                    <input type="text" name="ticket_description" class="form-control" id="ticketDescription" placeholder="Enter Ticket Description">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="ticketPrice">Ticket Price</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">$</span>
                                        </div>
                                        <input type="number" name="ticket_price" class="form-control" id="ticketPrice" placeholder="Enter Ticket Price">
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="ticketQuantity">Number of Tickets</label>
                                    <input type="number" name="ticket_quantity" class="form-control" id="ticketQuantity" placeholder="Enter Number of Tickets">
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary" onclick="stepper.previous()">Previous</button>
                            <button type="button" class="btn btn-primary" id="nextButton3">Next</button>
                        </div>
                        
                        <div id="additional-info" class="content" role="tabpanel"
                            aria-labelledby="additional-info-trigger">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="status">Status</label>
                                    <select id="status" name="status" class="form-control">
                                        <option selected>Choose...</option>
                                        <option selected>Active</option>
                                        <option>Inactive</option>
                                        <option>Cancelled</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="additionalInfo">Additional Info</label>
                                    <textarea class="form-control" name="additionalInfo" id="additionalInfo" rows="3"
                                        placeholder="Enter Additional Info (e.g., special instructions, event rules)"></textarea>
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
                var description = $('#description').val();

                if (category === '-- Select --' || title.trim() === '' || startDate.trim() === '' ||
                    startTime.trim() === '' || endDate.trim() === '' || endTime.trim() === '' || description
                    .trim() === '') {
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

                if (city === '-- Select --' || address.trim() === '' || longDescription.trim() === '' ||
                    termsConditions.trim() === '' || ageRestrictions === '-- Select --') {
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
            var ticketName = $('#ticketName').val();
            var ticketDescription = $('#ticketDescription').val();
            var ticketPrice = $('#ticketPrice').val();
            var ticketQuantity = $('#ticketQuantity').val();

            if (ticketName.trim() === '' || ticketDescription.trim() === '' || ticketPrice.trim() === '' || ticketQuantity.trim() === '') {
                alert('Please fill out all required fields.');
                return;
            }

            // Proceed to the next step if all fields are filled
            stepper.next(); // Assuming you have a stepper object
            });

            $('#eventForm').submit(function(event) {
            var status = $('#status').val();
            var additionalInfo = $('#additionalInfo').val();

            if (status === 'Choose...' || additionalInfo.trim() === '') {
                alert('Please fill out all required fields.');
                event.preventDefault(); // Prevent default form submission if validation fails
            }
        });

        });
    </script>
@endsection
