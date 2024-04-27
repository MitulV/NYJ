<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Bootstrap demo</title>
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
    <link rel="stylesheet" href="{{asset('css/Stepper.css')}}" />
    <link rel="stylesheet" href="{{asset('css/booking.css')}}" />

  </head>
  <body>
    <nav class="navbar navbar-expand-lg sticky-top-navbar">
        <a href="{{ route('home') }}"><img src="{{ asset('img/NYJ_LOGO.png') }}" alt="Logo" height="100" /></a>
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
            <a class="nav-link" href="/Events.html">Explore Events</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/Pricing.html">Pricing</a>
          </li>
        </ul>
        <div class="d-flex">
          <a href="#" class="nav-link me-3">Greeting, Sign In</a>
          <a href="#" class="event-btn me-3">Create Event</a>
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
          <!-- Step 1: Account -->
          <div class="step" id="step1">
            <h3>Account</h3>
            <div class="mb-3">
              <label for="name">Name</label>
              <input type="text" class="form-control" id="name" />
            </div>
            <div class="mb-3">
              <label for="password">Password</label>
              <input type="password" class="form-control" id="password" />
            </div>
            <div class="mb-3">
              <label for="confirmPassword">Confirm Password</label>
              <input
                type="password"
                class="form-control"
                id="confirmPassword"
              />
            </div>
            <button class="btn event-btn" id="next" onclick="showStep(2)">
              Create
            </button>
            <p class="mt-3">Already have an account? <a href="#">Login</a></p>
          </div>

          <!-- Step 2: Select Ticket -->
          <div class="step" id="step2" style="display: none">
            <h3>Select ticket</h3>
            <div class="d-flex justify-content-between mb-3 input-group-text">
              <div>
                <label for="silverQuantity" class="fw-bold"> Silver</label> <span class="input-group-text text-danger"> $100</span>
              </div>
              <div class="input-group">
                <div class="d-flex align-items-center">
                  <button
                    class="btn btn-outline-secondary rounded-circle"
                    type="button"
                    onclick="decrementQuantity(this)"
                  >
                    -
                  </button>
                  <input
                    type="text"
                    class="form-control text-center"
                    value="0"
                    disabled
                  />
                  <button
                    class="btn btn-outline-secondary rounded-circle"
                    type="button"
                    onclick="incrementQuantity(this)"
                  >
                    +
                  </button>
                </div>
              </div>
            </div>
            <div class="d-flex justify-content-between mb-3 input-group-text">
              <div>
                <label for="silverQuantity" class="fw-bold">Gold</label> <span class="input-group-text text-danger">  $200</span>
              </div>
              <div class="input-group">
                <div class="d-flex align-items-center">
                  <button
                    class="btn btn-outline-secondary rounded-circle"
                    type="button"
                    onclick="decrementQuantity(this)"
                  >
                    -
                  </button>
                  <input
                    type="text"
                    class="form-control text-center"
                    value="0"
                    disabled
                  />
                  <button
                    class="btn btn-outline-secondary rounded-circle"
                    type="button"
                    onclick="incrementQuantity(this)"
                  >
                    +
                  </button>
                </div>
              </div>
            </div>

            <h3>Group ticket</h3>
            <div class="d-flex justify-content-between mb-3 input-group-text">
              <div>
                <label for="silverQuantity " class="fw-bold">Ticket for five</label> <span class="input-group-text text-danger d-flex justify-content-center"> $100</span>
              </div>
              <div class="input-group">
                <div class="d-flex align-items-center">
                  <button
                    class="btn btn-outline-secondary rounded-circle"
                    type="button"
                    onclick="decrementQuantity(this)"
                  >
                    -
                  </button>
                  <input
                    type="text"
                    class="form-control text-center"
                    value="0"
                    disabled
                  />
                  <button
                    class="btn btn-outline-secondary rounded-circle"
                    type="button"
                    onclick="incrementQuantity(this)"
                  >
                    +
                  </button>
                </div>
              </div>
            </div>

            <button class="btn event-btn">Book</button>
          </div>
        </div>
      </div>
    </div>
  </body>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.20.2/TweenMax.min.js"></script>

  <script src="{{asset('js/Stepper.js')}}"></script>

  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"
  ></script>
</html>
