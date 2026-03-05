<?php
session_start();

if (
  !isset($_SESSION['admin_id']) ||
  !isset($_SESSION['role']) ||
  $_SESSION['role'] !== 'Admin'
) {
  header("Location: ../login.php");
  exit;
}

include "../DB_connection.php";

/*
POST DATA:
- date
- student_id[]
- status[]
*/

if (
  !isset($_POST['date']) ||
  !isset($_POST['student_id']) ||
  !isset($_POST['status'])
) {
  header("Location: attendance.php?error=invalid_data");
  exit;
}

$date        = $_POST['date'];
$student_ids = $_POST['student_id'];
$statuses    = $_POST['status'];

for ($i = 0; $i < count($student_ids); $i++) {

  $student_id = $student_ids[$i];
  $status     = $statuses[$i];

  if ($status == '') {
    continue;
  }

  // 🔎 cek apakah kehadiran sudah ada di tanggal tsb
  $checkSql = "
    SELECT attendance_id
    FROM attendance
    WHERE student_id = ? AND date = ?
  ";
  $checkStmt = $conn->prepare($checkSql);
  $checkStmt->execute([$student_id, $date]);

  if ($checkStmt->rowCount() > 0) {
    // 🔁 UPDATE
    $updateSql = "
      UPDATE attendance
      SET status = ?
      WHERE student_id = ? AND date = ?
    ";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->execute([$status, $student_id, $date]);

  } else {
    // ➕ INSERT
    $insertSql = "
      INSERT INTO attendance (student_id, date, status)
      VALUES (?, ?, ?)
    ";
    $insertStmt = $conn->prepare($insertSql);
    $insertStmt->execute([$student_id, $date, $status]);
  }
}

header("Location: attendance.php?success=1");
exit;
