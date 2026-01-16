<?php
require 'header.php';
require 'functions.php';

$msg = "";
$class = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['skills']))
            throw new Exception("All fields required");

        if (!validateEmail($_POST['email']))
            throw new Exception("Invalid email");

        saveStudent(
            formatName($_POST['name']),
            $_POST['email'],
            cleanSkills($_POST['skills'])
        );

        $msg = "Student saved successfully";
        $class = "success";
    } catch (Exception $e) {
        $msg = $e->getMessage();
        $class = "error";
    }
}
?>

<h2>Add Student</h2>
<p class="message <?= $class ?>"><?= $msg ?></p>

<form method="post">
    <label>Name</label>
    <input type="text" name="name">

    <label>Email</label>
    <input type="email" name="email">

    <label>Skills</label>
    <input type="text" name="skills">

    <button>Save</button>
</form>

<?php require 'footer.php'; ?>
