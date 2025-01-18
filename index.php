<?php
session_start();
require('dbconnect.php');
$error = "";


if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password']; 
    $loginSql = "SELECT * FROM user WHERE Mail = '$email' AND Password = '$password'";
    $result = $conn->query($loginSql);
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['user'] = $user;
        header('Location: dashboard.php');
    } else {
        $error = "Invalid login credentials!";
    }
}


if (isset($_POST['signup'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $checkUserSql = "SELECT * FROM user WHERE Mail = '$email'";
    $result = $conn->query($checkUserSql);
    if ($result->num_rows > 0) {
        $error = "User already exists!";
    } else {
        $signupSql = "INSERT INTO user (username, Mail, Password, isAdmin) VALUES ('$name', '$email', '$password', 0)";
        if ($conn->query($signupSql) === TRUE) {
            $user_id = $conn->insert_id;
            $_SESSION['user'] = ['userid' => $user_id, 'username' => $name, 'Mail' => $email];
            header('Location: index.php');
        } else {
            $error = "Error signing up: " . $conn->error;
        }
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>MUVI Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        @font-face {
            font-family: 'Seaford';
            src: url('Seaford.ttf') format('truetype');
        }
        body {
            font-family: 'Seaford', sans-serif;
            font-size: 18px;
        }
        .bg-image::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('1.jpg');
            background-size: cover;
            background-position: center;
            opacity: 0.6;
            z-index: -1;
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen bg-image">
    <div class="bg-white p-8 rounded shadow-md w-96">
        <h2 class="text-2xl font-bold mb-6 text-center">MUVI Login</h2>
        <?php if ($error): ?>
            <p class="text-red-500 mb-4"><?php echo $error; ?></p>
        <?php endif; ?>

        <?php if (!isset($_GET['action']) || $_GET['action'] != 'register'): ?>
            <form method="post" action="">
                <div class="mb-4">
                    <label for="email" class="block text-gray-700">Email:</label>
                    <input type="email" id="email" name="email" class="w-full px-3 py-2 border rounded" required>
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-gray-700">Password:</label>
                    <input type="password" id="password" name="password" class="w-full px-3 py-2 border rounded" required>
                </div>
                <div class="mb-4">
                    <input type="submit" name="login" value="Login" class="w-full bg-blue-500 text-white py-2 rounded cursor-pointer hover:bg-blue-600">
                </div>
            </form>
            <p class="text-center">Don't have an account? <a href="?action=register" class="text-blue-500">Register here</a></p>
        <?php else: ?>
            <form method="post" action="">
                <div class="mb-4">
                    <label for="name" class="block text-gray-700">Name:</label>
                    <input type="text" id="name" name="name" class="w-full px-3 py-2 border rounded" required>
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-gray-700">Email:</label>
                    <input type="email" id="email" name="email" class="w-full px-3 py-2 border rounded" required>
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-gray-700">Password:</label>
                    <input type="password" id="password" name="password" class="w-full px-3 py-2 border rounded" required>
                </div>
                <div class="mb-4">
                    <input type="submit" name="signup" value="Sign Up" class="w-full bg-blue-500 text-white py-2 rounded cursor-pointer hover:bg-blue-600">
                </div>
            </form>
            <p class="text-center">Already have an account? <a href="index.php" class="text-blue-500">Login here</a></p>
        <?php endif; ?>
    </div>
</body>
</html>