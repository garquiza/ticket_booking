<?php
session_start();
if ($_SESSION['role'] != 'admin-developer') {
    header("Location: /ticket_booking/login.php");
    exit();
}
include '../includes/db.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bus_feature = isset($_POST['bus_feature']) ? 1 : 0;
    $cinema_feature = isset($_POST['cinema_feature']) ? 1 : 0;

    // Ensure that only one feature can be enabled
    if ($bus_feature && $cinema_feature) {
        // If both features are enabled, disable both
        $bus_feature = 0;
        $cinema_feature = 0;
    }

    // Update settings in the database
    $sql = "UPDATE settings SET bus_feature='$bus_feature', cinema_feature='$cinema_feature' WHERE id=1";
    $conn->query($sql);

    // Redirect back to prevent form resubmission
    header("Location: features.php");
    exit();
}

// Retrieve current feature settings from the database
$sql = "SELECT * FROM settings WHERE id=1";
$result = $conn->query($sql);
$settings = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Developer Admin - Toggle Features</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="admin-panel">
        <h1>Developer Admin Panel - Toggle Features</h1>
        <form method="POST" action="">
            <label>
                <input type="checkbox" name="bus_feature" id="bus_feature" <?php if ($settings['bus_feature']) echo 'checked'; ?>> Bus Ticket Booking
            </label><br>
            <label>
                <input type="checkbox" name="cinema_feature" id="cinema_feature" <?php if ($settings['cinema_feature']) echo 'checked'; ?>> Cinema Ticket Booking
            </label><br>
            <input type="submit" value="Save">
        </form>
        <a href="index.php" class="back-button">Back</a>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const busFeature = document.getElementById('bus_feature');
            const cinemaFeature = document.getElementById('cinema_feature');

            function toggleFeatures() {
                if (busFeature.checked) {
                    cinemaFeature.disabled = true;
                } else if (cinemaFeature.checked) {
                    busFeature.disabled = true;
                } else {
                    busFeature.disabled = false;
                    cinemaFeature.disabled = false;
                }
            }

            busFeature.addEventListener('change', toggleFeatures);
            cinemaFeature.addEventListener('change', toggleFeatures);

            // Initialize the toggle state on page load
            toggleFeatures();
        });
    </script>
</body>
</html>
