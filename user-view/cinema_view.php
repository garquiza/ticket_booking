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
    <title>Cinema Ticket Booking</title>
    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
</head>

<body>
    <!-- <div class="container">
        <h1>Cinema Ticket Booking</h1>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, <br>sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
        <button id="scroll_to_details">Book Now</button>
    </div> -->
    <form method="POST" action="movie_controller.php">
        <div id="details_container">
            <div id="movie_details">
                <!-- Movie details -->
                <label for="select_movie">Movie</label><br>
                <select name="select_movie" id="select_movie" required>
                    <option value="" selected disabled>Select Movie</option>
                    <option value="Movie1">Movie 1</option>
                    <option value="Movie2">Movie 2</option>
                    <option value="Movie3">Movie 3</option>
                </select><br>

                <label for="movie_date">Movie Date:</label>
                <input type="date" name="movie_date" id="movie_date" required><br>

                <label for="movie_time">Movie Time:</label>
                <input type="time" name="movie_time" id="movie_time" required><br>

                <div id="ticket_quantity_container">
                    <label for="ticket_quantity">Ticket Quantity:</label>
                    <input type="number" name="ticket_quantity" id="ticket_quantity" required><br>
                    <button type="button" id="select_seats" class="btns">Select Seats</button>
                </div>
            </div>

            <!-- Seat selection -->
            <div id="seat_selection_container" style="display: none;">
                <h2>Select Your Seats</h2>
                <div id="seat_map"></div>
                <input type="hidden" name="seats" id="seats" required>
                <button type="button" id="confirm_seats" class="btns">Confirm Seats</button>
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
                    <p>1.1. Your booking is confirmed once payment has been successfully processed and you have received a booking confirmation email or SMS containing your ticket details.</p>
                    <p>1.2. Please review your booking confirmation carefully to ensure all details, including the date, time, and venue, are correct. Notify us immediately if you identify any discrepancies.</p>

                    <h4>2. Ticket Usage</h4>
                    <p>2.1. You must present a valid ID along with your ticket (electronic or printed) to board the bus or enter the cinema.</p>
                    <p>2.2. Tickets are non-transferable and must not be resold. Any unauthorized resale or attempted resale may result in the cancellation of the ticket without refund.</p>
                    <h4>9. Governing Law</h4>
                    <p>9.1. These terms and conditions are governed by and construed in accordance with the laws of [Jurisdiction]. Any disputes arising out of or related to your booking will be subject to the exclusive jurisdiction of the courts in [Jurisdiction].</p>
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
            var movieDetails = document.getElementById("movie_details");
            var selectMovieSelect = document.getElementById("select_movie");
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

            // Show seat selection once "Select Seats" button clicked
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
                    captureSelectedSeats(); // Add this line to capture selected seats
                    showPersonalInfoAndPolicy();
                }
            });

            // Click next button to show policy review
            nextPersonalInfoButton.addEventListener("click", function() {
                if (validatePersonalInfo()) {
                    showPolicyReview();
                } else {
                    alert(
                        "Please fill out all required fields in the Personal Information section."
                    );
                }
            });

            // Function to validate personal information
            function validatePersonalInfo() {
                var name = document.getElementById("name").value;
                var email = document.getElementById("email").value;
                var phone = document.getElementById("phone").value;

                // Check if any of fields are empty
                if (name.trim() === "" || email.trim() === "" || phone.trim() === "") {
                    return false;
                }
                return true;
            }

            // Show seat selection
            function showSeatSelection() {
                movieDetails.style.display = "none";
                seatSelectionContainer.style.display = "block";
                personalInfoContainer.style.display = "none";
                policyReviewContainer.style.display = "none";
                generateSeatMap();
            }

            // Show personal info and policy review
            function showPersonalInfoAndPolicy() {
                seatSelectionContainer.style.display = "none";
                personalInfoContainer.style.display = "block";
                policyReviewContainer.style.display = "none";
            }

            // Show policy review section
            function showPolicyReview() {
                personalInfoContainer.style.display = "none";
                policyReviewContainer.style.display = "block";
            }

            // Generate seat map
            function generateSeatMap() {
                var rows = 6;
                var cols = 8;

                // Generate rows and columns for seat map
                for (var i = 0; i < rows; i++) {
                    var row = document.createElement("div");
                    row.classList.add("seat-row");
                    var rowLabel = String.fromCharCode(65 + i); // Generate row label (A, B, C, ...)
                    row.innerHTML = "<div class='row-label'>" + rowLabel + "</div>";

                    for (var j = 1; j <= cols; j++) {
                        var seat = document.createElement("div");
                        seat.classList.add("seat");
                        seat.textContent = rowLabel + j; // Generate seat label (A1, A2, A3, ...)
                        seat.addEventListener("click", function() {
                            this.classList.toggle("selected");
                        });
                        row.appendChild(seat);
                    }
                    seatMap.appendChild(row);
                }
            }

            // Confirm seat selection
            function confirmSelection() {
                var selectedSeats = document.querySelectorAll(".seat.selected");
                var ticketQuantity = parseInt(ticketQuantityInput.value);
                if (selectedSeats.length < ticketQuantity) {
                    alert("Please choose according to the ticket quantity you acquired.");
                    return false;
                } else if (selectedSeats.length > ticketQuantity) {
                    alert(
                        "You have selected more seats than the ticket quantity you acquired."
                    );
                    return false;
                }
                return true;
            }

            // Capture selected seats
            function captureSelectedSeats() {
                var selectedSeats = document.querySelectorAll(".seat.selected");
                var selectedSeatsArray = [];
                selectedSeats.forEach(function(seat) {
                    selectedSeatsArray.push(seat.textContent);
                });
                document.getElementById("seats").value = selectedSeatsArray.join(',');
            }

            // Validate form data
            function validateForm() {
                var movie = document.getElementById("select_movie").value;
                if (movie === "") {
                    alert("Please select a movie.");
                    return false;
                }

                var movieDate = document.getElementById("movie_date").value;
                var movieTime = document.getElementById("movie_time").value;
                var ticketQuantity = document.getElementById("ticket_quantity").value;

                if (
                    movieDate === "" ||
                    movieTime === "" ||
                    ticketQuantity === "" ||
                    ticketQuantity < 1
                ) {
                    alert("Please fill out all required fields.");
                    return false;
                }

                return true;
            }

            // Call generateSeatMap function when the page is loaded
            generateSeatMap();

            // Dispatch change event to trigger initial seat map generation
            selectMovieSelect.dispatchEvent(new Event("change"));
        });

        // Submit form asynchronously
        $('form').submit(function(event) {
            // Prevent default form submission
            event.preventDefault();

            // Serialize form data
            var formData = $(this).serialize();

            // Submit form using AJAX
            $.post('movie_controller.php', formData)
                .done(function(response) {
                    // Parse JSON response
                    var data = JSON.parse(response);

                    // Display message
                    if (data.status === 'success') {
                        alert(data.message);
                    } else {
                        alert(data.message);
                    }
                })
                .fail(function() {
                    alert('An error occurred while processing your request.');
                });
        });
    </script>
</body>

</html>