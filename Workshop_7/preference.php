<?php
$theme = $_COOKIE['theme'] ?? 'light';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    setcookie('theme', $_POST['theme'], time() + 86400 * 30);
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Theme Preference</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="<?= $theme ?>">
<div class="container">
<h2>Select Theme</h2>
<form method="POST">
    <select name="theme">
        <option value="light">Light Mode</option>
        <option value="dark">Dark Mode</option>
    </select>
    <button type="submit">Save</button>
</form>
</div>
</body>
</html>
