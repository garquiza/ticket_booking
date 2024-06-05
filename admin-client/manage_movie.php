<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Movie</title>
    <link rel="stylesheet" type="text/css" href="style_adminclient.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
        $movie_times = $_POST['movie_time'];

        if (is_array($movie_times)) {
            foreach ($movie_times as $movie_time) {
                $sql = "INSERT INTO manage_movie (movie_name, movie_time) VALUES ('$movie_name', '$movie_time')";
                if ($conn->query($sql)) {
                    $message = "Added successfully!";
                } else {
                    $message = "Error: " . $conn->error;
                    break;
                }
            }
        } else {
            $message = "Invalid movie times.";
        }
    }

    $sql = "SELECT movie_name, GROUP_CONCAT(movie_time ORDER BY movie_time SEPARATOR ', ') AS movie_times FROM manage_movie GROUP BY movie_name";
    $result = $conn->query($sql);
    ?>

    <div class="container">
        <h1>Manage Cinema</h1>
        <?php if (!empty($message)) : ?>
            <p class="message" style="text-align: center;"><?php echo $message; ?></p>
        <?php endif; ?>
        <form method="POST" action="">
            <label for="movie_name">Movie Name: </label>
            <input type="text" id="movie_name" name="movie_name" required><br>

            <div id="movie_times_container">
                <div class="movie_time_input">
                    <label for="movie_time">Movie Time: </label>
                    <input type="time" class="movie_time" name="movie_time[]" required>
                    <button type="button" class="remove_time_button"> Remove</button>
                </div>
            </div>
            <br>
            <button type="button" id="add_time_button" class="btn">Add Another Time</button>
            <br><br>
            <input type="submit" value="Add">
        </form>

        <h2 style="text-align: center;">Database</h2>
        <table>
            <tr>
                <th>Movie Name</th>
                <th>Movie Time</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo $row['movie_name']; ?></td>
                    <td><?php echo $row['movie_times']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>

        <div class="button-container">
            <a href="index.php" class="btn">Back to Admin Panel</a>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#add_time_button").click(function() {
                var newTimeInput = '<div class="movie_time_input"><label for="movie_time">Movie Time: </label><input type="time" class="movie_time" name="movie_time[]" required> <button type="button" class="remove_time_button">Remove</button></div>';
                $("#movie_times_container").append(newTimeInput);
            });

            $(document).on('click', '.remove_time_button', function() {
                $(this).closest('.movie_time_input').remove();
            });
        });
    </script>
</body>

</html>