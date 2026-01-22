<?php
require 'db.php';
$theme = $_COOKIE['theme'] ?? 'light';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $student_id = $_POST['student_id'];
    $name = $_POST['name'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $stmt = $pdo->prepare(
        "INSERT INTO students (student_id, name, password)
         VALUES (:student_id, :name, :password)"
    );

    try {
        $stmt->execute([
            ':student_id' => $student_id,
            ':name' => $name,
            ':password' => $password
        ]);
        header("Location: login.php");
        exit();
    } catch (PDOException $e) {
        echo "Student ID already exists!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="<?= $theme ?>">
<div class="container">
<h2>Register</h2>
<form method="POST">
    <input name="student_id" placeholder="Student ID" required>
    <input name="name" placeholder="Name" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Register</button>
</form>
</div>
</body>
</html>
