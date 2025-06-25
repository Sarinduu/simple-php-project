<?php
require_once '../includes/auth.php';
requireLogin();
requireRole('user');
require_once '../includes/db.php';

$user_id = $_SESSION['user_id'];
$today = date('Y-m-d');

// Fetch the entry
if (!isset($_GET['id'])) {
    die("Missing entry ID.");
}

$id = (int) $_GET['id'];

// Get existing entry
$stmt = $conn->prepare("SELECT * FROM attendance_entries WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Entry not found.");
}

$entry = $result->fetch_assoc();

if ($entry['entry_date'] !== $today) {
    die("You cannot edit entries from past days.");
}

// Handle update submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $entry_type = $_POST['entry_type'];
    $start_time = $_POST['start_time'];
    $end_time = !empty($_POST['end_time']) ? $_POST['end_time'] : null;

    $update = $conn->prepare("UPDATE attendance_entries SET entry_type = ?, start_time = ?, end_time = ? WHERE id = ? AND user_id = ?");
    $update->bind_param("sssii", $entry_type, $start_time, $end_time, $id, $user_id);
    if ($update->execute()) {
        header("Location: attendance.php");
        exit;
    } else {
        echo "Error updating entry.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Attendance Entry</title>
  <link rel="stylesheet" href="styles/attendance.css">
</head>
<body class="attendance-body">
  <div class="attendance-container">
    <h2>Edit Attendance Entry</h2>
    <form method="POST" class="attendance-form">
      <label>Status:</label>
      <select name="entry_type" required>
        <?php
        $options = ['Login','Break','Powercut','Away','Ongoing','Idle','PC/Network Issues','Logout'];
        foreach ($options as $opt) {
            echo "<option value='$opt'" . ($entry['entry_type'] === $opt ? ' selected' : '') . ">$opt</option>";
        }
        ?>
      </select>

      <label>Start Time:</label>
      <input type="datetime-local" name="start_time" value="<?= date('Y-m-d\TH:i', strtotime($entry['start_time'])) ?>" required>

      <label>End Time (optional):</label>
      <input type="datetime-local" name="end_time" value="<?= $entry['end_time'] ? date('Y-m-d\TH:i', strtotime($entry['end_time'])) : '' ?>">

      <button type="submit">Update Entry</button>
    </form>
  </div>
</body>
</html>