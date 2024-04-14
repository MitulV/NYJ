<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Events</title>
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
    <link rel="stylesheet" href="{{ asset('css/Events.css') }}" />
  </head>
  <body>
    <nav class="navbar navbar-expand-lg px-4 sticky-top-navbar">
        <a href="{{ route('home') }}"
        ><img src="{{ asset('img/NYJ_LOGO.png') }}" alt="Logo" height="100"
      /></a>
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
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
          <a href="#" class="nav-link me-3">Greeting, Sign In</a>
          <a href="#" class="event-btn me-3">Create Event</a>
        </div>
      </div>
    </nav>

    <section class="events-section">
      <div class="container text-white">
        <h2 class="section-header mb-4">
          Discover Events For All The Things You Love
        </h2>
        <div class="row src-form">
          <div class="col">
            <input
              type="text"
              class="form-control form-control-lg"
              placeholder="Enter Location"
            />
          </div>
          <div class="col">
            <input
              type="text"
              class="form-control form-control-lg"
              placeholder="Search Event"
            />
          </div>

          <div class="col">
            <button class="event-btn">Find Events</button>
          </div>
        </div>
      </div>
    </section>

    <nav class="navbar navbar-expand-lg navbar-light second-nav mt-4">
      <div class="container">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-4">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">All</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Today</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Tomorrow</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">This Week</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">This Weekend</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Next Week</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Next Weekend</a>
          </li>
          <!-- Add more buttons as needed -->
        </ul>
      </div>
    </nav>

    <nav class="navbar navbar-expand-lg navbar-light second-nav">
      <div class="container">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link2 active" aria-current="page" href="#">All</a>
          </li>
          <li class="nav-item">
            <a class="nav-link2" href="#">Art</a>
          </li>
          <li class="nav-item">
            <a class="nav-link2" href="#">Buisness</a>
          </li>
          <li class="nav-item">
            <a class="nav-link2" href="#">Coaching and consulting</a>
          </li>
          <li class="nav-item">
            <a class="nav-link2" href="#">Free</a>
          </li>
          <li class="nav-item">
            <a class="nav-link2" href="#">Others</a>
          </li>

          <!-- Add more buttons as needed -->
        </ul>
      </div>
    </nav>

    <div class="container mt-4">
      <div class="row">
        <div class="col-md-4 cont-cent">
          <a href="/Album.html">
          <div class="card">
            <img
              src="https://www.eventbookings.com/upload/orgs/33a6ad50c21d4b49492077607be029e2/events/a9bbc342-5582-4f3b-be11-ad63f908e03a.jpeg?q=100&fit=crop-center&crop=3854%2C1764%2C177%2C533&s=e30634f008443c59474c07c9b0e15d81"
              class="card-img-top"
              alt="..."
            />
            <div class="card-body">
              <div class="row">
                <h5 class="card-title" style="font-weight: 700">
                  School holiday special
                </h5>
              </div>

              <div class="row">
                <div class="col">
                  <p class="card-text" style="font-weight: 700">AUD $174.0</p>

                  <p class="card-text">Multiple session</p>
                </div>
                <div class="col"><p class="card-text">6 Remaining</p></div>
              </div>
            </div>
          </div>
        </a>
        </div>

        <!-- Add more cards here -->
      </div>
    </div>

    <div class="down-arrow">
      <svg
        xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 24 24"
        fill="currentColor"
      >
        <path
          d="M12 17.27L5.61 10.89a.996.996 0 0 1 0-1.41L6.7 8.11a.996.996 0 0 1 1.41 0L12 12.36l3.89-3.89a.996.996 0 0 1 1.41 0l1.09 1.09a.996.996 0 0 1 0 1.41L12 17.27z"
        />
      </svg>
    </div>

    <footer class="footer">
      <div class="container">
        <div class="row gap">
          <div class="col-md-2 col-sm-6">
            <img
              src="https://www.eventbookings.com/wp-content/uploads/2020/10/footer-logo.png"
              alt="Company Logo"
            />
          </div>
          <div class="col-md-2 col-sm-6">
            <h5>Product</h5>
            <ul>
              <li>Features</li>
              <li>Sell Event Tickets</li>
              <li>Event Registration</li>
              <li>Enterprise</li>
              <li>Explore Events</li>
            </ul>
          </div>
          <div class="col-md-2 col-sm-6">
            <h5>Pricing</h5>
            <ul>
              <li>NYJ Events</li>
              <li>About Us</li>
              <li>Blog</li>
              <li>Sign Up</li>
              <li>Sign In</li>
            </ul>
          </div>
          <div class="col-md-2 col-sm-6">
            <h5>Affiliate</h5>
            <ul>
              <li>Help & Support</li>
              <li>Help Center</li>
              <li>Contact Us</li>
              <li>Developers</li>
              <li>Compare</li>
            </ul>
          </div>
          <div class="col-md-2 col-sm-6">
            <h5>Compare</h5>
            <ul>
              <li>vs Eventbrite</li>
              <li>vs ShowClix</li>
              <li>vs Ticketleap</li>
              <li>vs Ticketspice</li>
            </ul>
          </div>
        </div>
        <div class="row mt-4 d-flex justify-content-between">
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
        </div>
      </div>
    </footer>
  </body>


  <script src='https://cdnjs.cloudflare.com/ajax/libs/gsap/1.20.2/TweenMax.min.js'></script>
  <script src="{{asset('js/script.js')}}"></script>

  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"
  ></script>
</html>
