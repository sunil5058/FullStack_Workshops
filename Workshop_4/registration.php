<?php
$name = $email = "";
$nameErr = $emailErr = $passwordErr = $confirmPasswordErr = "";
$successMsg = $fileErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
    } else {
        $name = $_POST["name"];
    }

    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
    } else {
        $email = $_POST["email"];
    }

    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
    } elseif (strlen($_POST["password"]) < 8 || !preg_match("/[@#$%^&*!]/", $_POST["password"])) {
        $passwordErr = "Password must be at least 8 characters and include a special character";
    }

    if (empty($_POST["confirm_password"])) {
        $confirmPasswordErr = "Confirm password is required";
    } elseif ($_POST["password"] !== $_POST["confirm_password"]) {
        $confirmPasswordErr = "Passwords do not match";
    }

    if (empty($nameErr) && empty($emailErr) && empty($passwordErr) && empty($confirmPasswordErr)) {

        $file = "users.json";
        $data = file_get_contents($file);

        if ($data === false) {
            $fileErr = "Error reading file";
        } else {
            $users = json_decode($data, true);

            if ($users === null) {
                $users = [];
            }

            // Check if email already exists
            $emailExists = false;
            foreach ($users as $user) {
                if ($user["email"] === $email) {
                    $emailExists = true;
                    break;
                }
            }

            if ($emailExists) {
                $emailErr = "This email is already registered";
            } else {
                $users[] = [
                    "name" => $name,
                    "email" => $email,
                    "password" => password_hash($_POST["password"], PASSWORD_DEFAULT)
                ];

                if (file_put_contents($file, json_encode($users, JSON_PRETTY_PRINT))) {
                    $successMsg = "Registration successful";
                    $name = $email = "";
                } else {
                    $fileErr = "Error writing file";
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registration</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>User Registration</h2>

<?php if ($successMsg): ?>
    <div class="success"><?php echo $successMsg; ?></div>
<?php endif; ?>

<?php if ($fileErr): ?>
    <div class="error"><?php echo $fileErr; ?></div>
<?php endif; ?>

<form method="post">

    <label for="name">Name:</label>
    <input type="text" id="name" name="name" value="<?php echo $name; ?>">
    <span class="error"><?php echo $nameErr; ?></span><br><br>

    <label for="email">Email:</label>
    <input type="text" id="email" name="email" value="<?php echo $email; ?>">
    <span class="error"><?php echo $emailErr; ?></span><br><br>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password">
    <span class="error"><?php echo $passwordErr; ?></span><br><br>

    <label for="confirm_password">Confirm Password:</label>
    <input type="password" id="confirm_password" name="confirm_password">
    <span class="error"><?php echo $confirmPasswordErr; ?></span><br><br>

    <input type="submit" value="Register">

</form>

</body>
</html>
