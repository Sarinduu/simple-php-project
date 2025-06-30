<?php
require_once '../includes/auth.php';
requireLogin();
requireRole('user');
include '../includes/db.php';

if (!isset($_POST['entry_id'], $_POST['entry_type'], $_POST['start_time'])) {
    die("Missing required fields.");
}

$id = (int) $_POST['entry_id'];
$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT * FROM attendance_entries WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Invalid entry.");
}

$entry = $result->fetch_assoc();
$today = date('Y-m-d');

if ($entry['entry_date'] !== $today) {
    die("Cannot edit past entries.");
}

$entry_type = $_POST['entry_type'];
$start_time_input = $_POST['start_time'];
$end_time_input = $_POST['end_time'] ?? '';

$start_time = $today . ' ' . $start_time_input;
$end_time = !empty($end_time_input) ? $today . ' ' . $end_time_input : null;

$update = $conn->prepare("UPDATE attendance_entries SET entry_type = ?, start_time = ?, end_time = ? WHERE id = ? AND user_id = ?");
$update->bind_param("sssii", $entry_type, $start_time, $end_time, $id, $user_id);

if ($update->execute()) {
    header("Location: ../attendancePage.php");
    exit;
} else {
    error_log("Update error: " . $update->error);
    echo "Error updating entry.";
}
