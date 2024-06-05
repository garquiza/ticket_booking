<?php
session_start();
if ($_SESSION['role'] != 'admin-developer') {
    header("Location: /ticket_booking/login.php");
    exit();
}
include '../includes/db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = 'admin-client';

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
    <title>Add User</title>
    <link rel="stylesheet" href="style_admindev.css">
</head>

<body>
    <div class="admin-panel">
        <h1>Add User</h1>

        <?php if ($message) : ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <label for="site_name">Username:</label>
            <input type="text" name="username" required><br>

            <label for="site_name">Password:</label>
            <input type="password" name="password" required><br>

            <input type="submit" value="Add User">
        </form>

        <a href="index.php" class="back-button">Back</a>
    </div>
</body>

</html>