<?php 
session_start();

if (!isset($_SESSION['teacher_id']) || $_SESSION['role'] !== 'Teacher') {
    header("Location: ../login.php");
    exit;
}

include "../DB_connection.php";
include "data/class.php";
include "data/grade.php";
include "data/section.php";
include "data/teacher.php";

$teacher_id = $_SESSION['teacher_id'];
$teacher = getTeacherById($teacher_id, $conn);

if (!$teacher) {
    die("Data guru tidak ditemukan.");
}

$classes = getAllClasses($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Guru - Siswa</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<?php include "inc/navbar.php"; ?>

<div class="container mt-5">
<div class="card shadow p-4">

<h4 class="text-center mb-4">📚 Daftar Kelas</h4>

<?php if (!empty($classes)): ?>

<table class="table table-bordered text-center">
<thead class="table-light">
<tr>
    <th>#</th>
    <th>Kelas</th>
</tr>
</thead>
<tbody>

<?php 
$i = 1;
foreach ($classes as $class):

    $grade = getGradeById($class['grade_id'], $conn);
    $section = getSectioById($class['section'], $conn);

    if (!$grade || !$section) continue;

    $nama_kelas = $grade['grade_code'] . ' ' . 
                  $grade['grade'] . 
                  $section['section'];
?>

<tr>
    <td><?= $i++ ?></td>
    <td>
        <a href="students_of_class.php?class_id=<?= $class['class_id'] ?>">
            <?= htmlspecialchars($nama_kelas) ?>
        </a>
    </td>
</tr>

<?php endforeach; ?>

</tbody>
</table>

<?php else: ?>
<div class="alert alert-info text-center">
    Tidak ada kelas.
</div>
<?php endif; ?>

</div>
</div>

</body>
</html>
