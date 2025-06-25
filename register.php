<?php
require_once 'includes/auth.php';
redirectIfLoggedIn();
include 'components/navbar/navbar.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $role = $_POST['role'];

    $result = registerUser($username, $password, $role);

    if ($result === true) {
        header("Location: login.php");
        exit;
    } else {
        $error = $result;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Register | Attendance System</title>
    <link rel="stylesheet" href="styles/index.css">
    <link rel="stylesheet" href="styles/registerPageStyles.css"> 
  </head>
  <body class="register-body">
    <div class="register-overlay">
      <div class="register-box">
        <h1 class="register-heading">Register Account</h1>

        <?php if (isset($error)): ?>
          <p class="register-error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="POST">
          <div class="register-input-group">
            <div>
            <label for="username">Username:</label>
            </div>
            <input type="text" name="username" required>
          </div>

          <div class="register-input-group">
            <div>
            <label for="password">Password:</label>
            </div>
            <input type="password" name="password" required>
          </div>

          <div class="register-input-group">
            <div>
            <label for="role">Role:</label>
            </div>
            <select name="role" required>
              <option value="">Select Role</option>
              <option value="admin">Admin</option>
              <option value="user">User</option>
            </select>
          </div>

          <div class="register-button-group">
            <input type="submit" value="Register">
          </div>
        </form>

        <p class="register-login-link">
          Already have an account? <a href="login.php">Login here</a>
        </p>
      </div>
    </div>
  </body>
</html>