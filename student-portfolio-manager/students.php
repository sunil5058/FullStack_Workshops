<?php
require 'header.php';

if (file_exists("students.txt")) {
    $lines = file("students.txt", FILE_IGNORE_NEW_LINES);
    foreach ($lines as $line) {
        list($name, $email, $skills) = explode('|', $line);
        echo "<h3>$name</h3>";
        echo "<p>$email</p><ul>";
        foreach (explode(',', $skills) as $skill) {
            echo "<li>$skill</li>";
        }
        echo "</ul><hr>";
    }
} else {
    echo "No students found";
}

require 'footer.php';
?>
