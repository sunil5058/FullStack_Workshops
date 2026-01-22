<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
    exit();
}
$theme = $_COOKIE['theme'] ?? 'light';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="<?= $theme ?>">
<div class="container">
<h2>Welcome, <?= $_SESSION['student_id'] ?></h2>
<nav>
    <a href="dashboard.php">Dashboard</a>
    <a href="preference.php">Theme</a>
    <a href="logout.php">Logout</a>
</nav>
<p>You are logged in successfully.</p>
</div>
</body>
</html>
