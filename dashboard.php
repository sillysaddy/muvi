<?php
session_start();
require('dbconnect.php');

if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}

$user = $_SESSION['user'];
$userid = $user['userid'];

$sort = isset($_GET['sort']) ? $_GET['sort'] : 'title';
$order = isset($_GET['order']) ? $_GET['order'] : 'asc';
$genreFilter = isset($_GET['genre']) ? $_GET['genre'] : '';
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

$validSortColumns = ['title', 'release_date'];
$sort = in_array($sort, $validSortColumns) ? $sort : 'title';
$order = $order === 'desc' ? 'desc' : 'asc';

$query = "SELECT Title, Description, Genre, Release_date, movieid FROM movie WHERE 1=1";
if ($genreFilter) {
    $query .= " AND Genre = '" . $conn->real_escape_string($genreFilter) . "'";
}
if ($searchTerm) {
    $query .= " AND (Title LIKE '%" . $conn->real_escape_string($searchTerm) . "%' OR Description LIKE '%" . $conn->real_escape_string($searchTerm) . "%')";
}
$query .= " ORDER BY $sort $order";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>MUVI Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function toggleDropdown(movieId) {
            var dropdown = document.getElementById('dropdown-' + movieId);
            if (dropdown.style.display === 'none' || dropdown.style.display === '') {
                dropdown.style.display = 'block';
            } else {
                dropdown.style.display = 'none';
            }
        }
        function toggleReviewForm(movieId) {
            var reviewForm = document.getElementById('review-form-' + movieId);
            if (reviewForm.style.display === 'none' || reviewForm.style.display === '') {
                reviewForm.style.display = 'block';
            } else {
                reviewForm.style.display = 'none';
            }
        }
        function addToWatchlist(movieId) {
            var formData = new FormData();
            formData.append('movieid', movieId);

            fetch('add_to_watchlist.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: data.message
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: data.message
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!'
                });
            });
        }
    </script>
    <style>
        @font-face {
            font-family: 'Seaford';
            src: url('Seaford.ttf') format('truetype');
        }
        body {
            font-family: 'Seaford', sans-serif;
            font-size: 18px;
            background-image: url('2.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-800">
    <div class="container mx-auto p-4">
        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-bold">Welcome, <?php echo $user['username']; ?> to MUVI</h1>
            </div>
            <p class="mb-4">You are welcome to check what movies are available on our website. You can review them, read other people's thoughts about them, and give them your own ratings. You can also create your own watchlist!</p>

            <form method="GET" class="mb-4">
                <div class="flex items-center mb-4">
                    <label for="search" class="mr-2">Search:</label>
                    <input type="text" name="search" id="search" value="<?php echo htmlspecialchars($searchTerm); ?>" class="border rounded px-2 py-1 mr-4">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mr-4">Search</button>
                    <label for="genre" class="mr-2">Filter by Genre:</label>
                    <select name="genre" id="genre" onchange="this.form.submit()" class="border rounded px-2 py-1">
                        <option value="">All</option>
                        <?php
                        $genres = $conn->query("SELECT DISTINCT Genre FROM movie");
                        while ($genre = $genres->fetch_assoc()) {
                            $selected = ($genreFilter == $genre['Genre']) ? 'selected' : '';
                            echo "<option value='" . $genre['Genre'] . "' $selected>" . $genre['Genre'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
            </form>

            <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="py-2 px-4 border-b">
                            <a href="?sort=title&order=<?php echo $sort == 'title' && $order == 'asc' ? 'desc' : 'asc'; ?>&genre=<?php echo urlencode($genreFilter); ?>&search=<?php echo urlencode($searchTerm); ?>">
                                Title <?php if ($sort == 'title') echo $order == 'asc' ? '▲' : '▼'; ?>
                            </a>
                        </th>
                        <th class="py-2 px-4 border-b">Description</th>
                        <th class="py-2 px-4 border-b">Genre</th>
                        <th class="py-2 px-4 border-b">
                            <a href="?sort=release_date&order=<?php echo $sort == 'release_date' && $order == 'asc' ? 'desc' : 'asc'; ?>&genre=<?php echo urlencode($genreFilter); ?>&search=<?php echo urlencode($searchTerm); ?>">
                                Release Date <?php if ($sort == 'release_date') echo $order == 'asc' ? '▲' : '▼'; ?>
                            </a>
                        </th>
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
                            echo "<td class='py-2 px-4 border-b'>" . $row['Genre'] . "</td>";
                            echo "<td class='py-2 px-4 border-b'>" . $row['Release_date'] . "</td>";
                            echo "<td class='py-2 px-4 border-b'>
                            <button onclick='toggleDropdown(" . $row["movieid"] . ")' class='bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600'>Rate</button>
                            <div id='dropdown-" . $row["movieid"] . "' style='display: none;'>
                                <form method='post' action='rate_movie.php'>
                                    <input type='hidden' name='movieid' value='" . $row["movieid"] . "'>
                                    <select name='rating' class='border rounded px-2 py-1'>
                                        <option value='1'>⭐</option>
                                        <option value='2'>⭐⭐</option>
                                        <option value='3'>⭐⭐⭐</option>
                                        <option value='4'>⭐⭐⭐⭐</option>
                                        <option value='5'>⭐⭐⭐⭐⭐</option>
                                    </select>
                                    <button type='submit' class='bg-green-500 text-white px-2 py-1 rounded hover:bg-green-600'>Submit</button>
                                </form>
                            </div>
                            <button onclick='toggleReviewForm(" . $row["movieid"] . ")' class='bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-600'>Review</button>
                            <div id='review-form-" . $row["movieid"] . "' style='display: none;'>
                                <form method='post' action='submit_review.php'>
                                    <input type='hidden' name='movieid' value='" . $row["movieid"] . "'>
                                    <textarea name='review' class='border rounded px-2 py-1' rows='3'></textarea>
                                    <button type='submit' class='bg-green-500 text-white px-2 py-1 rounded hover:bg-green-600'>Submit</button>
                                </form>
                            </div>
                            <button onclick='addToWatchlist(" . $row["movieid"] . ")' class='bg-purple-500 text-white px-2 py-1 rounded hover:bg-purple-600'>Add to Watchlist</button>
                            </td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="flex justify-between mt-4">
            <a href="my_watchlist.php" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">See my Watchlist</a>
            <a href="logout.php" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Logout</a>
        </div>
    </div>
</body>
</html>