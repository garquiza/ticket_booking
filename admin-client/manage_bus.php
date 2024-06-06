<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Bus</title>
    <link rel="stylesheet" type="text/css" href="style_adminclient.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <?php
    session_start();
    if ($_SESSION['role'] != 'admin-client') {
        header("Location: /ticket_booking/login.php");
        exit();
    }
    include '../includes/db.php';

    $message = '';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $location_type = $_POST['location_type'];
        $location_name = '';
        $bus_driver = $_POST['bus_driver'];
        $bus_number = $_POST['bus_number'];

        if ($location_type == 'one_way') {
            $location_name = $_POST['location_name'];
        } else if ($location_type == 'round_trip') {
            $from_location = $_POST['from_location'];
            $to_location = $_POST['to_location'];
            $location_name = $from_location . ' - ' . $to_location;
        }

        $sql = "INSERT INTO manage_bus (location_name, location_type, bus_driver, bus_number) VALUES ('$location_name', '$location_type', '$bus_driver', '$bus_number')";
        if ($conn->query($sql)) {
            $message = "Added successfully!";
        } else {
            $message = "Error: " . $conn->error;
        }
    }

    $sql = "SELECT location_name, location_type, bus_driver, bus_number FROM manage_bus";
    $result = $conn->query($sql);
    ?>

    <div class="container">
        <h1>Manage Bus</h1>
        <?php if (!empty($message)) : ?>
            <p class="message" style="text-align: center;"><?php echo $message; ?></p>
        <?php endif; ?>
        <form method="POST" action="location_form">
            <label for="location_type">Location Type: </label>
            <select name="location_type" id="location_type" required>
                <option value="" selected disabled>Select Location Type</option>
                <option value="round_trip">Round-Trip</option>
                <option value="one_way">One-Way</option>
            </select><br><br>

            <div id="location_fields">
                <!-- Fields will be populated here based on location type -->
            </div>

            <label for="bus_driver">Bus Driver: </label>
            <input type="text" id="bus_driver" name="bus_driver" required><br>

            <label for="bus_number">Bus Number: </label>
            <input type="text" id="bus_number" name="bus_number" required><br>

            <input type="submit" value="Add Bus">
        </form>

        <h2 style="text-align: center;">Database</h2>
        <table>
            <tr>
                <th>Location Name</th>
                <th>Location Type</th>
                <th>Bus Driver</th>
                <th>Bus Number</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo $row['location_name']; ?></td>
                    <td><?php echo $row['location_type']; ?></td>
                    <td><?php echo $row['bus_driver']; ?></td>
                    <td><?php echo $row['bus_number']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>

        <div class="button-container">
            <a href="index.php" class="btn">Back to Admin Panel</a>
        </div>
    </div>
</body>

</html>

<script>
    $(document).ready(function() {
        $('#location_type').change(function() {
            var locationType = $(this).val();
            if (locationType === 'one_way') {
                $('#location_fields').html('<label for="location_name">Location Name: </label><input type="text" id="location_name" name="location_name" required><br>');
            } else if (locationType === 'round_trip') {
                $('#location_fields').html('<label for="from_location">From: </label><input type="text" id="from_location" name="from_location" required><br><label for="to_location">To: </label><input type="text" id="to_location" name="to_location" required><br>');
            } else {
                $('#location_fields').html('');
            }
        });
    });

    $('#location_form').submit(function(event) {
        var locationType = $('#location_type').val();
        var isValid = true;
        var errorMessage = '';

        if (!locationType) {
            isValid = false;
            errorMessage = 'Please select a location type.';
        } else if (locationType === 'one_way' && !$('#location_name').val()) {
            isValid = false;
            errorMessage = 'Please enter a location name for one-way.';
        } else if (locationType === 'round_trip' && (!$('#from_location').val() || !$('#to_location').val())) {
            isValid = false;
            errorMessage = 'Please enter both "From" and "To" locations for round-trip.';
        }

        if (!isValid) {
            alert(errorMessage);
            event.preventDefault();
        }
    });
</script>