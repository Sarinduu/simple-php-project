<?php
require_once './includes/auth.php';
requireLogin();
requireRole('admin');
include 'components/navbar/navbar.php';
include './includes/db.php';
require_once 'attendance/attendance_functions.php';

$searchUsername = $_POST['username'] ?? '';
$attendanceStatusFilter = $_POST['status'] ?? '';
$filterDate = $_POST['entry_date'] ?? '';

$groupedEntries = getFilteredAttendance($conn, $searchUsername, $attendanceStatusFilter, $filterDate);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Admin Dashboard | Daily Attendance System</title>
  <link rel="icon" href="favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="styles/index.css">
  <link rel="stylesheet" href="styles/dashboardPageStyles.css">
</head>

<body>
  <div class="search-table-container">
    <h2 class="adminpage-title">Admin Dashboard</h2>

    <!-- Search and Filter Section -->
    <div class="search-filter-container">
      <form method="post" class="dashboard-filter-form">
        <input type="text" name="username" placeholder="Search by Username" value="<?= htmlspecialchars($searchUsername) ?>">

        <select name="status">
          <option value="">All Status</option>
          <?php
          $statuses = ['Login', 'Logout', 'Powercut', 'Idle', 'Ongoing', 'Break', 'Away', 'PC/Network Issues'];
          foreach ($statuses as $s) {
            $selected = $attendanceStatusFilter === $s ? 'selected' : '';
            echo "<option value='$s' $selected>$s</option>";
          }
          ?>
        </select>

        <input type="date" name="entry_date" value="<?= htmlspecialchars($filterDate) ?>">

        <div class="filter-buttons">
          <button type="submit">Apply</button>
          <button type="button" onclick="window.location.href='dashboard.php'">Reset</button>
        </div>
      </form>
    </div>

    <!-- Data Display Section -->
    <div class="table-container">
      <?php if (empty($groupedEntries)): ?>
        <p>No attendance records found.</p>
      <?php else: ?>
        <?php foreach ($groupedEntries as $date => $entries): ?>
          <h3 class="date-heading"><?= htmlspecialchars($date) ?></h3>
          <table class="admin-attendance-table">
            <thead>
              <tr>
                <th>Username</th>
                <th>Status</th>
                <th>Start Time</th>
                <th>End Time</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($entries as $e): ?>
                <tr>
                  <td><?= htmlspecialchars($e['username']) ?></td>
                  <td><?= htmlspecialchars($e['entry_type']) ?></td>
                  <td><?= date('H:i', strtotime($e['start_time'])) ?></td>
                  <td><?= $e['end_time'] ? date('H:i', strtotime($e['end_time'])) : '-' ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
</body>

</html>