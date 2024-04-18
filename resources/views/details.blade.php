<form method="POST" action="{{ route('bookEvent') }}">
    @csrf
    <!-- Add input fields for user details -->
    Name: <input type="text" name="name"> 
    Email:<input type="email" name="email">

    Password:<input type="password" name="password">

    <!-- Add hidden input fields for other parameters -->
    <input type="hidden" name="event_id" value="{{ $event->id }}"> <!-- Assuming $event is the event object -->
    <input type="hidden" name="number_of_tickets" value="1"> <!-- Set the default number of tickets -->
    <input type="hidden" name="amount" value="100">
    <input type="hidden" name="booking_date_time" value="{{ now()->toDateTimeString() }}"> <!-- Set booking date time to current time -->

    <!-- You can add more fields here for additional details if needed -->

    <button type="submit">Book Event</button>
</form>
