<?php
session_start();

/* =========================
   HAK AKSES
========================= */
if (
    !isset($_SESSION['admin_id']) &&
    (!isset($_SESSION['teacher_id']) || $_SESSION['role'] != 'Guru')
) {
    header("Location: ../login.php");
    exit;
}

require_once "../DB_connection.php";

/* =========================
   VALIDASI PARAMETER
========================= */
if (!isset($_GET['id'])) {
    header("Location: student-grade.php?error=invalid");
    exit;
}

$grade_id = (int) $_GET['id'];

/* =========================
   CEK DATA ADA ATAU TIDAK
========================= */
$check = $conn->prepare(
    "SELECT grade_record_id FROM student_grades WHERE grade_record_id = ?"
);
$check->execute([$grade_id]);

if ($check->rowCount() == 0) {
    header("Location: student-grade.php?error=not_found");
    exit;
}

/* =========================
   PROSES DELETE
========================= */
$stmt = $conn->prepare(
    "DELETE FROM student_grades WHERE grade_record_id = ?"
);
$stmt->execute([$grade_id]);

header("Location: student-grade.php?success=delete");
exit;
