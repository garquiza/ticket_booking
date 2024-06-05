<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include '../includes/db.php';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $serviceType = $_POST['service_type'];
    $destination = '';
    if ($serviceType === 'one_way') {
        $destination = $_POST['one_way_destination'] ?? '';
    } elseif ($serviceType === 'round_trip') {
        $destination = ($_POST['round_trip_from'] ?? '') . ' - ' . ($_POST['round_trip_to'] ?? '');
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

    // Validate form data
    if ($serviceType && $destination && $departureDate && $departureTime && $passengerQuantity && $name && $email && $phone && ($serviceType === 'one_way' || ($serviceType === 'round_trip' && $returnDate && $returnTime))) {
        // Insert data into the database
        // $selectedSeats = isset($_POST['selected_seats']) ? implode(',', $_POST['selected_seats']) : '';
        $sql = "INSERT INTO busbooking (service_type, destination, departure_date, return_date, departure_time, return_time, passenger_quantity, selected_seats, name, email, phone) 
                VALUES ('$serviceType', '$destination', '$departureDate', '$returnDate', '$departureTime', '$returnTime', '$passengerQuantity', '$selectedSeats', '$name', '$email', '$phone')";
        if ($conn->query($sql) === TRUE) {
            // Clear booking session data
            unset($_SESSION['booking']);

            $response = array("status" => "success", "message" => "Booking successful!");
        } else {
            $response = array("status" => "error", "message" => "Error: " . $sql . "<br>" . $conn->error);
        }
    } else {
        $response = array("status" => "error", "message" => "All fields are required.");
    }
} else {
    $response = array("status" => "error", "message" => "Invalid request.");
}

// Set the response header to application/json
header('Content-Type: application/json');
echo json_encode($response);
