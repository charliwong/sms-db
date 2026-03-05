<?php
session_start();
if (!isset($_SESSION['admin_id']) || $_SESSION['role'] !== 'Admin') {
    header("Location: ../login.php");
    exit;
}

include "../DB_connection.php";
include "../Teacher/data/class.php";
include "../Teacher/data/grade.php";
include "../Teacher/data/section.php";

$report_type = isset($_GET['report_type']) ? $_GET['report_type'] : '';
$classes = getAllClasses($conn);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Lihat Laporan</title>
<link rel="stylesheet" href="../css/style.css?v=2">
<link rel="icon" href="../logos.png">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
</head>
<body>

<?php include "inc/navbar.php"; ?>

<div class="container my-5">
<h4 class="fw-bold text-primary mb-4">📊 Lihat Laporan</h4>

<form method="get" class="card p-4 shadow mb-4">
<select name="report_type" class="form-select" required>
  <option value="">-- Pilih Jenis Laporan --</option>
  <option value="teacher">Data Guru</option>
  <option value="student">Data Siswa</option>
  <option value="nilai">Data Nilai</option>
  <option value="kehadiran">Data Kehadiran</option>
</select>

<button class="btn btn-primary mt-3">Tampilkan</button>
</form>

<?php
/* =========================
   LAPORAN GURU
========================= */
if ($report_type == 'teacher') {
  $q = $conn->query("SELECT * FROM teachers");

  echo "<table class='table table-bordered'>";
  echo "<tr><th>#</th><th>Nama</th><th>Email</th></tr>";
  $i=1;
  foreach ($q as $r) {
    echo "<tr>
      <td>$i</td>
      <td>{$r['fname']} {$r['lname']}</td>
      <td>{$r['email_address']}</td>
    </tr>";
    $i++;
  }
  echo "</table>";
}

/* =========================
   LAPORAN SISWA
========================= */
if ($report_type == 'student') {
  $q = $conn->query("SELECT * FROM students");

  echo "<table class='table table-bordered'>";
  echo "<tr><th>#</th><th>Nama</th><th>Email</th></tr>";
  $i=1;
  foreach ($q as $r) {
    echo "<tr>
      <td>$i</td>
      <td>{$r['fname']} {$r['lname']}</td>
      <td>{$r['email_address']}</td>
    </tr>";
    $i++;
  }
  echo "</table>";
}

/* =========================
   LAPORAN NILAI (FIXED)
========================= */
if ($report_type == 'nilai') {

  $sql = "
    SELECT 
      s.fname, s.lname,
      sub.subject,
      sg.semester,
      sg.academic_year,
      sg.nilai_akhir AS score
    FROM student_grades sg
    JOIN students s ON sg.student_id = s.student_id
    JOIN subjects sub ON sg.subject_id = sub.subject_id
    ORDER BY sg.academic_year DESC, sg.semester DESC
  ";

  $q = $conn->query($sql);

  echo "<table class='table table-bordered'>";
  echo "<tr>
          <th>#</th>
          <th>Nama Siswa</th>
          <th>Mata Pelajaran</th>
          <th>Semester</th>
          <th>Tahun</th>
          <th>Nilai</th>
        </tr>";

  $i = 1;
  foreach ($q as $r) {
    echo "<tr>
      <td>$i</td>
      <td>{$r['fname']} {$r['lname']}</td>
      <td>{$r['subject']}</td>
      <td>{$r['semester']}</td>
      <td>{$r['academic_year']}</td>
      <td>{$r['score']}</td>
    </tr>";
    $i++;
  }
  echo "</table>";
}

/* =========================
   LAPORAN KEHADIRAN
========================= */
if ($report_type == 'kehadiran') {

  $sql = "
    SELECT 
      s.fname, s.lname,
      a.date,
      a.status
    FROM attendance a
    JOIN students s ON a.student_id = s.student_id
    ORDER BY a.date DESC
  ";

  $q = $conn->query($sql);

  echo "<table class='table table-bordered'>";
  echo "<tr>
          <th>#</th>
          <th>Nama Siswa</th>
          <th>Tanggal</th>
          <th>Status</th>
        </tr>";

  $i = 1;
  foreach ($q as $r) {
    echo "<tr>
      <td>$i</td>
      <td>{$r['fname']} {$r['lname']}</td>
      <td>{$r['date']}</td>
      <td>{$r['status']}</td>
    </tr>";
    $i++;
  }
  echo "</table>";
}
?>

</div>
</body>
</html>
