<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <link rel="stylesheet" type="text/css" href="style_adminclient.css">
</head>

<body>

    <?php
    session_start();
    include '../includes/db.php';

    $site_name = '';
    $h1_text = '';
    $p_text = '';
    $message = '';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $site_name = $_POST['site_name'];
        $h1_text = $_POST['h1_text'];
        $p_text = $_POST['p_text'];

        $sql = "UPDATE settings SET site_name='$site_name', h1_text='$h1_text', p_text='$p_text' WHERE id=1";
        if ($conn->query($sql)) {
            $message = "Settings saved!";
        } else {
            $message = "Error: " . $conn->error;
        }
    }

    $sql = "SELECT * FROM settings WHERE id=1";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        $settings = $result->fetch_assoc();
    }
    ?>

    <div class="container">
        <div class="containermess">
            <?php if (!empty($message)) : ?>
                <p class="message"><?php echo $message; ?></p>
            <?php endif; ?>
        </div>
        <h1>Feature Settings</h1>
        <form method="POST" action="">
            <label for="site_name">Site Name:</label>
            <input type="text" id="site_name" name="site_name" value="<?php echo isset($settings['site_name']) ? $settings['site_name'] : ''; ?>"><br>

            <label for="h1_text">H1 Text:</label>
            <input type="text" id="h1_text" name="h1_text" value="<?php echo isset($settings['h1_text']) ? $settings['h1_text'] : ''; ?>"><br>

            <label for="p_text">P Text:</label>
            <input type="text" id="p_text" name="p_text" value="<?php echo isset($settings['p_text']) ? $settings['p_text'] : ''; ?>"><br>

            <div class="save">
                <input type="submit" value="Save">
            </div>
        </form>

        <div class="button-container">
            <a href="index.php" class="btn">Back to Admin Panel</a>
        </div>
    </div>
</body>

</html>