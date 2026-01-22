<?php

ini_set("display_errors", 0);
ini_set("log_errors",1);

ini_set("error_log", __DIR__ . '/error.log');


// Database connection
$host = 'localhost';
$dbname = 'tutorial10';
$username = 'root';
$password = '';

try {
  $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
  die("Database connection failed: " . $e->getMessage());
}


session_set_cookie_params([

  "httponly" =>true,
  "secure" =>false,
  "samesite" => true

]);

session_start();

if (!isset($_SESSION['csrf_token'])) {


   $csrf_token = bin2hex(random_bytes(32));
   $_SESSION['csrf_token'] = $csrf_token;
}

$error = '';
$success = '';

// Handle form submission

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  if(isset($_POST['csrf_token']) && isset($_SESSION['csrf_token']) && hash_equal($_POST['csrf_token'],$_SESSION['csrf_token'])){

    // If not, set error message and skip processing

  if (isset($_POST['username'])) {
    try {

      if(empty($username)){
        throw new InvalidArgumentException("Username cannot be empty");
      }
      
      if(!preg_match('/^[a-zA-Z0-9_]+$/', $_POST['username'])){
        throw new InvalidArgumentException("Username must have only underscore or alphanumeric characters");
      }

      $username = $_POST['username'];

      $query = "SELECT * FROM users WHERE username = ?";
      $result = $pdo->prepare($query);
      $result->execute([$username]);
      $user = $result->fetch(PDO::FETCH_ASSOC);

      if ($user) {
        session_regenerate_id(true);

        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $user['username'];

        $success = "Login successful! Welcome " . htmlspecialchars($user['username']);

      } else {
        $error = "Invalid username";
      }

    } catch (InvalidArgumentException $e) {
      $error = $e->getMessage();
    } catch (Exception $e) {
      $error = "An error occurred.";
      error_log(json_encode([
        "message"=>$e->getMessage(),
        "line"=>$e->getLine()
      ]));
    }
  }

  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Security Essesntials</title>
  <style>
    body {
      margin: 50px auto;
      padding: 20px;
    }

    .error {
      color: red;
      margin: 10px 0;
    }

    .success {
      color: green;
      margin: 10px 0;
    }

    input,
    button {
      width: 100%;
      padding: 8px;
      margin: 5px 0;
    }
  </style>
</head>

<body>
  <div class="container">
    <h1>Login Practice</h1>

    <?php if ($error): ?>
      <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
      <div class="success"><?php echo $success; ?></div>
    <?php endif; ?>

    <?php if (isset($_SESSION['logged_in'])): ?>
      <p><strong>Session Info:</strong><br>
        Session ID: <?php echo session_id(); ?><br>
        Username: <?php echo htmlspecialchars($_SESSION['username']); ?><br>
        <a href="?logout=1">Logout</a>
      </p>
    <?php else: ?>
      <form method="POST" action="">
        <!--Add CSRF token as hidden input field -->
        <label>Username:</label>
        <input type="text" name="username" required
          value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">

        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'])?>">

        <button type="submit">Login</button>
      </form>
    <?php endif; ?>
  </div>
</body>

</html>

<?php
// Handle logout
if (isset($_GET['logout'])) {
  session_destroy();
  header('Location: login.php');
  exit;
}
?>