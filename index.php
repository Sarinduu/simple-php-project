<?php
require_once 'includes/auth.php';
redirectIfLoggedIn();
include 'components/navbar/navbar.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Welcome | Daily Attendance System</title>
  <link rel="icon" href="favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="styles/index.css">
  <link rel="stylesheet" href="styles/welcomePageStyles.css">
</head>

<body class="welcome-body">
  <div class="welcome-overlay">
    <div class="welcome-box">
      <div>
        <img src="assets/logos/logo.jpg" alt="Company Logo" class="logo" />
        <h1 class="company-name">Innodata</h1>
      </div>
      <h2 class="system-title">Daily Attendance Management System</h2>

      <p class="intro-text">
        Welcome to our secure attendance management portal for Innodata employees.
        <br />
        Please log in to mark your attendance or manage.
      </p>

      <a href="login.php" class="login-btn">Log In to Continue</a>
    </div>
  </div>
</body>

</html>