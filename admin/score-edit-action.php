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
include "data/score.php";

/* VALIDASI POST */
if (
    !isset($_POST['score_id']) ||
    !isset($_POST['subject_id']) ||
    !isset($_POST['class_id']) ||
    !isset($_POST['semester']) ||
    !isset($_POST['final_score'])
) {
    header("Location: score.php?error=Data tidak lengkap");
    exit;
}

$score_id    = $_POST['score_id'];
$subject_id  = $_POST['subject_id'];
$class_id    = $_POST['class_id'];
$semester    = $_POST['semester'];
$final_score = $_POST['final_score'];

/* VALIDASI NILAI */
if ($final_score < 0 || $final_score > 100) {
    header("Location: score-edit.php?id=$score_id&error=Nilai harus 0 - 100");
    exit;
}

/* UPDATE DATA */
$updated = updateScore(
    $conn,
    $score_id,
    $subject_id,
    $class_id,
    $semester,
    $final_score
);

if ($updated) {
    header("Location: score.php?success=Nilai berhasil diperbarui");
    exit;
} else {
    header("Location: score-edit.php?id=$score_id&error=Gagal memperbarui nilai");
    exit;
}
