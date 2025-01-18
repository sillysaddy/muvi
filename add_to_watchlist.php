<?php
session_start();
require('dbconnect.php');

header('Content-Type: application/json');

if (!isset($_SESSION['user'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit();
}

$user = $_SESSION['user'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $movieid = $_POST['movieid'];
    $userid = $user['userid'];
    $date = date('Y-m-d');
    $status = 'unwatched';

    // Check if the movie is already in the watchlist
    $check_sql = "SELECT * FROM watchlist WHERE userid = ? AND movieid = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("ii", $userid, $movieid);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        echo json_encode(['status' => 'error', 'message' => 'This film is already in your watchlist']);
    } else {
        $sql = "INSERT INTO watchlist (userid, movieid, date, status) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiss", $userid, $movieid, $date, $status);

        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Added to your watchlist']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to add to watchlist']);
        }

        $stmt->close();
    }

    $check_stmt->close();
}

$conn->close();
?>

