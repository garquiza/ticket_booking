<?php
include '../includes/db.php';

// Check if connection is successful
if ($conn === false) {
    die("Error: Could not connect. " . mysqli_connect_error());
}

// Declare settings variable
$settings = array();

// Check if settings are available
$sql = "SELECT * FROM settings WHERE id=1";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    $settings = $result->fetch_assoc();
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
    <script src="../user-view/cinema-script.js"></script>
</head>

<body style="background-image: url('../assets/MOVIEbg.jpg');">
    <header>
        <nav>
            <div class="nav-left">
                <img src="../assets/MOVIElogo.png" alt="Company Logo" class="company-logo">
            </div>
            <div class="nav-right">
                <span class="company-name"><?php echo $settings['site_name']; ?></span>
            </div>
        </nav>
    </header>

    <div class="container">
        <h1><?php echo $settings['h1_text']; ?></h1>
        <p><?php echo $settings['p_text']; ?></p>
        <a href="#movie_details" id="scroll_to_details">Book Now</a>
    </div>


    <form method="POST" action="movie_controller.php">
        <div id="details_container">
            <div id="movie_details">
                <!-- Movie details -->
                <label for="select_movie">Movie</label>
                <select name="select_movie" id="select_movie" required>
                    <option value="" selected disabled>Select Movie</option>
                    <?php
                    $sql_movies = "SELECT DISTINCT movie_name FROM manage_movie";
                    $result_movies = $conn->query($sql_movies);
                    if ($result_movies->num_rows > 0) {
                        while ($row_movie = $result_movies->fetch_assoc()) {
                            echo '<option value="' . $row_movie['movie_name'] . '">' . $row_movie['movie_name'] . '</option>';
                        }
                    }
                    ?>
                </select>

                <label for="movie_date">Movie Date:</label>
                <input type="date" name="movie_date" id="movie_date" required><br>

                <label for="movie_time">Movie Time:</label>
                <select name="movie_time" id="movie_time" required>
                    <option value="" selected disabled>Select Time</option>
                </select><br>

                <div id="ticket_quantity_container">
                    <label for="ticket_quantity">Ticket Quantity:</label>
                    <input type="number" name="ticket_quantity" id="ticket_quantity" required><br>
                    <button type="button" id="select_seats" class="btns">Select Seats</button>
                </div>
            </div>

            <div id="seat_selection_container" style="display: none;">
                <!-- Seat selection -->
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
                <input type="text" name="email" id="email" required><br>
                <label for="phone">Phone:</label>
                <input type="text" name="phone" id="phone" required><br>
                <button type="button" id="next_personal_info" class="btns">Next</button>
            </div>

            <div id="ticket_summary_container" style="display: none;">
                <!-- Ticket summary -->
                <h2>Ticket Summary</h2>
                <div id="ticket_summary"></div>
                <button type="button" id="next_ticket_summary" class="btns">Next</button>
            </div>

            <div id="policy_review_container" style="display: none;">
                <!-- Policy review -->
                <h2>Policies and Terms & Conditions</h2>
                <br>
                <div class="terms-and-conditions">
                    <h4>1. Booking Confirmation</h4>
                    <p>1.1. Your booking is confirmed once payment has been successfully processed and you have received a booking confirmation containing your ticket details.</p>
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
</body>

</html>