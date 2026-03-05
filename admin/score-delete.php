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

/* VALIDASI PARAMETER */
if (!isset($_GET['score_id'])) {
    header("Location: score.php?error=ID nilai tidak ditemukan");
    exit;
}

$score_id = $_GET['score_id'];

/* CEK DATA ADA */
$score = getScoreById($conn, $score_id);
if ($score == 0) {
    header("Location: score.php?error=Data nilai tidak ditemukan");
    exit;
}

/* HAPUS DATA */
$deleted = deleteScore($conn, $score_id);

if ($deleted) {
    header("Location: score.php?success=Nilai berhasil dihapus");
    exit;
} else {
    header("Location: score.php?error=Gagal menghapus nilai");
    exit;
}
