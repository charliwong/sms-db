<?php
session_start();

if (
    isset($_SESSION['admin_id']) &&
    isset($_SESSION['role']) &&
    $_SESSION['role'] === 'Admin'
) {

    if (
        isset($_POST['student_id']) &&
        isset($_POST['subject_id']) &&
        isset($_POST['class_id']) &&
        isset($_POST['semester']) &&
        isset($_POST['academic_year']) &&
        isset($_POST['tugas_harian']) &&
        isset($_POST['tugas_proyek']) &&
        isset($_POST['ujian_lisan']) &&
        isset($_POST['nilai_uts']) &&
        isset($_POST['nilai_uas'])
    ) {

        include "../DB_connection.php";
        include "data/score.php";

        // Ambil & sanitasi data
        $student_id     = intval($_POST['student_id']);
        $subject_id     = intval($_POST['subject_id']);
        $class_id       = intval($_POST['class_id']);
        $semester       = trim($_POST['semester']);
        $academic_year  = trim($_POST['academic_year']);

        $tugas_harian   = floatval($_POST['tugas_harian']);
        $tugas_proyek   = floatval($_POST['tugas_proyek']);
        $ujian_lisan    = floatval($_POST['ujian_lisan']);
        $nilai_uts      = floatval($_POST['nilai_uts']);
        $nilai_uas      = floatval($_POST['nilai_uas']);

        // Validasi nilai (0–100)
        $nilai_array = [
            $tugas_harian,
            $tugas_proyek,
            $ujian_lisan,
            $nilai_uts,
            $nilai_uas
        ];

        foreach ($nilai_array as $n) {
            if ($n < 0 || $n > 100) {
                header("Location: score-add.php?error=Nilai harus antara 0 sampai 100");
                exit;
            }
        }

        // 🔢 HITUNG NILAI AKHIR
        // Bobot:
        // Tugas Harian 20%
        // Proyek 20%
        // Lisan 10%
        // UTS 20%
        // UAS 30%
        $nilai_akhir =
            ($tugas_harian * 0.20) +
            ($tugas_proyek * 0.20) +
            ($ujian_lisan  * 0.10) +
            ($nilai_uts    * 0.20) +
            ($nilai_uas    * 0.30);

        // Simpan ke database
        $result = addScore(
            $conn,
            $student_id,
            $subject_id,
            $class_id,
            $semester,
            $academic_year,
            $tugas_harian,
            $tugas_proyek,
            $ujian_lisan,
            $nilai_uts,
            $nilai_uas,
            $nilai_akhir
        );

        if ($result) {
            header("Location: score.php?success=Nilai berhasil ditambahkan");
            exit;
        } else {
            header("Location: score-add.php?error=Gagal menyimpan nilai");
            exit;
        }

    } else {
        header("Location: score-add.php?error=Semua field wajib diisi");
        exit;
    }

} else {
    header("Location: ../login.php");
    exit;
}
