<?php
session_start();

if (
    !isset($_SESSION['teacher_id']) ||
    $_SESSION['role'] !== 'Teacher'
) {
    header("Location: ../login.php");
    exit;
}

include "../DB_connection.php";
include "data/score.php";

/* VALIDASI POST */
if (
    !isset($_POST['grade_record_id']) ||
    !isset($_POST['nilai_akhir'])
) {
    header("Location: score.php?error=Data tidak lengkap");
    exit;
}

$grade_record_id = (int)$_POST['grade_record_id'];
$nilai_akhir     = (int)$_POST['nilai_akhir'];
$teacher_id      = $_SESSION['teacher_id'];

/* VALIDASI NILAI */
if ($nilai_akhir < 0 || $nilai_akhir > 100) {
    header("Location: score-edit.php?grade_record_id=$grade_record_id&error=Nilai harus 0 - 100");
    exit;
}

/* UPDATE NILAI */
$updated = updateScoreForTeacher(
    $conn,
    $grade_record_id,
    $teacher_id,
    $nilai_akhir
);

if ($updated) {
    header("Location: score.php?success=Nilai berhasil diperbarui");
    exit;
} else {
    header("Location: score-edit.php?grade_record_id=$grade_record_id&error=Gagal memperbarui nilai");
    exit;
}
