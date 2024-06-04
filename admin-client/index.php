<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Client</title>
    <link rel="stylesheet" type="text/css" href="style_adminclient.css">
</head>

<body>

    <?php
    session_start();
    if ($_SESSION['role'] != 'admin-client') {
        header("Location: /ticket_booking/login.php");
        exit();
    }
    include '../includes/db.php';

    if (isset($_GET['logout'])) {
        session_destroy();
        header("Location: /ticket_booking/login.php");
        exit();
    }

    $sql = "SELECT bus_feature, cinema_feature FROM settings WHERE id=1";
    $result = $conn->query($sql);
    $settings = $result->fetch_assoc();

    if ($settings['bus_feature'] && $settings['cinema_feature']) {
        header("Location: /ticket_booking/admin-developer/index.php");
        exit();
    }

    if ($settings['bus_feature']) {
    ?>
        <div class="container_bus">
            <h1>Client Admin Panel (Bus)</h1>
            <div class="button-container">
                <a href="settings.php" class="btn">Bus Settings</a>
            </div>
            <div class="button-container">
                <a href="?logout=true" class="btn logout-btn">Logout</a>
            </div>
        </div>
    <?php
        exit();
    }

    if ($settings['cinema_feature']) {
    ?>
        <div class="container_cinema">
            <h1>Client Admin Panel (Cinema)</h1>
            <div class="button-container">
                <a href="settings.php" class="btn">Cinema Settings</a>
            </div>
            <div class="button-container">
                <a href="?logout=true" class="btn logout-btn">Logout</a>
            </div>
        </div>
    <?php
        exit();
    }

    header("Location: /ticket_booking/admin-developer/index.php");
    exit();
    ?>

</body>

</html>