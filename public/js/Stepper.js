const mobileInput = document.getElementById("mobile");

mobileInput.addEventListener("input", function (event) {
    const sanitizedValue = event.target.value.replace(/\D/g, "");
    event.target.value = sanitizedValue;
});

const progress = document.querySelector("#progress");
const prev = document.querySelector("#prev");
const next = document.querySelector("#next");
const circles = document.querySelectorAll(".circle");

let currentActive = 1;

prev.addEventListener("click", () => {
    currentActive--;

    if (currentActive < 1) {
        currentActive = 1;
    }

    update();
});

function update() {
    circles.forEach((circle, idx) => {
        if (idx < currentActive) {
            circle.classList.add("active");
        } else {
            circle.classList.remove("active");
        }
    });

    const actives = document.querySelectorAll(".active");

    progress.style.width =
        ((actives.length - 1) / (circles.length - 1)) * 100 + "%";

    if (currentActive === 1) {
        prev.disabled = true;
    } else if (currentActive === circles.length) {
        next.disabled = true;
    } else {
        prev.disabled = false;
        next.disabled = false;
    }
}

function validateUserForm() {
    var name = document.getElementById("name").value;
    var email = document.getElementById("email").value;
    var mobile = document.getElementById("mobile").value;

    if (name.trim() === "") {
        alert("Please enter valid Name");
        return false;
    }

    if (email.trim() === "" || !/\S+@\S+\.\S+/.test(email)) {
        alert("Please enter valid Email");
        return false;
    }

    if (mobile.trim() === "" || !/^\d{8,12}$/.test(mobile.trim())) {
        alert("Please enter a valid mobile number");
        return false;
    }
    return true;
}

function showStep() {
    var bookButton = document.getElementById("bookBtn");
    bookButton.disabled = true;
    if (!validateUserForm()) {
        bookButton.disabled =false;
        return false;
    }

    var email = document.getElementById("email").value;
    validateEmail(email)
        .then(function (isValidEmail) {
            if (isValidEmail) {
                document.getElementById("ticketForm").submit();
                return true;
            } else {
                alert(
                    "You cannot book the tickets as you are an organizer or admin."
                );
                bookButton.disabled =false;
                return false;
            }
        })
        .catch(function (error) {
            bookButton.disabled =false;
            return false;
        });

}

function incrementQuantity(button, quantity, totalBookedTickets) {
    var input = button.parentElement.querySelector('input[type="text"]');
    var value = parseInt(input.value);
    var remainingTickets = quantity - totalBookedTickets;
    if (value < remainingTickets) {
        input.value = value + 1;
    } else if (value === remainingTickets) {
        if (remainingTickets === 0) {
            alert("Booking is full for this ticket");
        } else {
            alert(remainingTickets + " tickets are available.");
        }
    } else {
        alert("Maximum tickets for this type have been reached.");
    }
}

function decrementQuantity(button) {
    var input = button.parentElement.querySelector('input[type="text"]');
    var value = parseInt(input.value);
    if (value > 0) {
        input.value = value - 1;
    }
}

function validateAndSubmit(booking_deadline) {
    var ticketQuantities = document.querySelectorAll(".ticket-quantity");
    var ticketCount = 0;
    ticketQuantities.forEach(function (ticket) {
        ticketCount += parseInt(ticket.value);
    });

    var bookingDeadlineDate = new Date(booking_deadline);
    var bookingDeadlineDateOnly = new Date(
        bookingDeadlineDate.getFullYear(),
        bookingDeadlineDate.getMonth(),
        bookingDeadlineDate.getDate()
    );
    var currentDate = new Date();
    var currentDateOnly = new Date(
        currentDate.getFullYear(),
        currentDate.getMonth(),
        currentDate.getDate()
    );

    if (ticketCount === 0) {
        alert("Please select at least one ticket.");
        return false;
    } else if ( booking_deadline && (currentDateOnly > bookingDeadlineDateOnly)) {
        alert("Booking has been closed.");
        return false;
    }

    // Hide all steps
    document.querySelectorAll(".step").forEach(function (el) {
        el.style.display = "none";
    });

    // Show the selected step
    document.getElementById("step" + 1).style.display = "block";

    currentActive++;

    if (currentActive > circles.length) {
        currentActive = circles.length;
    }

    update();
}

function validateEmail(email) {
    return new Promise(function (resolve, reject) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "/booking/is-valid-user");
        xhr.setRequestHeader("Content-Type", "application/json");
        xhr.onload = function () {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                resolve(response.isValidUser);
            } else {
                resolve(false); // If not valid, return false
            }
        };
        xhr.onerror = function () {
            console.error(xhr.statusText);
            resolve(false); // If error, return false
        };
        xhr.send(JSON.stringify({ email: email }));
    });
}
