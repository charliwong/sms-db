<?php
session_start();
if (!isset($_SESSION['teacher_id']) || $_SESSION['role'] !== 'Teacher') {
    header("Location: ../login.php");
    exit;
}

include "../DB_connection.php";
include "data/student.php";
include "data/class.php";
include "data/subject.php";

/* ambil parameter */
$class_id      = $_GET['class_id'];
$subject_id    = $_GET['subject_id'];
$semester      = $_GET['semester'];
$academic_year = $_GET['academic_year'];

/* data pendukung */
$students = getStudentsByClassId($class_id, $conn);
$subject  = getSubjectById($subject_id, $conn);
$class    = getClassById($class_id, $conn);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Input Nilai Siswa</title>
    <link rel="icon" href="../logos.png">
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
</head>
<body>

<?php include "inc/navbar.php"; ?>

<div class="container my-5">

    <h4 class="fw-bold mb-3">Input Nilai Siswa</h4>

    <!-- INFO -->
    <div class="alert alert-info">
        <b>Kelas:</b> <?=$class['grade_code'].' '.$class['grade'].$class['section']?> |
        <b>Mapel:</b> <?=$subject['subject']?> |
        <b>Semester:</b> <?=$semester?> |
        <b>Tahun:</b> <?=$academic_year?>
    </div>

    <?php if (!$students): ?>
        <div class="alert alert-warning">Tidak ada siswa di kelas ini.</div>
    <?php else: ?>

    <form action="save_grade.php" method="post">

    <!-- hidden global (WAJIB ADA VALUE) -->
    <input type="hidden" name="subject_id" value="<?=$subject_id?>">
    <input type="hidden" name="class_id" value="<?=$class_id?>">
    <input type="hidden" name="semester" value="<?=$semester?>">
    <input type="hidden" name="academic_year" value="<?=$academic_year?>">

    <div class="table-responsive">
    <table class="table table-bordered align-middle text-center">
        <thead class="table-primary">
            <tr>
                <th>#</th>
                <th>Nama Siswa</th>
                <th>Tugas Harian</th>
                <th>Tugas Proyek</th>
                <th>Ujian Lisan</th>
                <th>UTS</th>
                <th>UAS</th>
            </tr>
        </thead>
        <tbody>
        <?php $no=1; foreach ($students as $s): ?>
            <tr>
                <td><?=$no++?></td>
                <td class="text-start">
                    <?=$s['fname'].' '.$s['lname']?>
                    <input type="hidden" name="student_id[]" value="<?=$s['student_id']?>">
                </td>
                <td><input type="number" step="0.01" name="tugas_harian[]" class="form-control" required></td>
                <td><input type="number" step="0.01" name="tugas_proyek[]" class="form-control" required></td>
                <td><input type="number" step="0.01" name="ujian_lisan[]" class="form-control" required></td>
                <td><input type="number" step="0.01" name="nilai_uts[]" class="form-control" required></td>
                <td><input type="number" step="0.01" name="nilai_uas[]" class="form-control" required></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    </div>

    <div class="text-end">
        <button class="btn btn-success">
            💾 Simpan Nilai
        </button>
    </div>
</form>


    <?php endif; ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
