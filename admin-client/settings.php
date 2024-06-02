<?php
session_start();
include '../includes/db.php';

// Initialize variables
$site_name = '';
$h1_text = '';
$p_text = '';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $site_name = $_POST['site_name'];
    $h1_text = $_POST['h1_text'];
    $p_text = $_POST['p_text'];

    // Update settings in the database
    $sql = "UPDATE settings SET site_name='$site_name', h1_text='$h1_text', p_text='$p_text' WHERE id=1";
    $conn->query($sql);
}

// Retrieve settings from the database
$sql = "SELECT * FROM settings WHERE id=1";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    $settings = $result->fetch_assoc();
}

?>

<form method="POST" action="">
    Site Name: <input type="text" name="site_name" value="<?php echo isset($settings['site_name']) ? $settings['site_name'] : ''; ?>"><br>
    H1 Text: <input type="text" name="h1_text" value="<?php echo isset($settings['h1_text']) ? $settings['h1_text'] : ''; ?>"><br>
    P Text: <input type="text" name="p_text" value="<?php echo isset($settings['p_text']) ? $settings['p_text'] : ''; ?>"><br>
    <input type="submit" value="Save">
</form>

<a href="index.php">Back</a>