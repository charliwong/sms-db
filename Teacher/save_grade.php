<?php
session_start();

if (!isset($_SESSION['teacher_id']) || $_SESSION['role'] !== 'Teacher') {
    header("Location: ../login.php");
    exit;
}

include "../DB_connection.php";

$teacher_id = $_SESSION['teacher_id'];

// Validasi data utama
if (
    !isset($_POST['student_id']) ||
    !isset($_POST['subject_id']) ||
    !isset($_POST['class_id']) ||
    !isset($_POST['semester']) ||
    !isset($_POST['academic_year'])
) {
    header("Location: student-grade.php?error=invalid_request");
    exit;
}

try {
    $conn->beginTransaction();

    for ($i = 0; $i < count($_POST['student_id']); $i++) {

        // PHP 5 SAFE
        $tugas_harian = isset($_POST['tugas_harian'][$i]) ? $_POST['tugas_harian'][$i] : 0;
        $tugas_proyek = isset($_POST['tugas_proyek'][$i]) ? $_POST['tugas_proyek'][$i] : 0;
        $ujian_lisan  = isset($_POST['ujian_lisan'][$i])  ? $_POST['ujian_lisan'][$i]  : 0;
        $nilai_uts    = isset($_POST['nilai_uts'][$i])    ? $_POST['nilai_uts'][$i]    : 0;
        $nilai_uas    = isset($_POST['nilai_uas'][$i])    ? $_POST['nilai_uas'][$i]    : 0;

        // Hitung nilai akhir
        $nilai_akhir =
            ($tugas_harian * 0.20) +
            ($tugas_proyek * 0.20) +
            ($ujian_lisan  * 0.10) +
            ($nilai_uts    * 0.25) +
            ($nilai_uas    * 0.25);

        // Cek data dobel
        $check = $conn->prepare("
            SELECT grade_record_id
            FROM student_grades
            WHERE student_id = ?
              AND subject_id = ?
              AND semester = ?
              AND academic_year = ?
        ");
        $check->execute(array(
            $_POST['student_id'][$i],
            $_POST['subject_id'],
            $_POST['semester'],
            $_POST['academic_year']
        ));

        if ($check->rowCount() > 0) {
            continue;
        }

        // Insert nilai
        $sql = "INSERT INTO student_grades
            (student_id, subject_id, teacher_id, class_id, semester, academic_year,
             tugas_harian, tugas_proyek, ujian_lisan, nilai_uts, nilai_uas, nilai_akhir)
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";

        $stmt = $conn->prepare($sql);
        $stmt->execute(array(
            $_POST['student_id'][$i],
            $_POST['subject_id'],
            $teacher_id,
            $_POST['class_id'],
            $_POST['semester'],
            $_POST['academic_year'],
            $tugas_harian,
            $tugas_proyek,
            $ujian_lisan,
            $nilai_uts,
            $nilai_uas,
            $nilai_akhir
        ));
    }

    $conn->commit();
    header("Location: student-grade.php?success=1");
    exit;

} catch (Exception $e) {
    $conn->rollBack();
    header("Location: student-grade.php?error=failed");
    exit;
}
