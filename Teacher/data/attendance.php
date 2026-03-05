<?php
function saveAttendance($conn, $student_id, $grade_id, $teacher_id, $date, $status) {

  // cek existing
  $check = $conn->prepare("
    SELECT attendance_id
    FROM attendance
    WHERE student_id = ? AND date = ?
  ");
  $check->execute([$student_id, $date]);

  if ($check->rowCount() > 0) {
    // UPDATE
    $stmt = $conn->prepare("
      UPDATE attendance
      SET status = ?, teacher_id = ?, grade = ?
      WHERE student_id = ? AND date = ?
    ");
    return $stmt->execute([
      $status,
      $teacher_id,
      $grade_id,
      $student_id,
      $date
    ]);
  } else {
    // INSERT
    $stmt = $conn->prepare("
      INSERT INTO attendance
        (student_id, grade, teacher_id, date, status)
      VALUES (?, ?, ?, ?, ?)
    ");
    return $stmt->execute([
      $student_id,
      $grade_id,
      $teacher_id,
      $date,
      $status
    ]);
  }
}
