<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ trans('panel.site_title') }} - Register User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/Stepper.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/booking.css') }}" />

</head>

<body>
    <nav class="navbar navbar-expand-lg  sticky-top-navbar">
        <a href="{{ route('home') }}"><img src="{{ asset('img/NYJ_LOGO.png') }}" alt="Logo" height="100" /></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">


                <li class="nav-item">
                    <a class="nav-link" href="{{ route('events') }}">Explore Events</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('pricing') }}">Pricing</a>
                </li>

            </ul>
            <div class="d-flex">
                @if (auth()->check())
                    <a href="{{ route('login') }}" class="nav-link me-3">{{ auth()->user()->name }}</a>
                @endif

                <a href="{{ route('register') }}" class="event-btn me-3">Create Event</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="progress-container">
                    <div class="progress" id="progress"></div>
                    <div class="circle active">1</div>
                    <div class="circle">2</div>
                </div>
                <form id="ticketForm" action="{{ route('admin.events.handleBooking') }}" method="POST">
                    @csrf
                    <input type="hidden" class="form-control" id="event_id" name="event_id"
                        value="{{ $event->id }}" />


                    <!-- Step 1: Select Ticket -->
                    <div class="step" id="step2">
                        <div class="payment_mode mb-5">
                            <h3>Payment Mode</h3>
                            <select id="payment_mode" style="margin: 0 0.5vw;" name="payment_mode" class="form-control">
                                <option value="cash" selected>Cash</option>
                                <option value="Card">Card</option>
                            </select>
                        </div>
                        <div class="mb-5">
                            <h3>Discount Code</h3>
                            <input style="width:100%" type="text" name="code" class="form-control" id="code"
                                placeholder="Discount Code (optional)">
                        </div>

                        <h3>Select ticket</h3>
                        @foreach ($normalTickets as $ticket)
                            <div class="d-flex justify-content-between mb-3 input-group-text">
                                <div>
                                    <label for="ticket_id_{{ $ticket->id }}" class="fw-bold">
                                        {{ $ticket->name }}
                                    </label>
                                    <span class="input-group-text text-danger">
                                        £{{ $ticket->price }}
                                    </span>
                                </div>
                                @if ($ticket->quantity == $ticket->total_booked_tickets)
                                    <h5>All Tickets Booked</h5>
                                @else
                                    <div class="input-group">
                                        <div class="d-flex align-items-center">
                                            <button class="btn btn-outline-secondary rounded-circle" type="button"
                                                onclick="decrementQuantity(this)">
                                                -
                                            </button>
                                            <input type="text" class="form-control text-center ticket-quantity"
                                                value="0" name="ticket_id_{{ $ticket->id }}" readonly />
                                            <button class="btn btn-outline-secondary rounded-circle" type="button"
                                                onclick="incrementQuantity(this, {{ $ticket->quantity }}, {{ $ticket->total_booked_tickets }})">
                                                +
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach

                        @if ($groupTickets)
                            <h3>Group ticket</h3>
                        @endif

                        @foreach ($groupTickets as $ticket)
                            <div class="d-flex justify-content-between mb-3 input-group-text">
                                <div>
                                    <label for="ticket_id_{{ $ticket->id }}" class="fw-bold">Ticket for
                                        {{ $ticket->group_count }} Persons</label> <span
                                        class="input-group-text text-danger d-flex justify-content-center">
                                        £{{ $ticket->price }}</span>
                                </div>
                                <div class="input-group">
                                    <div class="d-flex align-items-center">
                                        <button class="btn btn-outline-secondary rounded-circle" type="button"
                                            onclick="decrementQuantity(this)">
                                            -
                                        </button>
                                        <input type="text" class="form-control text-center ticket-quantity"
                                            value="0" name="ticket_id_{{ $ticket->id }}" readonly />
                                        <button class="btn btn-outline-secondary rounded-circle" type="button"
                                            onclick="incrementQuantity(this, {{ $ticket->quantity }}, {{ $ticket->total_booked_tickets }})">
                                            +
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        @if (auth()->check() && auth()->user()->isOrganizer())
                            <button type="button" class="btn event-btn" id="next"
                                onclick="validateAndSubmit('{{ $event->booking_deadline }}')">Continue</button>
                        @endif

                    </div>
                    <div style="margin-top: 50px"></div>

                    <!-- Step 2: Account -->
                    <div class="step" id="step1" style="display: none">
                        <h3>Account</h3>
                        <div class="mb-3">
                            <label for="name">Name*</label>
                            <input type="text" class="form-control" id="name" name="name" required />
                        </div>
                        <div class="mb-3">
                            <label for="email">Email*</label>
                            <input type="email" class="form-control" id="email" name="email" required />
                        </div>

                        <div class="mb-3">
                            <label for="mobile">Mobile*</label>
                            <input type="text" class="form-control" id="mobile" name="mobile" required />
                        </div>

                        <button type="button" id="bookBtn" class="btn event-btn" onclick="showStep()">
                            Book
                        </button>

                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.20.2/TweenMax.min.js"></script>

<script src="{{ asset('js/Stepper.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>

</html>
