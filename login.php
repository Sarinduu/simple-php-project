<?php
require_once 'includes/auth.php';
redirectIfLoggedIn();
include 'components/navbar/navbar.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $role = loginUser($username, $password);
    if ($role === 'admin') {
        header("Location: dashboard.php");
        exit;
    } elseif ($role === 'user') {
        header("Location: attendancePage.php");
        exit;
    } else {
        $error = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login | Attendance System</title>
  <link rel="stylesheet" href="styles/index.css">
  <link rel="stylesheet" href="styles/loginPageStyles.css" /> 
</head>
<body class="login-body">
  <div class="login-overlay">
    <div class="login-box">
      <h1 class="login-heading">Login to Your Account</h1>

      <?php if (isset($error)): ?>
        <p class="login-error"><?= htmlspecialchars($error) ?></p>
      <?php endif; ?>

      <form method="POST">
        <div class="login-input-group">
          <label for="username">Username:</label>
          <input type="text" name="username" required>
        </div>
        <div class="login-input-group">
          <label for="password">Password:</label>
          <input type="password" name="password" required>
        </div>
        <div class="login-button-group">
          <input type="submit" value="Login">
        </div>
      </form>

      <p class="login-register-link">
        Don't have an account? <a href="register.php">Register here</a>
      </p>
    </div>
  </div>
</body>
</html>

