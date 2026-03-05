<?php
session_start();

if (!isset($_SESSION['teacher_id']) || $_SESSION['role'] !== 'Teacher') {
    header("Location: ../login.php");
    exit;
}

if (!isset($_GET['class_id']) || !is_numeric($_GET['class_id'])) {
    header("Location: students.php");
    exit;
}

include "../DB_connection.php";
include "data/student.php";
include "data/class.php";
include "data/grade.php";
include "data/section.php";

$class_id = (int) $_GET['class_id'];

$class = getClassById($class_id, $conn);
if (!$class) {
    header("Location: students.php");
    exit;
}

$grade   = getGradeById($class['grade_id'], $conn);
$section = getSectioById($class['section'], $conn);

$students = getStudentsByClassId($class_id, $conn);
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Daftar Siswa</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="../css/style.css">
</head>
<body>

<?php include "inc/navbar.php"; ?>

<div class="container mt-5">

<h4 class="text-center mb-4">
Daftar Siswa Kelas 
<?= htmlspecialchars($grade['grade_code'].' '.$grade['grade'].$section['section']) ?>
</h4>

<?php if (!empty($students)): ?>

<table class="table table-bordered text-center">
<thead class="table-light">
<tr>
    <th>#</th>
    <th>Nama</th>
    <th>Kehadiran</th>
    <th>Nilai</th>
</tr>
</thead>
<tbody>

<?php $no = 1; foreach ($students as $s): ?>
<tr>
    <td><?= $no++ ?></td>
    <td><?= htmlspecialchars($s['fname'].' '.$s['lname']) ?></td>
    <td>
        <a href="attendance-add.php?student_id=<?= $s['student_id'] ?>&class_id=<?= $class_id ?>" 
           class="btn btn-success btn-sm">
            Kehadiran
        </a>
    </td>
    <td>
        <a href="student-grade-add.php?student_id=<?= $s['student_id'] ?>&class_id=<?= $class_id ?>" 
           class="btn btn-warning btn-sm">
            Nilai
        </a>
    </td>
</tr>
<?php endforeach; ?>

</tbody>
</table>

<?php else: ?>
<div class="alert alert-info text-center">
Tidak ada siswa di kelas ini
</div>
<?php endif; ?>

<div class="text-center mt-4">
<a href="students.php" class="btn btn-secondary">Kembali</a>
</div>

</div>
</body>
</html>
