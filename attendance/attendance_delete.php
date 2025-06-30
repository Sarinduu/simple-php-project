<?php
require_once '../includes/auth.php';
requireLogin();
requireRole('user');
require_once '../includes/db.php';

$user_id = $_SESSION['user_id'];
$today = date('Y-m-d');

if (!isset($_GET['delete'])) {
    die("Missing ID.");
}

$id = (int) $_GET['delete'];

// Check if entry belongs to user and is editable
$stmt = $conn->prepare("SELECT * FROM attendance_entries WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Entry not found.");
}

$entry = $result->fetch_assoc();

if ($entry['entry_date'] !== $today) {
    die("You can only delete entries from today.");
}

$del = $conn->prepare("DELETE FROM attendance_entries WHERE id = ? AND user_id = ?");
$del->bind_param("ii", $id, $user_id);
if ($del->execute()) {
    header("Location: ../attendancePage.php");
    exit;
} else {
    echo "Failed to delete entry.";
}
