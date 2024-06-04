<?php
session_start();
include '../includes/db.php';

if ($_SESSION['role'] != 'admin-client') {
    header("Location: /ticket_booking/login.php");
    exit();
}

// Fetch booking details from the database
$sql = "SELECT * FROM busbooking";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Client - Bus Booking Database</title>
    <link rel="stylesheet" type="text/css" href="style_adminclient.css">
</head>

<body>
    <div>
        <h1>Bus Booking Database</h1>
        <table>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Service Type</th>
                <th>Destination</th>
                <th>Passenger Quantity</th>
                <th>Selected Seats</th>
                <th>Departure Date</th>
                <th>Departure Time</th>
                <th>Return Date</th>
                <th>Return Time</th>
                <th>Booking Date</th>
            </tr>
            <?php
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['phone'] . "</td>";
                echo "<td>" . $row['service_type'] . "</td>";
                echo "<td>" . $row['destination'] . "</td>";
                echo "<td>" . $row['passenger_quantity'] . "</td>";
                echo "<td>" . $row['selected_seats'] . "</td>";
                echo "<td>" . $row['departure_date'] . "</td>";
                echo "<td>" . $row['departure_time'] . "</td>";
                echo "<td>" . $row['return_date'] . "</td>";
                echo "<td>" . $row['return_time'] . "</td>";
                echo "<td>" . $row['booking_date'] . "</td>";
                echo "</tr>";
            }
            ?>
        </table>
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