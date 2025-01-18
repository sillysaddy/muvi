<?php
session_start();
require('dbconnect.php');
if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}
$movieid = $_GET['movieid'];
function getMoviePoster($title) {
    $apiKey = 'bc4f9dc5a39cc94657e21f3b599465f2';
    $url = "https://api.themoviedb.org/3/search/movie?api_key=$apiKey&query=" . urlencode($title);
    
    $response = file_get_contents($url);
    if ($response === FALSE) {
        return '4.jpg';
    }
    
    $data = json_decode($response, true);
    if (isset($data['results'][0]['poster_path'])) {
        return 'https://image.tmdb.org/t/p/w500' . $data['results'][0]['poster_path'];
    } else {
        return '4.jpg';
    }
}

$stmt = $conn->prepare("SELECT Title, Description, Release_date, genre FROM movie WHERE movieid = ?");
if (!$stmt) {
    die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
}
$stmt->bind_param("i", $movieid);
$stmt->execute();
$movie = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$movie) {
    die("Movie not found.");
}

$poster_url = getMoviePoster($movie['Title']);

$stmt = $conn->prepare("SELECT AVG(RatingValue) as avg_rating FROM rating WHERE MovieID = ?");
if (!$stmt) {
    die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
}
$stmt->bind_param("i", $movieid);
$stmt->execute();
$rating_result = $stmt->get_result()->fetch_assoc();
$avg_rating = round($rating_result['avg_rating'], 2);
$stmt->close();

// Fetch user reviews
$stmt = $conn->prepare("SELECT review.Test, user.username FROM review JOIN user ON review.UserID = user.userid WHERE review.MovieID = ?");
if (!$stmt) {
    die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
}
$stmt->bind_param("i", $movieid);
$stmt->execute();
$reviews = $stmt->get_result();
$stmt->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($movie['Title']); ?> - Overview</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
         @font-face {
            font-family: 'Seaford';
            src: url('Seaford.ttf') format('truetype');
        }
        body {
            font-family: 'Seaford', sans-serif;
            font-size: 18px;
            background-image: url('5.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-800">
    <div class="container mx-auto p-4">
        <div class="bg-white shadow-lg rounded-lg p-6">
            <div class="flex flex-col md:flex-row">
                <img src="<?php echo htmlspecialchars($poster_url); ?>" alt="Poster" class="w-full md:w-1/3 rounded-lg shadow-md mb-4 md:mb-0">
                <div class="md:ml-6">
                    <h1 class="text-3xl font-bold mb-4"><?php echo htmlspecialchars($movie['Title']); ?></h1>
                    <p class="text-lg mb-4"><?php echo htmlspecialchars($movie['Description']); ?></p>
                    <p class="text-md mb-4"><strong>Release Date:</strong> <?php echo htmlspecialchars($movie['Release_date']); ?></p>
                    <p class="text-md mb-4"><strong>Genre:</strong> <?php echo htmlspecialchars($movie['genre']); ?></p>
                    <p class="text-md mb-4"><strong>Average Rating:</strong> <span class="text-yellow-500"><?php echo htmlspecialchars($avg_rating); ?> ⭐</span></p>
                </div>
            </div>
            <h2 class="text-2xl font-bold mb-4 mt-6">Reviews</h2>
            <?php while ($review = $reviews->fetch_assoc()): ?>
                <div class="mb-4 p-4 bg-gray-50 rounded-lg shadow-sm">
                    <div class="flex items-center mb-2">
                        <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center text-gray-600 font-bold">
                            <?php echo strtoupper(substr(htmlspecialchars($review['username']), 0, 1)); ?>
                        </div>
                        <div class="ml-3">
                            <p class="text-md font-semibold"><?php echo htmlspecialchars($review['username']); ?></p>
                            <p class="text-sm text-gray-600">[REVIEW]</p>
                        </div>
                    </div>
                    <p class="text-md mb-2"><?php echo htmlspecialchars($review['Test']); ?></p>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>