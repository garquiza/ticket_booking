<?php
session_start();
if ($_SESSION['role'] != 'admin-developer') {
    header("Location: /ticket_booking/login.php");
    exit();
}
include '../includes/db.php';

$message = ''; // Initialize the message variable

// Add user functionality
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = 'admin-client';

    // No password hashing
    $password = $password;

    $sql = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')";
    if ($conn->query($sql) === TRUE) {
        $message = "New user created successfully";
    } else {
        $message = "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User - Developer Admin Panel</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <div class="admin-panel">
        <h1>Add User</h1>
        <?php if ($message) : ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            Username: <input type="text" name="username" required><br>
            Password: <input type="password" name="password" required><br>
            <input type="submit" value="Add User">
        </form>
        <!-- Back button -->
        <a href="index.php" class="back-button">Back</a>
    </div>
</body>

</html>