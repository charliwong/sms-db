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

$report_type = isset($_GET['report_type']) ? $_GET['report_type'] : 'teacher';
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Cetak Laporan</title>
<link rel="stylesheet" href="../css/style.css?v=2">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">

<style>
@media print {
  .no-print { display:none; }
}
</style>
</head>
<body>

<div class="container my-4">

<!-- HEADER -->
<div class="text-center mb-4">
  <h4><b>LAPORAN RESMI SEKOLAH</b></h4>
  <hr>
</div>

<!-- FILTER -->
<form method="get" class="row g-2 mb-3 no-print">
  <div class="col-md-4">
    <select name="report_type" class="form-select">
      <option value="teacher" <?=($report_type=='teacher')?'selected':''?>>Data Guru</option>
      <option value="student" <?=($report_type=='student')?'selected':''?>>Data Siswa</option>
      <option value="score" <?=($report_type=='score')?'selected':''?>>Data Nilai</option>
      <option value="kehadiran" <?=($report_type=='kehadiran')?'selected':''?>>Data Kehadiran</option>
    </select>
  </div>
  <div class="col-md-2">
    <button class="btn btn-primary">Tampilkan</button>
  </div>
  <div class="col-md-6 text-end">
    <button onclick="window.print()" type="button" class="btn btn-success">
      🖨️ Cetak
    </button>
  </div>
</form>

<!-- =========================
     DATA GURU
========================= -->
<?php if ($report_type == 'teacher'): ?>

<table class="table table-bordered">
<tr class="table-light text-center">
  <th>#</th>
  <th>Nama</th>
  <th>Email</th>
</tr>
<?php
$q = $conn->query("SELECT * FROM teachers ORDER BY fname ASC");
$i=1;
foreach ($q as $r):
?>
<tr>
  <td class="text-center"><?=$i++?></td>
  <td><?=$r['fname']?> <?=$r['lname']?></td>
  <td><?=$r['email_address']?></td>
</tr>
<?php endforeach; ?>
</table>

<?php endif; ?>

<!-- =========================
     DATA SISWA
========================= -->
<?php if ($report_type == 'student'): ?>

<table class="table table-bordered">
<tr class="table-light text-center">
  <th>#</th>
  <th>Nama</th>
  <th>Email</th>
</tr>
<?php
$q = $conn->query("SELECT * FROM students ORDER BY fname ASC");
$i=1;
foreach ($q as $r):
?>
<tr>
  <td class="text-center"><?=$i++?></td>
  <td><?=$r['fname']?> <?=$r['lname']?></td>
  <td><?=$r['email_address']?></td>
</tr>
<?php endforeach; ?>
</table>

<?php endif; ?>

<!-- =========================
     DATA NILAI
========================= -->
<?php if ($report_type == 'score'): ?>

<table class="table table-bordered">
<tr class="table-light text-center">
  <th>#</th>
  <th>Siswa</th>
  <th>Mapel</th>
  <th>Kelas</th>
  <th>Semester</th>
  <th>Nilai Akhir</th>
</tr>
<?php
$sql = "
SELECT 
  sg.nilai_akhir,
  sg.semester,
  s.fname AS sfname,
  s.lname AS slname,
  sub.subject,
  CONCAT(c.grade, c.section) AS class_name
FROM student_grades sg
JOIN students s ON sg.student_id = s.student_id
JOIN subjects sub ON sg.subject_id = sub.subject_id
JOIN class c ON sg.class_id = c.class_id
ORDER BY s.fname ASC
";
$q = $conn->query($sql);
$i=1;
foreach ($q as $r):
?>
<tr>
  <td class="text-center"><?=$i++?></td>
  <td><?=$r['sfname']?> <?=$r['slname']?></td>
  <td><?=$r['subject']?></td>
  <td><?=$r['class_name']?></td>
  <td class="text-center"><?=$r['semester']?></td>
  <td class="text-center"><b><?=$r['nilai_akhir']?></b></td>
</tr>
<?php endforeach; ?>
</table>

<?php endif; ?>

<?php if ($report_type == 'kehadiran'): ?>

<table class="table table-bordered">
<tr class="table-light text-center">
  <th>#</th>
  <th>Nama Siswa</th>
  <th>Tingkatan</th>
  <th>Kelas</th>
  <th>Hadir</th>
  <th>Izin</th>
  <th>Alpha</th>
</tr>

<?php
$sql = "
SELECT 
  s.student_id,
  s.fname,
  s.lname,
  s.grade,
  s.section,
  SUM(CASE WHEN a.status='Hadir' THEN 1 ELSE 0 END) AS hadir,
  SUM(CASE WHEN a.status='Izin' THEN 1 ELSE 0 END) AS izin,
  SUM(CASE WHEN a.status='Alpha' THEN 1 ELSE 0 END) AS alpha
FROM students s
LEFT JOIN attendance a 
  ON s.student_id = a.student_id
GROUP BY s.student_id
ORDER BY s.grade ASC, s.section ASC, s.fname ASC
";

$q = $conn->query($sql);
$i = 1;
foreach ($q as $r):
?>

<tr class="text-center">
  <td><?=$i++?></td>
  <td class="text-start"><?=$r['fname']?> <?=$r['lname']?></td>
  <td><?=$r['grade']?></td>
  <td><?=$r['grade']?><?=$r['section']?></td>
  <td><?=$r['hadir']?></td>
  <td><?=$r['izin']?></td>
  <td><?=$r['alpha']?></td>
</tr>

<?php endforeach; ?>
</table>

<?php endif; ?>


</div>
</body>
</html>
