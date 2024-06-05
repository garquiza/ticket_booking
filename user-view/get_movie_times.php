<?php
include '../includes/db.php';

if (isset($_GET['movie_name'])) {
    $movie_name = $_GET['movie_name'];
    $sql = "SELECT DISTINCT movie_time FROM manage_movie WHERE movie_name='$movie_name'";
    $result = $conn->query($sql);

    $options = '<option value="" selected disabled>Select Time</option>';
    while ($row = $result->fetch_assoc()) {
        $options .= '<option value="' . $row['movie_time'] . '">' . $row['movie_time'] . '</option>';
    }
    echo $options;
}
