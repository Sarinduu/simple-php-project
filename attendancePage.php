<?php
require_once 'includes/auth.php';
requireLogin();
requireRole('user');
include 'components/navbar/navbar.php';
include 'includes/db.php';
require_once 'attendance/attendance_functions.php';

$user_id = $_SESSION['user_id'];
$today = date('Y-m-d');
$entries_by_date = getAllAttendanceEntriesGroupedByDate($conn, $user_id);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>My Attendance</title>
  <link rel="stylesheet" href="styles/index.css">
  <link rel="stylesheet" href="styles/attendancePageStyles.css">
</head>

<body class="attendance-body">
  <div class="attendance-container">
    <h2 class="attendance-title">My Attendance Entries</h2>
    <div class="add-entry-btn-container">
      <button class="add-entry-btn" onclick="document.getElementById('addModal').style.display='flex'">Add New Entry</button>
    </div>


    <!-- Add Modal -->
    <div class="modal-overlay" id="addModal">
      <div class="modal-content">
        <form id="attendanceForm" method="POST" action="attendance/attendance_add.php">
          <button type="button" class="close-btn" onclick="document.getElementById('addModal').style.display='none'">X</button>
          <h3>Add Attendance Entry</h3>

          <label>Status:</label>
          <select name="entry_type" id="entry_type_select" onchange="handleStatusChange()" required>
            <option value="">-- Select Status --</option>
            <?php
            $options = ['Login', 'Break', 'Powercut', 'Away', 'Ongoing', 'Idle', 'PC/Network Issues', 'Logout'];
            foreach ($options as $opt) {
              echo "<option value='$opt'>$opt</option>";
            }
            ?>
          </select>

          <label>Start Time:</label>
          <input type="time" name="start_time_only" required>

          <div id="end_time_group">
            <label>End Time (optional):</label>
            <input type="time" name="end_time_only">
          </div>

          <button type="submit">Submit</button>
        </form>
      </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal-overlay" id="editModal">
      <div class="modal-content">
        <form id="editForm" method="POST" action="attendance/attendance_edit.php">
          <button type="button" class="close-btn" onclick="document.getElementById('editModal').style.display='none'">X</button>
          <h3>Edit Attendance Entry</h3>

          <input type="hidden" name="entry_id" id="edit_entry_id" />

          <label>Status:</label>
          <select name="entry_type" id="edit_entry_type" required>
            <?php
            $options = ['Login', 'Break', 'Powercut', 'Away', 'Ongoing', 'Idle', 'PC/Network Issues', 'Logout'];
            foreach ($options as $opt) {
              echo "<option value='$opt'>$opt</option>";
            }
            ?>
          </select>

          <label>Start Time:</label>
          <input type="time" name="start_time" id="edit_start_time" required>

          <label>End Time (optional):</label>
          <input type="time" name="end_time" id="edit_end_time" />

          <button type="submit">Update</button>
        </form>
      </div>
    </div>

    <!-- Attendance Entries Display -->
    <?php if (empty($entries_by_date)): ?>
      <p>No attendance records found.</p>
    <?php else: ?>
      <?php foreach ($entries_by_date as $date => $dayEntries): ?>
        <div class="date-group">
          <h3 class="date-heading"><?= htmlspecialchars($date) ?></h3>
          <table class="styled-attendance-table">
            <thead>
              <tr>
                <th>Status</th>
                <th>Time</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($dayEntries as $e): ?>
                <tr>
                  <td><?= htmlspecialchars($e['entry_type']) ?></td>
                  <td>
                    <?= date('H:i', strtotime($e['start_time'])) ?>
                    <?= $e['end_time'] ? ' - ' . date('H:i', strtotime($e['end_time'])) : '' ?>
                  </td>
                  <td>
                    <?php if ($date === $today): ?>
                      <a href="#" class="btn-link edit-link" onclick="openEditModal(<?= $e['id'] ?>,'<?= htmlspecialchars($e['entry_type'], ENT_QUOTES) ?>','<?= date('Y-m-d\TH:i', strtotime($e['start_time'])) ?>','<?= $e['end_time'] ? date('Y-m-d\TH:i', strtotime($e['end_time'])) : '' ?>')">Edit</a>
                      <span class="divider">|</span>
                      <a href="attendance/attendance_delete.php?delete=<?= $e['id'] ?>" class="btn-link delete-link" onclick="return confirm('Delete this entry?')">Delete</a>
                    <?php else: ?>
                      <span class="locked-text">Locked</span>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>

  <script src="scripts/attendancePageScripts.js"></script>
</body>

</html>