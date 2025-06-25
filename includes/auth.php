<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'db.php';

// Log in a user
function loginUser($username, $password) {
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 1) {
        $user = $res->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user['username'];
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            return $user['role'];
        }
    }

    return false;
}

// Register a new user
function registerUser($username, $password, $role) {
    global $conn;

    $allowed_roles = ['admin', 'user'];
    if (!in_array($role, $allowed_roles)) {
        return "Invalid role selected.";
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if username already exists
    $checkStmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $checkStmt->bind_param("s", $username);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        return "Username already exists.";
    }

    // Insert new user
    $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $hashed_password, $role);

    if ($stmt->execute()) {
        return true;
    } else {
        return "Registration failed: " . $stmt->error;
    }
}

// Check if user is logged in.
function isLoggedIn() {
    return isset($_SESSION['user']);
}

// If already logged in, redirect based on role
function redirectIfLoggedIn() {
    if (isLoggedIn() && isset($_SESSION['role'])) {
        if ($_SESSION['role'] === 'admin') {
            header("Location: dashboard.php");
            exit;
        } elseif ($_SESSION['role'] === 'user') {
            header("Location: attendancePage.php");
            exit;
        }
    }
}

// Redirects to login page if not logged in.
function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: login.php");
        exit();
    }
}

// Blocks access if role doesn't match.
function requireRole($requiredRole) {
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== $requiredRole) {
        echo "<h2 style='color:red;'>Access Denied: Insufficient Permissions</h2>";
        exit();
    }
}

// Log out the user and destroy the session.
function logoutUser() {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}