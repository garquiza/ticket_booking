<?php
// Check if a session is already active before starting a new one
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include '../includes/db.php';

$sql = "SELECT * FROM settings WHERE id=1";
$result = $conn->query($sql);
$settings = $result->fetch_assoc();

if ($settings['bus_feature']) {
    include 'bus_view.php';
} elseif ($settings['cinema_feature']) {
    include 'cinema_view.php';
} else {
    echo "No feature is enabled.";
}
?>
