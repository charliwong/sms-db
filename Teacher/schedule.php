<?php
session_start();

if (
  !isset($_SESSION['teacher_id']) ||
  !isset($_SESSION['role']) ||
  $_SESSION['role'] !== 'Teacher'
) {
  header("Location: ../login.php");
  exit;
}

include "../DB_connection.php";
include "data/schedule.php";
include "data/subject.php";
include "data/grade.php";

$teacher_id = $_SESSION['teacher_id'];
$schedules  = getScheduleByTeacher($teacher_id, $conn);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Guru - Jadwal Mengajar</title>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="../css/style.css?v=2">
<link rel="icon" href="../logos.png">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<?php include "inc/navbar.php"; ?>

<div class="container my-5">

<h3 class="text-center text-primary fw-bold mb-4">
Jadwal Mengajar Saya
</h3>

<?php if ($schedules != 0) { ?>
<div class="table-responsive">
<table class="table table-bordered table-hover align-middle text-center">

<thead class="table-light">
<tr>
  <th>#</th>
  <th>Hari</th>
  <th>Mata Pelajaran</th>
  <th>Tingkatan</th>
  <th>Waktu</th>
  <th>Ruang</th>
  <th>Tahun Akademik</th>
  <th>Semester</th>
</tr>
</thead>

<tbody>
<?php $i=1; foreach ($schedules as $s) { ?>
<tr>
  <td><?=$i++?></td>
  <td><?=$s['day']?></td>
  <td><?=getSubjectById($s['subject_id'], $conn)['subject']?></td>
  <td><?=getGradeById($s['grade_id'], $conn)['grade']?></td>
  <td><?=$s['start_time']?> - <?=$s['end_time']?></td>
  <td><?=$s['room']?></td>
  <td><?=$s['academic_year']?></td>
  <td><?=$s['semester']?></td>
</tr>
<?php } ?>
</tbody>

</table>
</div>

<?php } else { ?>
<div class="alert alert-info text-center">
Belum ada jadwal mengajar
</div>
<?php } ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    document.querySelector("#navLinks li:nth-child(2) a")?.classList.add("active");
  });
</script>
</body>
</html>
