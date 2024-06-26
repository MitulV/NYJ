<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ trans('panel.site_title') }} - Pricing</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="{{ asset('css/Pricing.css') }}" />
  </head>
  <body>
    <nav class="navbar navbar-expand-lg  sticky-top-navbar">
      <a href="{{route('home')}}"><img src="{{ asset('img/NYJ_LOGO.png') }}" alt="Logo" height="100" /></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              {{-- <li class="nav-item">
                  <a class="nav-link" href="/index.html#feature">Features</a>
              </li> --}}

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
    

    <section class="hero-section">
        <div class="container">
          <div class="row">
            <div class="col-md-6">
              <div class="hero-content">
                <h1>The most affordable prices anywhere</h1>
                <p>
                  <span>No set-up costs. No monthly payments. No cost for free events.</span>
                  <span>Low-cost and transparent fees. We only charge when you sell tickets.</span>
                </p>
                <a href="#" class="event-btn">Create Event</a>
              </div>
            </div>
            <div class="col-md-6 flex-center">
              <div class="card">
                <div class="card-body">
                  <h1>1£</h1>
                  {{-- <h3>+</h3>
                  <h2>2%</h2> --}}
                  <h4 style="margin-top: 20px">Per ticket sold</h4>
                  <p>Includes credit card processing fees</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="faq-section">
        <div class="container">
          <h2 class="section-header">Frequently Asked Questions</h2>
          <div class="faq-item">
            <button type="button" class="collapsible">How do I receive payment from my attendees? <span class="toggle-icon"></span></button>
            <div class="content">
              <p>Payment processing is a crucial aspect of event management, and at NYJ Events, we provide you with different payment gateway options to suit your needs. If you're in a country where we offer our own payment system, we'll transfer the revenue from ticket sales to your designated bank account, minus any service charge. Typically, we process the payment after your event is over, but if you require a customised payment schedule, we're happy to help you out. Please contact us to know the available options.</p>
            </div>
          </div>
          <div class="faq-item">
            <button type="button" class="collapsible">Is NYJ Events really free? <span class="toggle-icon"></span></button>
            <div class="content">
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam. Sed nisi.</p>
            </div>
          </div>
          <div class="faq-item">
            <button type="button" class="collapsible">Does NYJ Events charge for free events? <span class="toggle-icon"></span></button>
            <div class="content">
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam. Sed nisi.</p>
            </div>
          </div>
          <div class="faq-item">
            <button type="button" class="collapsible">Is there any upfront or monthly costs? <span class="toggle-icon"></span></button>
            <div class="content">
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam. Sed nisi.</p>
            </div>
          </div>
        </div>
      </section>

      
      
      

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
                <div class="col-md-2 col-sm-6">
                  <h5>Privacy</h5>
                  <ul>
                      <a href="{{ route('privacy') }}" style="text-decoration: none">
                      <li>Privacy Policy</li>
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



      <script src="https://cdn-script.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
      <script src='https://cdnjs.cloudflare.com/ajax/libs/gsap/1.20.2/TweenMax.min.js'></script>

      <script src="{{asset('js/script.js')}}"></script>
    <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"
  ></script>
</body>
</html>
