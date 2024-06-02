<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus Ticket Booking</title>
    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
</head>

<body>
    <!-- <div class="container">
        <h1>Bus Ticket Booking</h1>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, <br>sed do eiusmod tempor incididunt ut labore et
            dolore magna aliqua.</p>
        <button id="scroll_to_details">Book Now</button>
    </div> -->

    <form id="bookingForm" action="bus_controller.php" method="POST">
        <div id="details_container">
            <div id="bus_details">
                <!-- Bus details -->
                <label for="service_type">Service Type:</label>
                <select name="service_type" id="service_type" required>
                    <option value="" selected disabled>Select Service Type</option>
                    <option value="round_trip">Round-Trip</option>
                    <option value="one_way">One-Way</option>
                </select><br>

                <div id="one_way_destination_block">
                    <label for="one_way_destination">Destination:</label><br>
                    <select name="one_way_destination" id="one_way_destination" required>
                        <option value="" selected disabled>Select destination</option>
                        <option value="Manila">Manila</option>
                        <option value="Baguio">Baguio</option>
                        <option value="Tuguegarao">Tuguegarao</option>
                    </select><br>
                </div>

                <div id="round_trip_destination_block" style="display: none;">
                    <label for="round_trip_from">From:</label><br>
                    <select name="round_trip_from" id="round_trip_from" required>
                        <option value="" selected disabled>Select departure location</option>
                        <option value="Manila">Manila</option>
                        <option value="Baguio">Baguio</option>
                        <option value="Tuguegarao">Tuguegarao</option>
                    </select><br>
                    <label for="round_trip_to">To:</label><br>
                    <select name="round_trip_to" id="round_trip_to" required>
                        <option value="" selected disabled>Select arrival location</option>
                        <option value="Manila">Manila</option>
                        <option value="Baguio">Baguio</option>
                        <option value="Tuguegarao">Tuguegarao</option>
                    </select><br>
                </div>

                <label for="departure_date">Departure Date:</label>
                <input type="date" name="departure_date" id="departure_date" required><br>

                <div id="return_date_time_block" style="display: none;">
                    <label for="return_date">Return Date:</label>
                    <input type="date" name="return_date" id="return_date" required><br>

                    <label for="return_time">Return Time:</label><br>
                    <input type="time" name="return_time" id="return_time" required><br>
                </div>

                <label for="departure_time">Departure Time:</label>
                <input type="time" name="departure_time" id="departure_time" required><br>

                <div id="ticket_quantity_container">
                    <label for="ticket_quantity">Ticket Quantity:</label>
                    <input type="number" name="ticket_quantity" id="ticket_quantity" required><br>
                    <button type="button" id="select_seats" class="btns">Select Seats</button>
                </div>
            </div>

            <div id="seat_selection_container" style="display: none;">
                <h2>Select Your Seats</h2>
                <div id="seat_map"></div>
                <button type="button" id="confirm_seats" class="btns">Confirm Seats</button>

                <!-- Hidden input field to hold the selected seats -->
                <input type="hidden" name="selected_seats" id="selected_seats" value="">
            </div>

            <div id="personal_info_container" style="display: none;">
                <!-- Personal info -->
                <h2>Personal Information</h2>
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" required><br>
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" required><br>
                <label for="phone">Phone:</label>
                <input type="text" name="phone" id="phone" required><br>
                <button type="button" id="next_personal_info" class="btns">Next</button>
            </div>

            <div id="policy_review_container" style="display: none;">
                <!-- Policy review -->
                <h2>Policies and Terms & Conditions</h2>
                <br>
                <div class="terms-and-conditions">
                    <h4>1. Booking Confirmation</h4>
                    <p>1.1. Your booking is confirmed once payment has been successfully processed and you have received
                        a booking confirmation email or SMS containing your ticket details.</p>
                    <p>1.2. Please review your booking confirmation carefully to ensure all details, including the date,
                        time, and venue, are correct. Notify us immediately if you identify any discrepancies.</p>

                    <h4>2. Ticket Usage</h4>
                    <p>2.1. You must present a valid ID along with your ticket (electronic or printed) to board the bus
                        or enter the cinema.</p>
                    <p>2.2. Tickets are non-transferable and must not be resold. Any unauthorized resale or attempted
                        resale may result in the cancellation of the ticket without refund.</p>
                    <h4>9. Governing Law</h4>
                    <p>9.1. These terms and conditions are governed by and construed in accordance with the laws of
                        [Jurisdiction]. Any disputes arising out of or related to your booking will be subject to the
                        exclusive jurisdiction of the courts in [Jurisdiction].</p>
                    <br>
                </div>

                <div class="agree-container">
                    <input type="checkbox" name="agree" id="agree" required>
                    <label for="agree">I agree to the terms and conditions</label>
                </div>

                <br>
                <input type="submit" value="Book Tickets" class="btn">
            </div>
        </div>
    </form>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var busDetails = document.getElementById("bus_details");
            var serviceTypeSelect = document.getElementById("service_type");
            var ticketQuantityContainer = document.getElementById(
                "ticket_quantity_container"
            );
            var seatSelectionContainer = document.getElementById(
                "seat_selection_container"
            );
            var personalInfoContainer = document.getElementById(
                "personal_info_container"
            );
            var policyReviewContainer = document.getElementById(
                "policy_review_container"
            );

            var ticketQuantityInput = document.getElementById("ticket_quantity");
            var selectedSeatsInput = document.getElementById("selected_seats");

            var selectSeatsButton = document.getElementById("select_seats");
            var confirmSeatsButton = document.getElementById("confirm_seats");
            var nextPersonalInfoButton = document.getElementById("next_personal_info");
            var seatMap = document.getElementById("seat_map");

            // Ensure ticket quantity cannot go below 1
            ticketQuantityInput.addEventListener("input", function() {
                var quantity = parseInt(this.value);
                if (isNaN(quantity) || quantity < 1) {
                    this.value = 1;
                }
            });

            // Show seat selection on "Select Seats" button click
            selectSeatsButton.addEventListener("click", function() {
                if (validateForm()) {
                    showSeatSelection();
                } else {
                    alert("Please fill out all required fields before proceeding.");
                }
            });

            // Confirm seats and show personal information and policy review
            confirmSeatsButton.addEventListener("click", function() {
                if (confirmSelection()) {
                    showPersonalInfoAndPolicy();
                }
            });

            // Next button click to show policy review
            nextPersonalInfoButton.addEventListener("click", function() {
                if (validatePersonalInfo()) {
                    showPolicyReview();
                } else {
                    alert(
                        "Please fill out all required fields in the Personal Information section."
                    );
                }
            });

            // Function to validate personal information section
            function validatePersonalInfo() {
                var name = document.getElementById("name").value;
                var email = document.getElementById("email").value;
                var phone = document.getElementById("phone").value;

                // Check if any of the fields are empty
                if (name.trim() === "" || email.trim() === "" || phone.trim() === "") {
                    return false;
                }
                return true;
            }

            // Function to show seat selection
            function showSeatSelection() {
                busDetails.style.display = "none";
                seatSelectionContainer.style.display = "block";
                personalInfoContainer.style.display = "none";
                policyReviewContainer.style.display = "none";
                generateSeatMap();
            }

            // Function to show personal info and policy review
            function showPersonalInfoAndPolicy() {
                seatSelectionContainer.style.display = "none";
                personalInfoContainer.style.display = "block";
                policyReviewContainer.style.display = "none";
            }

            // Function to show policy review section
            function showPolicyReview() {
                $("#one_way_destination").prop("required", false);
                $("#round_trip_from").prop("required", false);
                $("#round_trip_to").prop("required", false);
                personalInfoContainer.style.display = "none";
                policyReviewContainer.style.display = "block";
            }

            // Generate seat map
            function generateSeatMap() {
                var rows = 11;
                var cols = 5;
                seatMap.innerHTML = "";
                var seatNumber = 1;

                for (var i = 0; i < rows; i++) {
                    var row = document.createElement("div");
                    row.classList.add("seat-row");

                    for (var j = 0; j < cols; j++) {
                        var seat = document.createElement("div");
                        seat.classList.add("seat");

                        // Check if the seat number is within the valid range
                        if (seatNumber <= 45) {
                            if (i === rows - 1 || (j + 1) % 3 !== 0) {
                                seat.textContent = seatNumber;
                                seat.addEventListener("click", function() {
                                    if (!this.classList.contains("blank-seat")) {
                                        this.classList.toggle("selected");
                                        updateSelectedSeats();
                                    }
                                });
                                seatNumber++;
                            } else {
                                seat.classList.add("blank-seat");
                            }
                        } else {
                            seat.classList.add("blank-seat");
                        }

                        row.appendChild(seat);
                    }

                    seatMap.appendChild(row);
                }
            }

            function updateSelectedSeats() {
                var selectedSeats = [];
                var selectedElements = document.querySelectorAll(".seat.selected");

                selectedElements.forEach(function(seat) {
                    selectedSeats.push(seat.textContent);
                });

                selectedSeatsInput.value = selectedSeats.join(",");
            }

            // Function to confirm seat selection
            function confirmSelection() {
                var selectedSeats = document.querySelectorAll(".seat.selected").length;
                var ticketQuantity = parseInt(ticketQuantityInput.value);
                if (selectedSeats < ticketQuantity) {
                    alert("Please choose according to the ticket quantity you acquired.");
                    return false;
                } else if (selectedSeats > ticketQuantity) {
                    alert(
                        "You have selected more seats than the ticket quantity you acquired."
                    );
                    return false;
                }
                return true;
            }

            serviceTypeSelect.dispatchEvent(new Event("change"));
        });

        $(document).ready(function() {
            const serviceTypeSelect = $("#service_type");
            const oneWayDestinationBlock = $("#one_way_destination_block");
            const roundTripDestinationBlock = $("#round_trip_destination_block");
            const returnDateTimeBlock = $("#return_date_time_block");

            oneWayDestinationBlock.hide();

            serviceTypeSelect.change(function() {
                if (serviceTypeSelect.val() === "one_way") {
                    oneWayDestinationBlock.show();
                    roundTripDestinationBlock.hide();
                    returnDateTimeBlock.hide();
                    $("#return_date").prop("required", false);
                    $("#return_time").prop("required", false);
                } else if (serviceTypeSelect.val() === "round_trip") {
                    oneWayDestinationBlock.hide();
                    roundTripDestinationBlock.show();
                    returnDateTimeBlock.show();
                    $("#return_date").prop("required", true);
                    $("#return_time").prop("required", true);
                } else {
                    oneWayDestinationBlock.hide();
                    roundTripDestinationBlock.hide();
                    returnDateTimeBlock.hide();
                }
            });

            $("#bookingForm").submit(function(event) {
                event.preventDefault(); // Prevent default form submission

                $("#one_way_destination").prop("required", true);
                $("#round_trip_from").prop("required", true);
                $("#round_trip_to").prop("required", true);

                if (validateForm()) {
                    var formData = $(this).serialize(); // Serialize form data

                    $.ajax({
                        url: "bus_controller.php",
                        type: "POST",
                        data: formData,
                        success: function(response) {
                            if (response.status === "success") {
                                alert(response.message);
                            } else {
                                alert("Error: " + response.message);
                            }
                        },
                        error: function(xhr, status, error) {
                            alert("An error occurred while submitting your booking: " + error);
                        },
                    });
                }
            });
        });

        function validateForm() {
            var serviceType = document.getElementById("service_type").value;
            if (serviceType === "") {
                alert("Please select a service type.");
                return false;
            }

            if (serviceType === "one_way") {
                var oneWayDestination = document.getElementById(
                    "one_way_destination"
                ).value;
                if (oneWayDestination === "") {
                    alert("Please select a destination for one-way trip.");
                    return false;
                }
            } else if (serviceType === "round_trip") {
                var roundTripFrom = document.getElementById("round_trip_from").value;
                var roundTripTo = document.getElementById("round_trip_to").value;
                var returnDate = document.getElementById("return_date").value;
                var returnTime = document.getElementById("return_time").value;

                if (roundTripFrom === "" || roundTripTo === "") {
                    alert(
                        "Please select both departure and arrival locations for round-trip."
                    );
                    return false;
                }

                if (returnDate === "" || returnTime === "") {
                    alert("Please select both return date and return time for round-trip.");
                    return false;
                }
            }

            var departureDate = document.getElementById("departure_date").value;
            var departureTime = document.getElementById("departure_time").value;
            var ticketQuantity = document.getElementById("ticket_quantity").value;

            if (
                departureDate === "" ||
                departureTime === "" ||
                ticketQuantity === "" ||
                ticketQuantity < 1
            ) {
                alert("Please fill out all required fields.");
                return false;
            }

            return true;
        }
    </script>
</body>

</html>