<?php
function getTodayAttendanceEntries($conn, $user_id)
{
    $today = date('Y-m-d');
    $stmt = $conn->prepare("SELECT * FROM attendance_entries WHERE user_id = ? AND entry_date = ? ORDER BY start_time");
    $stmt->bind_param("is", $user_id, $today);
    $stmt->execute();
    $result = $stmt->get_result();

    $entries = [];
    while ($row = $result->fetch_assoc()) {
        $entries[] = $row;
    }

    return $entries;
}

function getAllAttendanceEntriesGroupedByDate($conn, $user_id)
{
    $entries = [];

    $stmt = $conn->prepare("SELECT * FROM attendance_entries WHERE user_id = ? ORDER BY entry_date DESC, start_time ASC");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $entries[$row['entry_date']][] = $row;
    }

    return $entries;
}

function getFilteredAttendance($conn, $username, $status, $date)
{
    $sql = "SELECT ae.id, ae.user_id, u.username, ae.entry_type, ae.start_time, ae.end_time, ae.entry_date
            FROM attendance_entries ae
            JOIN users u ON ae.user_id = u.id
            WHERE 1=1";

    if (!empty($username)) {
        $username = $conn->real_escape_string($username);
        $sql .= " AND u.username LIKE '%$username%'";
    }

    if (!empty($status)) {
        $status = $conn->real_escape_string($status);
        $sql .= " AND ae.entry_type = '$status'";
    }

    if (!empty($date)) {
        $date = $conn->real_escape_string($date);
        $sql .= " AND ae.entry_date = '$date'";
    }

    $sql .= " ORDER BY ae.entry_date DESC, ae.start_time ASC";

    $result = $conn->query($sql);

    $grouped = [];
    while ($row = $result->fetch_assoc()) {
        $grouped[$row['entry_date']][] = $row;
    }

    return $grouped;
}
