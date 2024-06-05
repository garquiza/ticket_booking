<?php
session_start();
if ($_SESSION['role'] != 'admin-developer') {
    header("Location: /ticket_booking/login.php");
    exit();
}
include '../includes/db.php';

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: /ticket_booking/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Developer Admin</title>
    <link rel="stylesheet" href="style_admindev.css">
</head>

<body>
    <div class="admin-panel">
        <h1>Developer Admin Panel</h1>
        <ul>
            <li><a href="features.php">Toggle Features</a></li>
            <li><a href="add_user.php">Add User</a></li>
            <li><a href="?logout=true">Logout</a></li>
        </ul>
    </div>
</body>

</html>