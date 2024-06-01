<?php
// Check if a session is already active before starting a new one
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include '../includes/db.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $movie = $_POST['select_movie'] ?? '';
    $movieDate = $_POST['movie_date'] ?? '';
    $movieTime = $_POST['movie_time'] ?? '';
    $ticketQuantity = $_POST['ticket_quantity'] ?? '';

    // Validate form data
    if ($movie && $movieDate && $movieTime && $ticketQuantity) {
        // Insert data into the database
        $sql = "INSERT INTO bookings (select_movie, movie_date, movie_time, ticket_quantity) 
                VALUES ('$movie', '$movieDate', '$movieTime', '$ticketQuantity')";
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
    <title>Cinema Ticket Booking</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
</head>
<body>
    <div class="booking-form">
        <h1>Cinema Ticket Booking</h1>
        <?php if (isset($message)): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <label for="select_movie">Movie</label><br>
            <select name="select_movie" id="select_movie" required>
                <option value="" selected disabled>Select Movie</option>
                <option value="Movie1">Movie 1</option>
                    <option value="Movie2">Movie 2</option>
                    <option value="Movie3">Movie 3</option>
            </select><br>

            <label for="movie_date">Movie Date:</label><br>
            <input type="text" name="movie_date" id="movie_date" placeholder="mm/dd/yyyy" required><br>

            <label for="movie_time">Movie Time:</label><br>
            <select name="movie_time" id="movie_time" required>
                <?php for ($hour = 0; $hour < 22; $hour++): ?>
                    <option value="<?php printf('%02d:00', $hour); ?>"><?php printf('%02d:00', $hour); ?></option>
                <?php endfor; ?>
            </select><br>

            <label for="ticket_quantity">Ticket Quantity:</label><br>
            <input type="number" name="ticket_quantity" id="ticket_quantity" required><br>
            <button type="button" id="select_seats" class="btns">Select Seats</button>

            <input type="submit" value="Book Ticket">
        </form>
    </div>

    <script>
        $(document).ready(function() {
            $("#movie_date").datepicker({
                dateFormat: 'mm/dd/yy',
                minDate: 0 // Set minDate to restrict selection to future dates only
            });
        });
    </script>
</body>
</html>

