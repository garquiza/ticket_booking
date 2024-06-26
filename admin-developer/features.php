<?php
session_start();
if ($_SESSION['role'] != 'admin-developer') {
    header("Location: /ticket_booking/login.php");
    exit();
}
include '../includes/db.php';

$message = '';

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
    if ($conn->query($sql)) {
        $message = "Saved Successful";
    } else {
        $message = "Error: " . $conn->error;
    }
}

$sql = "SELECT * FROM settings WHERE id=1";
$result = $conn->query($sql);
$settings = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toggle Features</title>
    <link rel="stylesheet" href="style_admindev.css">
</head>

<body>
    <div class="admin-panel">
        <h1>Toggle Ticket Booking</h1>
        <?php if (!empty($message)) : ?>
            <p class="message"><?php echo $message; ?></p>
        <?php endif; ?>
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

            toggleFeatures();
        });
    </script>
</body>

</html>