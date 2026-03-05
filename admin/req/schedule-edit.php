<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if (!isset($_SESSION['admin_id']) || $_SESSION['role'] != 'Admin') {
    header("Location: ../login.php");
    exit;
}

require_once "../DB_connection.php";

/* ======================
   CEK ID
====================== */
if (!isset($_GET['schedule_id'])) {
    header("Location: schedule.php");
    exit;
}

$schedule_id = $_GET['schedule_id'];

/* ======================
   AMBIL DATA JADWAL
====================== */
$stmt = $conn->prepare("SELECT * FROM schedule WHERE schedule_id = ?");
$stmt->execute([$schedule_id]);
$schedule = $stmt->fetch();

if (!$schedule) {
    header("Location: schedule.php");
    exit;
}

/* ======================
   DATA DROPDOWN
====================== */
$subjects = $conn->query("SELECT subject_id, subject FROM subjects")->fetchAll();
$teachers = $conn->query("SELECT teacher_id, fname, lname FROM teachers")->fetchAll();
$grades   = $conn->query("SELECT grade_id, grade FROM grades")->fetchAll();

/* ======================
   UPDATE DATA
====================== */
if (isset($_POST['update'])) {

    $stmt = $conn->prepare(
        "UPDATE schedule SET
        subject_id = ?,
        teacher_id = ?,
        grade_id   = ?,
        day        = ?,
        start_time = ?,
        end_time   = ?,
        room       = ?,
        academic_year = ?,
        semester   = ?
        WHERE schedule_id = ?"
    );

    $stmt->execute([
        $_POST['subject_id'],
        $_POST['teacher_id'],
        $_POST['grade_id'],
        $_POST['day'],
        $_POST['start_time'],
        $_POST['end_time'],
        $_POST['room'],
        $_POST['academic_year'],
        $_POST['semester'],
        $schedule_id
    ]);

    header("Location: schedule.php?success=Jadwal berhasil diubah");
    exit;
}
?>
