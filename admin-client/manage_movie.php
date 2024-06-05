<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Movie</title>
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

    $message = '';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $movie_name = $_POST['movie_name'];
        $movie_time = $_POST['movie_time'];

        $sql = "INSERT INTO manage_movie (movie_name, movie_time) VALUES ('$movie_name', '$movie_time')";
        if ($conn->query($sql)) {
            $message = "Movie time added successfully!";
        } else {
            $message = "Error: " . $conn->error;
        }
    }

    $sql = "SELECT * FROM manage_movie";
    $result = $conn->query($sql);
    ?>

    <div class="container">
        <h1>Manage Movie</h1>
        <?php if (!empty($message)) : ?>
            <p class="message"><?php echo $message; ?></p>
        <?php endif; ?>
        <form method="POST" action="">
            <label for="movie_name">Movie Name:</label>
            <input type="text" id="movie_name" name="movie_name" required><br>

            <label for="movie_time">Movie Time:</label>
            <input type="time" id="movie_time" name="movie_time" required><br>

            <input type="submit" value="Add Movie Time">
        </form>

        <h2>Existing Movie Times</h2>
        <table>
            <tr>
                <th>Movie Name</th>
                <th>Movie Time</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo $row['movie_name']; ?></td>
                    <td><?php echo $row['movie_time']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>

</html>