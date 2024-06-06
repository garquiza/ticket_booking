<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include '../includes/db.php';

$response = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $serviceType = $_POST['service_type'];
    $destination = '';
    if ($serviceType === 'one_way') {
        $destination = $_POST['one_way_destination'] ?? '';
    } elseif ($serviceType === 'round_trip') {
        $destination = ($_POST['round_trip_destination'] ?? '');
    }
    $departureDate = $_POST['departure_date'] ?? '';
    $returnDate = $_POST['return_date'] ?? '';
    $departureTime = $_POST['departure_time'] ?? '';
    $returnTime = $_POST['return_time'] ?? '';
    $passengerQuantity = $_POST['ticket_quantity'] ?? '';
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $selectedSeats = $_POST['selected_seats'] ?? '';

    if ($serviceType && $destination && $departureDate && $departureTime && $passengerQuantity && $name && $email && $phone && ($serviceType === 'one_way' || ($serviceType === 'round_trip' && $returnDate && $returnTime))) {
        // Insert data into the database
        // $selectedSeats = isset($_POST['selected_seats']) ? implode(',', $_POST['selected_seats']) : '';
        $sql = "INSERT INTO busbooking (service_type, destination, departure_date, return_date, departure_time, return_time, passenger_quantity, selected_seats, name, email, phone) 
                VALUES ('$serviceType', '$destination', '$departureDate', '$returnDate', '$departureTime', '$returnTime', '$passengerQuantity', '$selectedSeats', '$name', '$email', '$phone')";
        if ($conn->query($sql) === TRUE) {
            unset($_SESSION['booking']);

            header("Location: index.php");
            exit();
            $response = array("status" => "success", "message" => "Booking successful!");
        } else {
            $response = array("status" => "error", "message" => "Error: " . $sql . "<br>" . $conn->error);
        }
    } else {
        $response = array("status" => "error", "message" => "All fields are required.");
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $location_name = $_GET['location_name'];

    // Prepare the SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT bus_driver, bus_number FROM manage_bus WHERE location_name = ?");
    $stmt->bind_param("s", $location_name);
    $stmt->execute();
    $stmt->bind_result($busDriver, $busNumber);
    $stmt->fetch();

    if ($busDriver && $busNumber) {
        $response = [
            'status' => 'success',
            'bus_driver' => $busDriver,
            'bus_number' => $busNumber
        ];
    } else {
        $response = [
            'status' => 'error',
            'message' => 'Bus not found'
        ];
    }

    $stmt->close();
    $conn->close();
} else {
    $response = array("status" => "error", "message" => "Invalid request.");
}



header('Content-Type: application/json');
echo json_encode($response);
