<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $student_id = $_POST['student_id'];
    $name = $_POST['name'];
    $password = $_POST['password'];

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $sql = "INSERT INTO students (student_id, name, password)
            VALUES (:student_id, :name, :password)";
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute([
            ':student_id' => $student_id,
            ':name' => $name,
            ':password' => $hashedPassword
        ]);

        header("Location: login.php");
        exit();
    } catch (PDOException $e) {
        echo "Student ID already exists!";
    }
}
?>

<form method="POST">
    <input name="student_id" placeholder="Student ID" required><br><br>
    <input name="name" placeholder="Name" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <button type="submit">Register</button>
</form>
