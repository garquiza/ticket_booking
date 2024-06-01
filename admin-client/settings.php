<?php
session_start();
if ($_SESSION['role'] != 'admin-client') {
    header("Location: /ticket_booking/login.php");
    exit();
}
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $logo = $_POST['logo'];
    $color = $_POST['color'];
    $footer_text = $_POST['footer_text'];
    $site_name = $_POST['site_name'];

    $sql = "UPDATE settings SET logo='$logo', color='$color', footer_text='$footer_text', site_name='$site_name' WHERE id=1";
    $conn->query($sql);
}

$sql = "SELECT * FROM settings WHERE id=1";
$result = $conn->query($sql);
$settings = $result->fetch_assoc();
?>

<form method="POST" action="">
    Logo URL: <input type="text" name="logo" value="<?php echo $settings['logo']; ?>"><br>
    Color: <input type="text" name="color" value="<?php echo $settings['color']; ?>"><br>
    Footer Text: <input type="text" name="footer_text" value="<?php echo $settings['footer_text']; ?>"><br>
    Site Name: <input type="text" name="site_name" value="<?php echo $settings['site_name']; ?>"><br>
    <input type="submit" value="Save">
</form>

<a href="index.php">Back</a>