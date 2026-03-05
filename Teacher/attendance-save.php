<?php
session_start();

if (!isset($_SESSION['teacher_id']) || $_SESSION['role'] !== 'Teacher') {
    header("Location: ../login.php");
    exit;
}

include "../DB_connection.php";
include "data/class.php";

$class_id = isset($_POST['class_id']) ? (int)$_POST['class_id'] : 0;
$date     = isset($_POST['date']) ? $_POST['date'] : '';
$students = isset($_POST['student_id']) ? $_POST['student_id'] : array();
$statuses = isset($_POST['status']) ? $_POST['status'] : array();


if (!$class_id || !$date || empty($students)) {
    header("Location: attendance.php?error=Data tidak lengkap");
    exit;
}

/* validasi kelas guru */
$stmt = $conn->prepare("SELECT class FROM teachers WHERE teacher_id = ?");
$stmt->execute([$teacher_id]);
$teacher = $stmt->fetch();

$allowed_classes = array_map('intval', explode(',', $teacher['class']));

if (!in_array($class_id, $allowed_classes, true)) {
    header("Location: attendance.php?error=Akses ditolak");
    exit;
}

/* ambil kelas */
$class = getClassById($class_id, $conn);
if (!$class) {
    header("Location: attendance.php?error=Kelas tidak ditemukan");
    exit;
}

$grade_id = $class['grade']; // ✅ BENAR

try {
    $conn->beginTransaction();

    $check = $conn->prepare("
        SELECT attendance_id
        FROM attendance
        WHERE student_id = ? AND date = ?
    ");

    $insert = $conn->prepare("
        INSERT INTO attendance (student_id, grade, teacher_id, date, status)
        VALUES (?, ?, ?, ?, ?)
    ");

    $update = $conn->prepare("
        UPDATE attendance
        SET status = ?, teacher_id = ?, grade = ?
        WHERE student_id = ? AND date = ?
    ");

    foreach ($students as $i => $sid) {

    $status = isset($statuses[$i]) ? $statuses[$i] : '';

    if ($status === '') continue;

    $check->execute(array($sid, $date));

    if ($check->rowCount()) {
        $update->execute(array($status, $teacher_id, $grade_id, $sid, $date));
    } else {
        $insert->execute(array($sid, $grade_id, $teacher_id, $date, $status));
    }
}

    $conn->commit();
    header("Location: attendance.php?success=Kehadiran tersimpan");
    exit;

} catch (Exception $e) {
    $conn->rollBack();
    header("Location: attendance.php?error=Gagal menyimpan");
    exit;
}
