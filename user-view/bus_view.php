<?php
include '../includes/db.php';

if ($conn === false) {
    die("Error: Could not connect. " . mysqli_connect_error());
}

$settings = array();

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
    <title>Bus Ticket Booking</title>
    <link rel="stylesheet" href="style_userview.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
</head>

<body style="background-image: url('../assets/BUSbg.jpg');">
    <header>
        <nav>
            <div class="nav-left">
                <img src="../assets/BUSlogo.png" alt="Company Logo" class="company-logo">
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

                <div id="one_way_destination_block" style="display: none;">
                    <label for="one_way_destination">Destination:</label>
                    <select name="one_way_destination" id="one_way_destination">
                        <option value="" selected disabled>Select destination</option>
                        <?php
                        $sql_one_way = "SELECT DISTINCT location_name FROM manage_bus WHERE location_type='one_way'";
                        $result_one_way = $conn->query($sql_one_way);
                        if ($result_one_way->num_rows > 0) {
                            while ($row_one_way = $result_one_way->fetch_assoc()) {
                                echo "<option value='" . $row_one_way['location_name'] . "'>" . $row_one_way['location_name'] . "</option>";
                            }
                        }
                        ?>
                    </select><br>
                </div>

                <div id="round_trip_destination_block" style="display: none;">
                    <label for="round_trip_destination">Destination:</label>
                    <select name="round_trip_destination" id="round_trip_destination">
                        <option value="" selected disabled>Select Destination</option>
                        <?php
                        $sql_round_trip = "SELECT DISTINCT location_name FROM manage_bus WHERE location_type='round_trip'";
                        $result_round_trip = $conn->query($sql_round_trip);
                        if ($result_round_trip->num_rows > 0) {
                            while ($row_round_trip = $result_round_trip->fetch_assoc()) {
                                echo "<option value='" . $row_round_trip['location_name'] . "'>" . $row_round_trip['location_name'] . "</option>";
                            }
                        }
                        ?>
                    </select><br>
                </div>


                <label for="departure_date">Departure Date:</label>
                <input type="date" name="departure_date" id="departure_date" required><br>

                <label for="departure_time">Departure Time:</label>
                <input type="time" name="departure_time" id="departure_time" required><br>

                <div id="return_date_time_block" style="display: none;">
                    <label for="return_date">Return Date:</label>
                    <input type="date" name="return_date" id="return_date" required><br>

                    <label for="return_time">Return Time:</label><br>
                    <input type="time" name="return_time" id="return_time" required><br>
                </div>

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
                <input type="hidden" name="selected_seats" id="selected_seats" value="">
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
                    <p>1.1. Your booking is confirmed once payment has been successfully processed and you have received
                        a booking confirmation containing your ticket details.</p>
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
    <script src="../user-view/bus-script.js"></script>
</body>

</html>