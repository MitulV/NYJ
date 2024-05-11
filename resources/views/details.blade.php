<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ trans('panel.site_title') }} - Event Detail</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/details.css') }}" />

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
                    <a class="nav-link" href="/index.html#feature">Features</a>
                </li>

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

        <!-- Date Section -->
        <div class="date-section">
            <div class="row align-items-center mb-3 first-section">
                <!-- Date Info -->

                <div class="col-md-1 date-info">
                    <div class="day">{{ Carbon\Carbon::parse($event->start_date)->format('l') }}</div>
                    <div class="date">{{ Carbon\Carbon::parse($event->start_date)->format('d') }}</div>
                    <div class="month">{{ Carbon\Carbon::parse($event->start_date)->format('M') }}</div>
                </div>
                <!-- Event Title -->
                <div class="col-md-11">
                    <div class="row">
                        <h2 class="event-title">{{ $event->title }}</h2>
                    </div>
                    <div class="row">
                        <!-- Location Column -->
                        <div class="col-md-5 location-column">
                            <h4 class="info-title">Location</h4>
                            <p>{{ $event->address }}</p>
                        </div>
                        <!-- Date Column -->
                        <div class="col-md-2 date-column">
                            <h4 class="info-title">Date</h4>
                            <p>{{ Carbon\Carbon::parse($event->start_date)->format('l, M d') }}</p>
                        </div>
                        
                        <!-- Time Column -->
<div class="col-md-3 time-column">
    <h4 class="info-title">Time</h4>
    <?php
    // Convert UTC time to UK timezone
    $utc_time = new DateTime($event->start_time, new DateTimeZone('UTC'));
    $uk_timezone = new DateTimeZone('Europe/London');
    $utc_time->setTimezone($uk_timezone);
    
    // Format the time to show only hours and minutes
    $formatted_time = $utc_time->format('H:i A');
    ?>
    <p>{{ $formatted_time }}</p>
</div>

                        <!-- Buttons Section Column -->

                    </div>
                </div>
            </div>
            <div class="event-banner-wrap ">
                <div class="banner-thumb full-width full-height border-0">
                    <a href="#">
                        <img src="{{ $event->image1 }}" class="img-cover av-event-image" alt="banner"> </a>
                </div>
            </div>
            <div class="details-section mt-6">



                <div class="event-details mt-4">
                    <h2>About This Event</h2>
                    <p>{{ $event->short_description }}</p>
                    <p>{{ $event->long_description }}</p>
                </div>

                {{-- <div class="location-details">
                    <h3>New Location</h3>
                    <address>
                        2Step Dance<br> <span> 3/10 Tollis Place, Seven Hills</span>

                    </address>
                </div> --}}

                {{-- <div class="styles-details">
                    <p>Styles will include:</p>
                    <ul>
                        <li>Jazz</li>
                        <li>Lyrical</li>
                        <li>Technique</li>
                        <li>Commercial</li>
                    </ul>
                </div> --}}


            </div>

            <div class="terms-section">

                <h1 class="mt-5 mb-4">Terms and Conditions</h1>
                <div class="terms-header">{{$event->terms_and_conditions}}</div>
                {{-- <div class="terms-header">General Terms</div>
                <ul class="terms-list">
                    <li>These terms and conditions outline the rules and regulations for the use of our website.</li>
                    <li>By accessing this website, we assume you accept these terms and conditions in full.</li>
                    <li>Do not continue to use our website if you do not accept all of the terms and conditions stated
                        on this page.</li>
                </ul>
                <div class="terms-header">User Account</div>
                <ul class="terms-list">
                    <li>To access certain features of the website, you may be required to create an account.</li>
                    <li>You must provide accurate and complete information when creating an account.</li>
                    <li>You are responsible for maintaining the confidentiality of your account and password.</li>
                </ul> --}}
                <!-- Add more sections as needed -->

            </div>

        </div>


    </div>

    <footer class="footer">
        <div class="container">
            <div class="row gap">
                <div class="col-md-2 col-sm-6">
                    <img src="{{ asset('img/NYJ_LOGO.png') }}" alt="Company Logo"  height="200" />
                </div>
                <div class="col-md-2 col-sm-6">
                    <h5>Product</h5>
                    <ul>
                        <a href="{{ route('register') }}" style="text-decoration: none">
                        <li >Sell Event Tickets</li>
                        </a>
                        <a href="{{ route('register') }}" style="text-decoration: none">
                        <li>Event Registration</li>
                        </a>
                    </ul>
                </div>
                <div class="col-md-2 col-sm-6">
                    <h5>Pricing</h5>
                    <ul>
                        <a href="{{ route('pricing') }}" style="text-decoration: none">
                        <li>Ticket Pricing</li>
                        </a>
                    </ul>
                </div>
            </div>
            {{-- <div class="row mt-4 d-flex justify-content-between">
                <div class="col">
                    <ul class="gap-2">
                        <li><a href="#">T&C for Attendees</a></li>
                        <li><a href="#">T&C for Organizers</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                    </ul>
                </div>
                <div class="col">
                    <ul class="list-inline">
                        <li class="list-inline-item">
                            <a href="#"><i class="ri-facebook-circle-line"></i></a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#"><i class="ri-twitter-x-line"></i></a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#"><i class="ri-instagram-line"></i></a>
                        </li>
                        <!-- Add other social media icons as needed -->
                    </ul>
                </div>
            </div> --}}
        </div>
    </footer>

    <nav class="navbar navbar-expand-lg sticky-bottom-navbar d-flex py-4 px-5 align-items-end justify-content-between">
        <div class="d-flex align-items-center justify-content-center">

            @if ($event->tickets()->exists())
                <h2>GBP
                    {{ $event->tickets()->first()->price }}
                </h2>
            @else
                <h2>No tickets available</h2>
            @endif
        </div>

        @if (auth()->guest() || (!auth()->user()->isOrganizer() && !auth()->user()->isAdmin()))
            <a href="{{ route('registerUser.index', ['event_id' => $event->id]) }}" class="event-btn">Purchase
                Ticket</a>
        @endif


    </nav>

    <!-- Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
