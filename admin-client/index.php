<?php
session_start();
if ($_SESSION['role'] != 'admin-client') {
    header("Location: /ticket_booking/login.php");
    exit();
}
include '../includes/db.php';

// Logout functionality
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: /ticket_booking/login.php");
    exit();
}

// Check if the bus feature and cinema feature are enabled
$sql = "SELECT bus_feature, cinema_feature FROM settings WHERE id=1";
$result = $conn->query($sql);
$settings = $result->fetch_assoc();

// Check if both bus and cinema features are enabled
if ($settings['bus_feature'] && $settings['cinema_feature']) {
    // If both features are enabled, redirect to developer admin panel
    header("Location: /ticket_booking/admin-developer/index.php");
    exit();
}

// Check if the bus feature is enabled
if ($settings['bus_feature']) {
    // If only the bus feature is enabled, display client admin panel for bus
    ?>
    <h1>Client Admin Panel (Bus)</h1>
    <ul>
        <li><a href="settings.php">Bus Settings</a></li>
        <li><a href="?logout=true">Logout</a></li>
    </ul>
    <?php
    exit();
}

// Check if the cinema feature is enabled
if ($settings['cinema_feature']) {
    // If only the cinema feature is enabled, display client admin panel for cinema
    ?>
    <h1>Client Admin Panel (Cinema)</h1>
    <ul>
        <li><a href="settings.php">Cinema Settings</a></li>
        <li><a href="?logout=true">Logout</a></li>
    </ul>
    <?php
    exit();
}

// If neither bus nor cinema feature is enabled, redirect to developer admin panel
header("Location: /ticket_booking/admin-developer/index.php");
exit();
?>
