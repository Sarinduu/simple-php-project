<?php
require_once '../includes/auth.php';
requireLogin();
requireRole('user');
include '../includes/db.php';

$user_id = $_SESSION['user_id'];
$today = date('Y-m-d');

$entry_type = $_POST['entry_type'];
$start_time_only = $_POST['start_time_only'];
$end_time_only = $_POST['end_time_only'] ?? null;

$start_datetime = "$today $start_time_only:00";
$end_datetime = !empty($end_time_only) ? "$today $end_time_only:00" : null;

$stmt = $conn->prepare("INSERT INTO attendance_entries (user_id, entry_type, start_time, end_time, entry_date) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("issss", $user_id, $entry_type, $start_datetime, $end_datetime, $today);

if ($stmt->execute()) {
    header("Location: ../attendancePage.php");
    exit;
} else {
    die("Error: " . $stmt->error);
}
