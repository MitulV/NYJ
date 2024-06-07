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
            Create Discount Code
        </div>
        <div class="card-body" x-data="data()">
            <form @submit.prevent="submitForm" id="discountForm" action="{{ route('admin.discount.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <input type="text" name="code" class="form-control" id="code" placeholder="Discount Code"
                            x-model="formData.code">
                    </div>
                </div>


                <div class="form-row">
                    <div class="container">
                        <div class="scrollable-list">
                            <ul style="list-style: none">
                                <li>
                                    <label class="m-1">
                                        <input type="checkbox" @click="toggleAll()" :checked="allEventsSelected()">
                                        All events
                                    </label>
                                </li>
                                <ul style="list-style: none">
                                    <template x-for="event in events" :key="event.id">
                                        <li>
                                            <input type="checkbox" :id="'event-' + event.id" @click="toggleEvent(event.id)"
                                                :checked="eventSelected(event.id)">
                                            <label class="m-1" :for="'event-' + event.id" x-text="event.title"></label>
                                            <ul style="list-style: none">
                                                <template x-for="ticket in event.tickets" :key="ticket.id">
                                                    <li>
                                                        <label class="m-1">
                                                            <input type="checkbox" class="subOption"
                                                                :id="'ticket-' + ticket.id" @click="toggleTicket(ticket.id)"
                                                                :checked="ticketSelected(ticket.id)">
                                                            <span x-text="ticket.name"></span>
                                                        </label>
                                                    </li>
                                                </template>
                                            </ul>
                                        </li>
                                    </template>
                                </ul>
                            </ul>
                        </div>
                        {{-- <div x-show="errors.tickets" class="text-danger" x-text="errors.tickets"></div> --}}

                        <h6 class="m-1">Price categories selected: <span
                                x-text="selectedTickets.length > 0 ? selectedTickets.length : 'none'"></span></h6>
                    </div>
                </div>

                <div class="form-row align-items-center mt-5">

                    <div class="form-group col-auto">
                        <span>Discount amount</span>
                    </div>
                    <div class="form-group col-auto">
                        <select id="discount_amount_type" name="discount_amount_type" class="form-control"
                            x-model="formData.discount_amount_type">
                            <option value="fixed">£</option>
                            <option value="percentage">%</option>
                        </select>
                    </div>
                    <div class="form-group col-auto">
                        <input type="number" class="form-control" name="discount_amount" id="discount_amount"
                            x-model="formData.discount_amount">
                    </div>
                    <div class="form-group col-auto">
                        <select id="discount_amount_per_ticket_or_booking" name="discount_amount_per_ticket_or_booking"
                            class="form-control" x-model="formData.discount_amount_per_ticket_or_booking">
                            <option value="per_ticket">Per Ticket</option>
                            <option value="per_booking">Per Booking</option>
                        </select>
                    </div>
                </div>


                <div class="form-row align-items-center">
                    <div class="form-group col-auto">
                        <input type="checkbox" name="chk_valid_from" id="chk_valid_from" x-model="formData.chk_valid_from">
                    </div>
                    <div class="form-group col-auto">
                        <span>Set discount code valid from</span>
                    </div>
                    <div class="form-group col-auto">
                        <input type="date" class="form-control" name="valid_from_date" id="valid_from_date"
                            min="{{ date('Y-m-d') }}" x-model="formData.valid_from_date"
                            x-bind:disabled="!formData.chk_valid_from">
                    </div>
                    <div class="form-group col-auto">
                        <span>at</span>
                    </div>
                    <div class="form-group col-auto">
                        <input type="time" class="form-control" name="valid_from_time" id="valid_from_time"
                            x-model="formData.valid_from_time" x-bind:disabled="!formData.chk_valid_from">
                    </div>
                </div>

                <div class="form-row align-items-center">
                    <div class="form-group col-auto">
                        <input type="checkbox" name="chk_valid_to" id="chk_valid_to" x-model="formData.chk_valid_to">
                    </div>
                    <div class="form-group col-auto">
                        <span>Set discount code expiry to</span>
                    </div>
                    <div class="form-group col-auto">
                        <input type="date" class="form-control" name="valid_to_date" id="valid_to_date"
                            min="{{ date('Y-m-d') }}" x-model="formData.valid_to_date"
                            x-bind:disabled="!formData.chk_valid_to">
                    </div>
                    <div class="form-group col-auto">
                        <span>at</span>
                    </div>
                    <div class="form-group col-auto">
                        <input type="time" class="form-control" name="valid_to_time" id="valid_to_time"
                            x-model="formData.valid_to_time" x-bind:disabled="!formData.chk_valid_to">
                    </div>
                </div>


                <div class="form-row align-items-center">
                    <div class="form-group col-auto">
                        <input type="radio" name="quantity_radio" id="quantity_radio1" value="unlimited"
                            x-model="formData.quantity_radio">
                    </div>
                    <div class="form-group col-auto">
                        <span>Discount code can be used unlimited number of times</span>
                    </div>
                </div>

                <div class="form-row align-items-center">
                    <div class="form-group col-auto">
                        <input type="radio" name="quantity_radio" id="quantity_radio2" value="limited"
                            x-model="formData.quantity_radio">
                    </div>
                    <div class="form-group col-auto">
                        <span>Discount code can be used</span>
                    </div>
                    <div class="form-group col-auto">
                        <input type="number" class="form-control" name="quantity" id="quantity"
                            x-model="formData.quantity" x-bind:disabled="formData.quantity_radio !== 'limited'">
                    </div>
                    <div class="form-group col-auto">
                        <span>times in total</span>
                    </div>
                </div>


                <div class="form-row align-items-center">
                    <div class="form-group col-auto">
                        <input type="radio" name="available_for" id="available_for_all" value="all"
                            x-model="formData.available_for">
                    </div>
                    <div class="form-group col-auto">
                        <label for="available_for_all">Discount code available on all bookings</label>
                    </div>
                </div>
                <div class="form-row align-items-center">
                    <div class="form-group col-auto">
                        <input type="radio" name="available_for" id="available_for_in_house" value="in_house"
                            x-model="formData.available_for">
                    </div>
                    <div class="form-group col-auto">
                        <label for="available_for_in_house">Discount code available on in-house bookings only</label>
                    </div>
                </div>
                <button type="button" @click="submitFormAjax" :disabled="submitting" class="btn btn-success">Submit</button>
            </form>
        </div>
    </div>
    <script>
        function data() {
            return {
                events: @json($events),
                selectedEvents: [],
                selectedTickets: [],
                submitted: false,
                submitting: false,
                formData: {
                    code: '',
                    discount_amount: null,
                    discount_amount_type: 'fixed',
                    discount_amount_per_ticket_or_booking: 'per_ticket',
                    chk_valid_from: false,
                    valid_from_date: '',
                    valid_from_time: '',
                    chk_valid_to: false,
                    valid_to_date: '',
                    valid_to_time: '',
                    quantity_radio: '',
                    quantity: null,
                    available_for: ''
                },
                errors: {},
                validateForm() {
                    this.errors = {};
                    if (!this.formData.code ||
                        this.formData.discount_amount === null ||
                        this.selectedTickets.length === 0 ||
                        !this.formData.quantity_radio ||
                        (this.formData.quantity_radio === 'limited' && (!this.formData.quantity)) ||
                        !this.formData.available_for) {
                        this.errors.general = 'Please provide all of the required details before proceeding.';
                    }

                    if(this.formData.discount_amount <= 0 || (this.formData.quantity <= 0 && this.formData.quantity_radio === 'limited')){
                        this.errors.general1 = 'Please Enter Positive Values only'
                    }
                    
                },
                submitFormAjax() {
                    this.submitting = true;
                    this.validateForm();
                    if (Object.keys(this.errors).length === 0) {
                        let formData = new FormData();
                        for (let key in this.formData) {
                            formData.append(key, this.formData[key]);
                        }

                        let selectedEventsWithTickets = this.events
                            .filter(event =>
                                event.tickets.some(ticket => this.selectedTickets.includes(ticket.id))
                            )
                            .map(event => ({
                                id: event.id,
                                selectedTickets: event.tickets
                                    .filter(ticket => this.selectedTickets.includes(ticket.id))
                                    .map(ticket => ticket.id)
                            }));

                        formData.append('selectedEvents', JSON.stringify(selectedEventsWithTickets));

                        fetch('{{ route('admin.discount.store') }}', {
                                method: 'POST',
                                body: formData,
                                headers: {
                                    'X-CSRF-Token': '{{ csrf_token() }}',
                                    'Accept': 'application/json',
                                },
                            })
                            .then(response => {
                                if (!response.ok) {
                                    return response.json().then(errorData => {
                                        if (response.status === 422 && errorData.message) {
                                            throw new Error(errorData.message);
                                        } else {
                                            throw new Error('Network response was not ok');
                                        }
                                    });
                                }
                            })
                            .then(data => {
                                window.location.href = '{{ route('admin.discount.index') }}';
                            })
                            .catch(error => {
                                console.error('There was a problem with the fetch operation:', error);
                                alert(error.message);
                            });
                            
                    } else {
                        if(this.errors.general){
                            alert('Provide all of the required details before proceeding');
                        }else if(this.errors.general1){
                            alert('Please enter Positive values only');
                        }
                       
                    }
                    this.submitting = false;
                },

                toggleAll() {
                    let allChecked = this.allEventsSelected();
                    this.selectedTickets = allChecked ? [] : this.events.flatMap(event => event.tickets.map(ticket => ticket
                        .id));
                },
                toggleEvent(eventId) {
                    let event = this.events.find(event => event.id === eventId);
                    let allChecked = event.tickets.every(ticket => this.selectedTickets.includes(ticket.id));
                    event.tickets.forEach(ticket => {
                        if (allChecked) {
                            this.selectedTickets = this.selectedTickets.filter(id => id !== ticket.id);
                        } else {
                            if (!this.selectedTickets.includes(ticket.id)) {
                                this.selectedTickets.push(ticket.id);
                            }
                        }
                    });
                },
                toggleTicket(ticketId) {
                    if (this.selectedTickets.includes(ticketId)) {
                        this.selectedTickets = this.selectedTickets.filter(id => id !== ticketId);
                    } else {
                        this.selectedTickets.push(ticketId);
                    }
                },
                allEventsSelected() {
                    return this.selectedTickets.length === this.events.reduce((acc, event) => acc + event.tickets.length,
                        0);
                },
                eventSelected(eventId) {
                    let event = this.events.find(event => event.id === eventId);
                    return event.tickets.every(ticket => this.selectedTickets.includes(ticket.id));
                },
                ticketSelected(ticketId) {
                    return this.selectedTickets.includes(ticketId);
                },
            }
        }
    </script>
@endsection
