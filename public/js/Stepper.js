const mobileInput = document.getElementById("mobile");

// Add event listener for input
mobileInput.addEventListener("input", function(event) {
    // Remove non-numeric characters from the input value
    const sanitizedValue = event.target.value.replace(/\D/g, "");

    // Update the input value with the sanitized value
    event.target.value = sanitizedValue;
});


const progress = document.querySelector("#progress");
const prev = document.querySelector("#prev");
const next = document.querySelector("#next");
const circles = document.querySelectorAll(".circle");

let currentActive = 1;

next.addEventListener("click", () => {
    if(!validateUserForm()){
        return false;;
    }
    currentActive++;

    if (currentActive > circles.length) {
        currentActive = circles.length;
    }

    update();
});

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

function validateUserForm(){

    var name = document.getElementById("name").value;
    var email = document.getElementById("email").value;
       

        if (name.trim() === "") {
            return false;
        }

        if (email.trim() === "") {
            return false;
        }

        return true;
}

function showStep(step) {
    if(step==2){
        if(!validateUserForm()){
            return false;;
        }
    }
    // Hide all steps
    document.querySelectorAll(".step").forEach(function (el) {
        el.style.display = "none";
    });

    // Show the selected step
    document.getElementById("step" + step).style.display = "block";
}

function incrementQuantity(button) {
    var input = button.parentElement.querySelector('input[type="text"]');
    var value = parseInt(input.value);
    input.value = value + 1;
}

function decrementQuantity(button) {
    var input = button.parentElement.querySelector('input[type="text"]');
    var value = parseInt(input.value);
    if (value > 0) {
        input.value = value - 1;
    }
}

function validateAndSubmit() {
    var ticketQuantities = document.querySelectorAll(".ticket-quantity");
    var ticketCount = 0;
    ticketQuantities.forEach(function (ticket) {
        ticketCount += parseInt(ticket.value);
    });
    if (ticketCount === 0) {
        alert("Please select at least one ticket.");
    } else {
        document.getElementById("ticketForm").submit();
    }
}
