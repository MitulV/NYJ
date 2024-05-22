@extends('layouts.admin')
@section('content')
    <div class="card" style="background-color: #FBFBFB">
        <div class="card-header">
            Create Discount Rule
        </div>
        <div class="card-body">
            <form id="discountForm" action="{{ route('admin.automatic-discount.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <input type="text" name="description" class="form-control" id="description"
                            placeholder="Description">
                    </div>
                </div>
                <div class="form-row align-items-center">
                    <div class="form-group col-auto">
                        <input type="checkbox" name="remember" id="remember">
                    </div>
                    <div class="form-group col-auto">
                        <span>Set automatic discount availability start date to</span>
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
                        <span>Set automatic discount availability end date to</span>
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


                <span>If the booking conditions</span>
                <div class="form-row form-check align-items-center m-1">
                        <input class="form-check-input" type="radio" name="radio1">
                        <label class="form-check-label">Match all of</label>
                </div>
                <div class="form-row form-check align-items-center m-1">
                    <input class="form-check-input" type="radio" name="radio1">
                    <label class="form-check-label">Match any of</label>
                </div>

                <div class="form-row align-items-center">
                    <div class="form-group col-auto">
                        <input type="checkbox" name="remember" id="remember">
                    </div>
                    <div class="form-group col-auto">
                        <span>Spend value of</span>
                    </div>
                    <div class="form-group col-auto">
                        <input type="number" class="form-control" name="value" id="endDavaluete">
                    </div>
                    <div class="form-group col-auto">
                        <span>or more</span>
                    </div>
                </div>

                <div class="form-row align-items-center">
                    <div class="form-group col-auto">
                        <input type="checkbox" name="remember" id="remember">
                    </div>
                    <div class="form-group col-auto">
                        <span>Selection of</span>
                    </div>
                    <div class="form-group col-auto">
                        <input type="number" class="form-control" name="value" id="endDavaluete">
                    </div>
                    <div class="form-group col-auto">
                        <span>or more tickets</span>
                    </div>
                </div>

                <div class="form-row align-items-center">
                    <div class="form-group col-auto">
                        <input type="checkbox" name="remember" id="remember">
                    </div>
                    <div class="form-group col-auto">
                        <span>Selection of</span>
                    </div>
                    <div class="form-group col-auto">
                        <input type="number" class="form-control" name="value" id="endDavaluete">
                    </div>
                    <div class="form-group col-auto">
                        <span>or more events</span>
                    </div>
                </div>

                <div class="form-row align-items-center">
                    <div class="form-group col-auto">
                        <input type="checkbox" name="remember" id="remember">
                    </div>
                    <div class="form-group col-auto">
                        <span>Selection of</span>
                    </div>
                    <div class="form-group col-auto">
                        <input type="number" class="form-control" name="value" id="endDavaluete">
                    </div>
                    <div class="form-group col-auto">
                        <span>or more dates</span>
                    </div>
                </div>

                <span>Then take the following action</span>

                <div class="form-row align-items-center">
                    <div class="form-group col-auto">
                        <input type="radio" name="remember" id="remember">
                    </div>
                    <div class="form-group col-auto">
                        <span>Apply a discount of</span>
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
                        <input type="radio" name="remember" id="remember">
                    </div>
                    <div class="form-group col-auto">
                        <span>Apply a discount of</span>
                    </div>
                    <div class="form-group col-auto">
                        <input type="number" class="form-control" name="value" id="endDavaluete">
                    </div>
                    <div class="form-group col-auto">
                        <select id="currency" name="currency" class="form-control">
                            <option value="free_tickets" selected>free ticket(s)</option>
                            <option value="free_dates">free date(s)</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-success">Submit</button>
            </form>
        </div>
    </div>
@endsection
