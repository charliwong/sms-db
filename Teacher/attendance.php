<?php
session_start();

if (!isset($_SESSION['teacher_id']) || $_SESSION['role'] !== 'Teacher') {
    header("Location: ../login.php");
    exit;
}

include "../DB_connection.php";
include "data/class.php";
include "data/grade.php";

$teacher_id = $_SESSION['teacher_id'];
$class_id   = isset($_GET['class_id']) ? (int)$_GET['class_id'] : 0;

/* ambil kelas guru */
$stmt = $conn->prepare("SELECT class FROM teachers WHERE teacher_id = ?");
$stmt->execute([$teacher_id]);
$teacher = $stmt->fetch();

/* parsing kelas guru (AMAN) */
$allowed_classes = array_filter(
    array_map('intval', explode(',', str_replace(' ', '', $teacher['class'])))
);

$students = [];

if ($class_id && in_array($class_id, $allowed_classes, true)) {

    $class = getClassById($class_id, $conn);
    if ($class) {

        $stmt = $conn->prepare("
            SELECT student_id, fname, lname
            FROM students
            WHERE class_id = ?
            ORDER BY fname ASC
        ");
        $stmt->execute([$class_id]);
        $students = $stmt->fetchAll();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Guru - Kehadiran</title>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="../css/style.css?v=2">
<link rel="icon" href="../logos.png">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<?php include "inc/navbar.php"; ?>

<div class="container my-5">
<h3 class="text-center fw-bold text-primary mb-4">
Input Kehadiran Siswa
</h3>

<form method="get" class="card p-3 shadow-sm mb-4">
<div class="row g-3">

<div class="col-md-8">
<select name="class_id" class="form-select" required>
<option value="">-- Pilih Kelas --</option>

<?php foreach ($allowed_classes as $cid):
    $c = getClassById($cid, $conn);
    if (!$c) continue;
    $g = getGradeById($c['grade'], $conn);
?>
<option value="<?= $cid ?>" <?= $cid === $class_id ? 'selected' : '' ?>>
<?= $g['grade_code'].' '.$g['grade'] ?>
</option>
<?php endforeach; ?>

</select>
</div>

<div class="col-md-4">
<button class="btn btn-primary w-100">
<i class="fa fa-search"></i> Tampilkan
</button>
</div>

</div>
</form>

<?php if ($students): ?>
<form action="attendance-save.php" method="post">
<input type="hidden" name="class_id" value="<?= $class_id ?>">
<input type="hidden" name="date" value="<?= date('Y-m-d') ?>">

<div class="card shadow">
<div class="card-body table-responsive">

<table class="table table-bordered align-middle text-center">
<thead class="table-light">
<tr>
<th>#</th>
<th>Nama Siswa</th>
<th>Status</th>
</tr>
</thead>
<tbody>

<?php $i=1; foreach ($students as $s): ?>
<tr>
<td><?= $i++ ?></td>
<td class="text-start"><?= htmlspecialchars($s['fname'].' '.$s['lname']) ?></td>
<td>
<input type="hidden" name="student_id[]" value="<?= $s['student_id'] ?>">
<select name="status[]" class="form-select" required>
<option value="">-- Pilih --</option>
<option value="Hadir">Hadir</option>
<option value="Sakit">Sakit</option>
<option value="Izin">Izin</option>
<option value="Alpha">Alpha</option>
</select>
</td>
</tr>
<?php endforeach; ?>

</tbody>
</table>

<button class="btn btn-success">
<i class="fa fa-save"></i> Simpan Kehadiran
</button>

</div>
</div>
</form>
<?php endif; ?>
</div>
</body>
</html>
