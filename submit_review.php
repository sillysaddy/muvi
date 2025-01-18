/**
 * 
 * This script starts a session and includes the database connection file.
 * @requires dbconnect.php
 */
<?php
session_start();
require('dbconnect.php');

/**
 * This script checks if a user is logged in by verifying the presence of a 'user' key in the session.
 * If the user is not logged in, it redirects them to the index page.
 * If the user is logged in, it retrieves the user information from the session.
 *
 * @file /c:/xampp/htdocs/Movie/submit_review.php
 * @redirects index.php if the user is not logged in
 * @uses $_SESSION to check for user login status and retrieve user information
 */
if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}

$user = $_SESSION['user'];
$userid = $user['userid'];


/**
 * Handles the submission of a movie review.
 * 
 * This script processes a POST request to submit a review for a movie. It expects
 * the following POST parameters:
 * - 'movieid': The ID of the movie being reviewed.
 * - 'review': The text of the review.
 * 
 * The script performs the following actions:
 * 1. Retrieves the 'movieid' and 'review' from the POST request.
 * 2. Sets the current date.
 * 3. Prepares an SQL statement to insert the review into the 'review' table.
 * 4. Binds the parameters and executes the statement.
 * 5. Redirects to 'dashboard.php' if the insertion is successful.
 * 6. Outputs an error message if the insertion fails.
 * 7. Closes the prepared statement and the database connection.
 * 
 * @file /c:/xampp/htdocs/Movie/submit_review.php
 * @method POST
 * @param int $movieid The ID of the movie being reviewed.
 * @param string $review The text of the review.
 * @param string $date The current date in 'Y-m-d' format.
 * @param int $userid The ID of the user submitting the review.
 */
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $movieid = $_POST['movieid'];
    $review = $_POST['review'];
    $date = date('Y-m-d');

    // Insert the review into the review table
    $stmt = $conn->prepare("INSERT INTO review (Date, Test, UserID, MovieID) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssii", $date, $review, $userid, $movieid);
    if ($stmt->execute()) {
        header('Location: dashboard.php');
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

$conn->close();
?>