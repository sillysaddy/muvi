<?php
session_start();
require('dbconnect.php');

if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}

$user = $_SESSION['user'];
$userid = $user['userid'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['remove_movieid'])) {
        $movieid = $_POST['remove_movieid'];
        $sql = "DELETE FROM watchlist WHERE userid = ? AND movieid = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $userid, $movieid);
        $stmt->execute();
        $stmt->close();
    } elseif (isset($_POST['update_status_movieid']) && isset($_POST['status'])) {
        $movieid = $_POST['update_status_movieid'];
        $status = $_POST['status'];
        $sql = "UPDATE watchlist SET status = ? WHERE userid = ? AND movieid = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sii", $status, $userid, $movieid);
        $stmt->execute();
        $stmt->close();
    }
}

$sql = "SELECT movie.movieid, movie.Title, movie.Description, movie.Release_date, watchlist.date, watchlist.status 
        FROM watchlist 
        JOIN movie ON watchlist.movieid = movie.movieid 
        WHERE watchlist.userid = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userid);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Watchlist</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        @font-face {
            font-family: 'Seaford';
            src: url('Seaford.ttf') format('truetype');
        }
        body {
            font-family: 'Seaford', sans-serif;
            font-size: 18px;
            background-image: url('3.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-800">
    <div class="container mx-auto p-4">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h1 class="text-2xl font-bold mb-4">My Watchlist</h1>
            <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="py-2 px-4 border-b">Title</th>
                        <th class="py-2 px-4 border-b">Description</th>
                        <th class="py-2 px-4 border-b">Release Date</th>
                        <th class="py-2 px-4 border-b">Added Date</th>
                        <th class="py-2 px-4 border-b">Status</th>
                        <th class="py-2 px-4 border-b">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr class='hover:bg-gray-100'>";
                            echo "<td class='py-2 px-4 border-b'><a href='overview.php?movieid=" . $row['movieid'] . "' class='text-blue-500 hover:underline'>" . $row['Title'] . "</a></td>";
                            echo "<td class='py-2 px-4 border-b'>" . $row['Description'] . "</td>";
                            echo "<td class='py-2 px-4 border-b'>" . $row['Release_date'] . "</td>";
                            echo "<td class='py-2 px-4 border-b'>" . $row['date'] . "</td>";
                            echo "<td class='py-2 px-4 border-b'>
                                <form method='post' action='my_watchlist.php'>
                                    <input type='hidden' name='update_status_movieid' value='" . $row["movieid"] . "'>
                                    <select name='status' class='border rounded px-2 py-1' onchange='this.form.submit()'>
                                        <option value='unwatched'" . ($row['status'] == 'unwatched' ? ' selected' : '') . ">Unwatched</option>
                                        <option value='watched'" . ($row['status'] == 'watched' ? ' selected' : '') . ">Watched</option>
                                    </select>
                                </form>
                            </td>";
                            echo "<td class='py-2 px-4 border-b'>
                                <form method='post' action='my_watchlist.php'>
                                    <input type='hidden' name='remove_movieid' value='" . $row["movieid"] . "'>
                                    <button type='submit' class='bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600'>Remove</button>
                                </form>
                            </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6' class='py-2 px-4 border-b text-center'>No movies in your watchlist</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
            <div class="mt-4 text-right">
                <a href="dashboard.php" class="text-blue-500 hover:underline">Back to Dashboard</a>
            </div>
        </div>
    </div>
</body>
</html>