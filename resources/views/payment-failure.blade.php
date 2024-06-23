<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ trans('panel.site_title') }} - Events</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/Events.css') }}" />
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,400i,700,900&display=swap" rel="stylesheet">
</head>
<style>
    body {
        text-align: center;
        background: #EBF0F5;
    }

    h1 {
        color: #88B04B;
        font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
        font-weight: 900;
        font-size: 40px;
        margin-bottom: 10px;
    }

    p {
        color: #404F5E;
        font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
        font-size: 20px;
        margin: 0;
    }

    i {
        color: #bc7766;
        font-size: 100px;
        line-height: 200px;
        margin-left: -15px;
    }

    .card {
        background: white;
        padding: 60px;
        border-radius: 4px;
        box-shadow: 0 2px 3px #C8D0D8;
        display: inline-block;
        margin: 0 auto;
    }
</style>

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
    <div class="card" style="margin-top: 30px">
        <div style="border-radius:200px; height:200px; width:200px; background: #F8FAF5; margin:0 auto;">
            <i class="checkmark">X</i>
        </div>
        <h1>Failure</h1>
        <p>Your Payment has been failed;<br />
    </div>
</body>

</html>
