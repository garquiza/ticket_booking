<?php
// Check if a session is already active before starting a new one
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include '../includes/db.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $serviceType = $_POST['service_type'];
    $destination = '';
    if ($serviceType === 'one_way') {
        $destination = $_POST['one_way_destination'] ?? '';
    } elseif ($serviceType === 'round_trip') {
        $destination = $_POST['round_trip_from'] . ' to ' . $_POST['round_trip_to'] ?? '';
    }
    $departureDate = $_POST['departure_date'] ?? '';
    $returnDate = $_POST['return_date'] ?? '';
    $departureTime = $_POST['departure_time'] ?? '';
    $returnTime = $_POST['return_time'] ?? '';
    $passengerQuantity = $_POST['passenger_quantity'] ?? '';

    // Validate form data
    if ($serviceType && $destination && $departureDate && $departureTime && $passengerQuantity && ($serviceType === 'one_way' || ($serviceType === 'round_trip' && $returnDate && $returnTime))) {
        // Insert data into the database
        $sql = "INSERT INTO bookings (service_type, destination, departure_date, return_date, departure_time, return_time, passenger_quantity) 
                VALUES ('$serviceType', '$destination', '$departureDate', '$returnDate', '$departureTime', '$returnTime', '$passengerQuantity')";
        if ($conn->query($sql) === TRUE) {
            $message = "Booking saved successfully";
        } else {
            $message = "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        $message = "Error: All fields are required";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus Ticket Booking</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
</head>
<body>
    <div class="booking-form">
        <h1>Bus Ticket Booking</h1>
        <?php if (isset($message)): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <label for="service_type">Service Type:</label><br>
            <select name="service_type" id="service_type" required>
                <option value="" selected disabled>Select Service Type</option>
                <option value="one_way">One Way</option>
                <option value="round_trip">Round Trip</option>
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

            <label for="departure_date">Departure Date:</label><br>
            <input type="text" name="departure_date" id="departure_date" placeholder="mm/dd/yyyy" required><br>

            <div id="return_date_time_block" style="display: none;">
                <label for="return_date">Return Date:</label><br>
                <input type="text" name="return_date" id="return_date" placeholder="mm/dd/yyyy"><br>
                
                <label for="return_time">Return Time:</label><br>
                <select name="return_time" id="return_time">
                    <?php for ($hour = 0; $hour < 24; $hour++): ?>
                        <option value="<?php printf('%02d:00', $hour); ?>"><?php printf('%02d:00', $hour); ?></option>
                    <?php endfor; ?>
                </select><br>
            </div>

            <label for="departure_time">Departure Time:</label><br>
            <select name="departure_time" id="departure_time" required>
                <?php for ($hour = 0; $hour < 24; $hour++): ?>
                    <option value="<?php printf('%02d:00', $hour); ?>"><?php printf('%02d:00', $hour); ?></option>
                <?php endfor; ?>
            </select><br>

            <label for="passenger_quantity">Passengers Ticket Quantity:</label><br>
            <input type="number" name="passenger_quantity" id="passenger_quantity" required><br>

            <input type="submit" value="Book Ticket">
        </form>
    </div>

    <script>
        // showing/hiding destination block based on service type
        $(document).ready(function() {
            const serviceTypeSelect = $('#service_type');
            const oneWayDestinationBlock = $('#one_way_destination_block');
            const roundTripDestinationBlock = $('#round_trip_destination_block');
            const returnDateTimeBlock = $('#return_date_time_block');

            oneWayDestinationBlock.hide();

            serviceTypeSelect.change(function() {
                if (serviceTypeSelect.val() === 'one_way') {
                    oneWayDestinationBlock.show();
                    roundTripDestinationBlock.hide();
                    returnDateTimeBlock.hide();
                    $('#return_date').prop('required', false);
                    $('#return_time').prop('required', false);
                } else if (serviceTypeSelect.val() === 'round_trip') {
                    oneWayDestinationBlock.hide();
                    roundTripDestinationBlock.show();
                    returnDateTimeBlock.show();
                    $('#return_date').prop('required', true);
                    $('#return_time').prop('required', true);
                } else {
                    oneWayDestinationBlock.hide();
                    roundTripDestinationBlock.hide();
                    returnDateTimeBlock.hide();
                }
            });

            $("#departure_date").datepicker({
                dateFormat: 'mm/dd/yy',
                minDate: 0 // Set minDate to restrict selection to future dates only
            });
            $("#return_date").datepicker({
                dateFormat: 'mm/dd/yy',
                minDate: 0 // Set minDate to restrict selection to future dates only
            });
        });
    </script>
</body>
</html>

