<?php
session_start();
if ($_SESSION['role'] != 'admin-client') {
    header("Location: /ticket_booking/login.php");
    exit();
}

include '../includes/db.php';

$feature = isset($_GET['feature']) ? $_GET['feature'] : '';

if ($feature == 'bus') {
    $sql = "SELECT * FROM busbooking";
} elseif ($feature == 'cinema') {
    $sql = "SELECT * FROM moviebooking";
} else {
    header("Location: /ticket_booking/admin-developer/index.php");
    exit();
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Client - Booking Database</title>
    <link rel="stylesheet" type="text/css" href="style_db.css">
</head>

<body>
    <div class="db_container">
        <h1><?php echo ucfirst($feature); ?> Booking Database</h1>
        <table>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <?php if ($feature == 'bus') : ?>
                    <th>Service Type</th>
                    <th>Destination</th>
                    <th>Passenger Quantity</th>
                    <th>Selected Seats</th>
                    <th>Departure Date</th>
                    <th>Departure Time</th>
                    <th>Return Date</th>
                    <th>Return Time</th>
                    <th>Booking Date</th>
                <?php else : ?>
                    <th>Movie</th>
                    <th>Ticket Quantity</th>
                    <th>Seats</th>
                    <th>Show Time</th>
                    <th>Date</th>
                <?php endif; ?>
            </tr>
            <?php
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['phone'] . "</td>";
                if ($feature == 'bus') {
                    echo "<td>" . $row['service_type'] . "</td>";
                    echo "<td>" . $row['destination'] . "</td>";
                    echo "<td>" . $row['passenger_quantity'] . "</td>";
                    echo "<td>" . $row['selected_seats'] . "</td>";
                    echo "<td>" . $row['departure_date'] . "</td>";
                    echo "<td>" . $row['departure_time'] . "</td>";
                    echo "<td>" . $row['return_date'] . "</td>";
                    echo "<td>" . $row['return_time'] . "</td>";
                    echo "<td>" . $row['booking_date'] . "</td>";
                } else {
                    echo "<td>" . $row['select_movie'] . "</td>";
                    echo "<td>" . $row['ticket_quantity'] . "</td>";
                    echo "<td>" . $row['seats'] . "</td>";
                    echo "<td>" . $row['movie_time'] . "</td>";
                    echo "<td>" . $row['movie_date'] . "</td>";
                }
                echo "</tr>";
            }
            ?>
        </table>
        <div class="button-container">
            <a href="index.php" class="btn">Back to Admin Panel</a>
        </div>
    </div>

</body>

</html>

<?php
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: /ticket_booking/login.php");
    exit();
}
?>