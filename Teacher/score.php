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
include "data/score.php";

/* FILTER */
$semester   = isset($_GET['semester']) ? $_GET['semester'] : '';
$teacher_id = $_SESSION['teacher_id'];

$scores = getScoresByTeacher($teacher_id, $conn, $semester);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Guru - Data Nilai</title>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="../css/style.css?v=2">
<link rel="icon" href="../logos.png">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<?php include "inc/navbar.php"; ?>

<div class="container my-5">

<h3 class="fw-bold text-primary mb-4">📊 Nilai Siswa</h3>

<!-- FILTER -->
<form method="get" class="card p-3 shadow-sm mb-4">
  <div class="row g-3 align-items-end">

    <div class="col-md-3">
      <label class="form-label">Semester</label>
      <select name="semester" class="form-select">
        <option value="">Semua</option>
        <option value="1" <?=($semester=='1')?'selected':''?>>1</option>
        <option value="2" <?=($semester=='2')?'selected':''?>>2</option>
      </select>
    </div>

    <div class="col-md-6">
      <button class="btn btn-primary">
        <i class="fa fa-search"></i> Filter
      </button>
      <a href="score.php" class="btn btn-secondary">Reset</a>
    </div>

    <div class="col-md-3 text-end">
      <a href="score-add.php" class="btn btn-success">
        <i class="fa fa-plus"></i> Input Nilai
      </a>
    </div>

  </div>
</form>

<!-- TABEL -->
<div class="card shadow-sm">
<div class="card-body table-responsive">

<table class="table table-bordered table-hover align-middle text-center">
<thead class="table-light">
<tr>
  <th>#</th>
  <th>Siswa</th>
  <th>Mapel</th>
  <th>Kelas</th>
  <th>Semester</th>
  <th>Nilai</th>
  <th>Grade</th>
  <th>Aksi</th>
</tr>
</thead>
<tbody>

<?php if ($scores): $i=1; foreach ($scores as $s):
  $nilai = (int)$s['nilai_akhir'];
?>
<tr>
  <td><?=$i++?></td>
  <td><?=$s['student_name']?></td>
  <td><?=$s['subject_name']?></td>
  <td><?=$s['class_name']?></td>
  <td><?=$s['semester']?></td>
  <td><b><?=$nilai?></b></td>
  <td>
    <?php
      if ($nilai >= 85)      echo "<span class='badge bg-success'>A</span>";
      elseif ($nilai >= 75)  echo "<span class='badge bg-primary'>B</span>";
      elseif ($nilai >= 65)  echo "<span class='badge bg-warning text-dark'>C</span>";
      else                   echo "<span class='badge bg-danger'>D</span>";
    ?>
  </td>
  <td>
    <a href="score-edit.php?grade_record_id=<?=$s['grade_record_id']?>"
       class="btn btn-sm btn-warning">
      <i class="fa fa-edit"></i>
    </a>
  </td>
</tr>
<?php endforeach; else: ?>
<tr>
  <td colspan="8" class="text-muted">Belum ada data nilai</td>
</tr>
<?php endif; ?>

</tbody>
</table>

</div>
</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function(){
  document.querySelector("#navLinks li:nth-child(4) a")?.classList.add("active");
});
</script>

</body>
</html>
