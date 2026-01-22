<?php
session_start();
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $student_id = $_POST['student_id'];
    $password = $_POST['password'];

    $sql = "SELECT password FROM students WHERE student_id = :student_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':student_id' => $student_id]);

    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['logged_in'] = true;
        $_SESSION['student_id'] = $student_id;

        header("Location: dashboard.php");
        exit();
    } else {
        echo "Invalid login credentials";
    }
}
?>

<form method="POST">
    <input name="student_id" placeholder="Student ID" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <button type="submit">Login</button>
</form>
