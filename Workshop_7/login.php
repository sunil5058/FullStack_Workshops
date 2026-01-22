<?php
session_start();
require 'db.php';
$theme = $_COOKIE['theme'] ?? 'light';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $stmt = $pdo->prepare(
        "SELECT * FROM students WHERE student_id = :student_id"
    );
    $stmt->execute([':student_id' => $_POST['student_id']]);
    $user = $stmt->fetch();

    if ($user && password_verify($_POST['password'], $user['password'])) {
        $_SESSION['logged_in'] = true;
        $_SESSION['student_id'] = $user['student_id'];
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Invalid credentials!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="<?= $theme ?>">
<div class="container">
<h2>Login</h2>
<form method="POST">
    <input name="student_id" placeholder="Student ID" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
</form>
</div>
</body>
</html>
