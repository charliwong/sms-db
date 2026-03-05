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
include "data/student.php";
include "data/grade.php";


$grade_id   = isset($_GET['grade']) ? $_GET['grade'] : '';
$students   = array();

if ($grade_id != '') {
  $sql = "
    SELECT student_id, fname, lname, grade
    FROM students
    WHERE grade = ?
    ORDER BY fname ASC
  ";

  $stmt = $conn->prepare($sql);
  $stmt->execute([$grade_id]);
  $students = $stmt->fetchAll();
}


$grades   = getAllGrades($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin - Kehadiran</title>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="../css/style.css?v=2">
<link rel="icon" href="../logos.png">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<?php include "inc/navbar.php"; ?>

<div class="container my-5">

<h3 class="text-center fw-bold text-primary mb-4">
Manajemen Kehadiran Siswa
</h3>

<!-- FILTER -->
<form method="get" class="card p-3 shadow-sm mb-4">
<div class="row g-3">

<div class="col-md-6">
<select name="grade" class="form-select" required>
<option value="">-- Pilih Tingkatan --</option>
<?php foreach ($grades as $g) { ?>
<option value="<?=$g['grade_id']?>" <?=($grade_id==$g['grade_id'])?'selected':''?>>
<?=$g['grade_code']?> - <?=$g['grade']?>
</option>
<?php } ?>
</select>
</div>

<div class="col-md-6">
<button class="btn btn-primary w-100">
<i class="fa fa-search"></i> Tampilkan
</button>
</div>

</div>
</form>

<?php if ($students) { ?>

<form action="attendance-save.php" method="post">

<input type="hidden" name="date" value="<?=date('Y-m-d')?>">

<div class="card shadow border-0">
<div class="card-body table-responsive">

<table class="table table-hover align-middle text-center">
<thead class="table-light">
<tr>
<th>#</th>
<th>Nama Siswa</th>
<th>Status Kehadiran</th>
</tr>
</thead>
<tbody>

<?php $i=1; foreach ($students as $s) { ?>
<tr>
<td><?=$i++?></td>
<td class="text-start fw-semibold">
<?=$s['fname']?> <?=$s['lname']?>
</td>
<td>
<input type="hidden" name="student_id[]" value="<?=$s['student_id']?>">

<select name="status[]" class="form-select" required>
<option value="">-- Pilih --</option>
<option value="Hadir">Hadir</option>
<option value="Sakit">Sakit</option>
<option value="Izin">Izin</option>
<option value="Alpha">Alpha</option>
</select>
</td>
</tr>
<?php } ?>

</tbody>
</table>

<button class="btn btn-success">
<i class="fa fa-save"></i> Simpan Kehadiran
</button>

</div>
</div>

</form>

<?php } elseif ($grade_id) { ?>

<div class="alert alert-warning text-center">
Tidak ada siswa pada filter yang dipilih
</div>

<?php } ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
