<?php
session_start();
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password' AND role='$role'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role;
        if ($role == 'admin-developer') {
            header("Location: /ticket_booking/admin-developer/index.php");
        } else {
            header("Location: /ticket_booking/admin-client/index.php");
        }
    } else {
        echo "<div class='invalid-message'>Invalid credentials.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <form method="POST" action="">
        <h2>Login</h2>
        <label for="site_name">Username:</label>
        <input type="text" name="username" required><br>

        <label for="site_name">Password:</label>
        <input type="password" name="password" required><br>

        <select name="role">
            <option value="admin-developer">Developer Admin</option>
            <option value="admin-client">Client Admin</option>
        </select><br>
        <input type="submit" value="Login">
    </form>
</body>

</html>