<?php
session_start();
include "../DB_connection.php";

$date = $_POST['date'];
$student_ids = $_POST['student_id'];
$statuses    = $_POST['status'];

for ($i=0; $i<count($student_ids); $i++) {

  $sql = "
    INSERT INTO attendance (student_id, date, status)
    VALUES (?, ?, ?)
  ";

  $stmt = $conn->prepare($sql);
  $stmt->execute([
    $student_ids[$i],
    $date,
    $statuses[$i]
  ]);
}

header("Location: attendance.php?success=Kehadiran berhasil disimpan");
exit;
