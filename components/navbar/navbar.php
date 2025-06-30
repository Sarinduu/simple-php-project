<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
?>
<!-- NAVBAR STYLES -->
<link rel="stylesheet" href="components/navbar/navbarStyles.css">

<div class="navbar">
  <div class="nav-left">
    <a href="index.php" class="logo-link">
      <img src="assets/logos/logo.jpg" alt="Logo" class="nav-logo">
      <h2 class="brand">Innodata</h2>
    </a>
  </div>

  <div class="nav-right">
    <?php if (isset($_SESSION['user'])): ?>
      <div class="user-menu">
        <span class="welcome-msg">Welcome <?= htmlspecialchars($_SESSION['user']) ?></span>
        <div class="dropdown">
          <img src="assets/icons/user-icon.png" alt="User Icon" class="user-icon" onclick="toggleDropdown()" />

          <div id="logoutDropdown" class="dropdown-content">
            <?php if ($_SESSION['role'] === 'admin'): ?>
              <div class="role-label">Admin Account</div>
            <?php elseif ($_SESSION['role'] === 'user'): ?>
              <div class="role-label">User Account</div>
            <?php endif; ?>
            <form action="logout.php" method="post">
              <button type="submit" class="logout-btn">Logout</button>
            </form>
          </div>
        </div>
      </div>
    <?php else: ?>
      <a href="login.php">Login</a>
      <a href="register.php">Register</a>
    <?php endif; ?>
  </div>
</div>


<!-- NAVBAR SCRIPT -->
<script src="components/navbar/navbarScripts.js"></script>