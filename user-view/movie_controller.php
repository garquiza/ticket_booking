<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include '../includes/db.php';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $movie = $_POST['select_movie'] ?? '';
    $movieDate = $_POST['movie_date'] ?? '';
    $movieTime = $_POST['movie_time'] ?? '';
    $ticketQuantity = $_POST['ticket_quantity'] ?? '';
    $seats = $_POST['seats'] ?? '';
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';


    // Validate form data
    if ($movie && $movieDate && $movieTime && $ticketQuantity && $seats && $name && $email && $phone) {
        // Insert data into the database
        $sql = "INSERT INTO moviebooking (select_movie, movie_date, movie_time, ticket_quantity, seats, name, email, phone) 
                VALUES ('$movie', '$movieDate', '$movieTime', '$ticketQuantity', '$seats', '$name', '$email', '$phone')";
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

    // Send the response back to frontend
    echo json_encode($response);
} else {
    // Handle invalid request
    $response = array("status" => "error", "message" => "Invalid request.");
    echo json_encode($response);
}
