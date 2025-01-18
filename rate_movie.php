<?php
session_start();
require('dbconnect.php');

if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}

$user = $_SESSION['user'];
$userid = $user['userid'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $movieid = $_POST['movieid'];
    $rating = $_POST['rating'];

    // Insert the rating into the Rating table
    $stmt = $conn->prepare("INSERT INTO Rating (UserID, MovieID, RatingValue) VALUES (?, ?, ?)");
    $stmt->bind_param("iii", $userid, $movieid, $rating);

    if ($stmt->execute()) {
        header('Location: dashboard.php');
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>