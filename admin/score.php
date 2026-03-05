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
include "data/score.php";
include "data/class.php";
include "data/subject.php";

/* FILTER */
$class_id = isset($_GET['class_id']) ? $_GET['class_id'] : '';
$semester = isset($_GET['semester']) ? $_GET['semester'] : '';

$scores   = getAllScores($conn, $class_id, $semester);
$classes  = getAllClasses($conn);
$subjects = getAllSubjects($conn);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Admin - Data Nilai</title>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="../css/style.css?v=2">
<link rel="icon" href="../logos.png">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<?php include "inc/navbar.php"; ?>

<div class="container my-5">

<h3 class="fw-bold text-primary mb-4">📊 Manajemen Nilai</h3>

<!-- FILTER -->
<form method="get" class="card p-3 shadow-sm mb-4">
  <div class="row g-3 align-items-end">

    <div class="col-md-4">
      <label class="form-label">Kelas</label>
      <select name="class_id" class="form-select">
        <option value="">Semua Kelas</option>
        <?php foreach ($classes as $c): ?>
          <option value="<?=$c['class_id']?>"
            <?=($class_id == $c['class_id']) ? 'selected' : '' ?>>
            <?=$c['class_name']?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="col-md-3">
      <label class="form-label">Semester</label>
      <select name="semester" class="form-select">
        <option value="">Semua</option>
        <option value="1" <?=($semester=='1')?'selected':''?>>1</option>
        <option value="2" <?=($semester=='2')?'selected':''?>>2</option>
      </select>
    </div>

    <div class="col-md-3">
      <button class="btn btn-primary">
        <i class="fa fa-search"></i> Filter
      </button>
      <a href="score.php" class="btn btn-secondary">Reset</a>
    </div>

    <div class="col-md-2 text-end">
      <a href="score-add.php" class="btn btn-success">
        <i class="fa fa-plus"></i> Tambah Nilai
      </a>
    </div>

  </div>
</form>

<!-- ALERT -->
<?php if (isset($_GET['success'])): ?>
<div class="alert alert-success"><?=$_GET['success']?></div>
<?php endif; ?>

<?php if (isset($_GET['error'])): ?>
<div class="alert alert-danger"><?=$_GET['error']?></div>
<?php endif; ?>

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
  <th>Nilai Akhir</th>
  <th>Grade</th>
  <th>Aksi</th>
</tr>
</thead>
<tbody>

<?php
if ($scores && is_array($scores)):
$i = 1;
foreach ($scores as $s):
$final_score = isset($s['final_score']) ? (int)$s['final_score'] : 0;
?>
<tr>
  <td><?=$i++?></td>
  <td><?=isset($s['student_name']) ? $s['student_name'] : '-'?></td>
  <td><?=isset($s['subject_name']) ? $s['subject_name'] : '-'?></td>
  <td><?=isset($s['class_name']) ? $s['class_name'] : '-'?></td>
  <td><?=isset($s['semester']) ? $s['semester'] : '-'?></td>
  <td><b><?=$final_score?></b></td>

  <td>
    <?php
    if ($final_score >= 85) {
      echo "<span class='badge bg-success'>A</span>";
    } elseif ($final_score >= 75) {
      echo "<span class='badge bg-primary'>B</span>";
    } elseif ($final_score >= 65) {
      echo "<span class='badge bg-warning text-dark'>C</span>";
    } else {
      echo "<span class='badge bg-danger'>D</span>";
    }
    ?>
  </td>

  <td>
    <a href="score-edit.php?score_id=<?=$s['score_id']?>"
       class="btn btn-sm btn-warning">
      <i class="fa fa-edit"></i>
    </a>
    <a href="score-delete.php?score_id=<?=$s['score_id']?>"
       class="btn btn-sm btn-danger"
       onclick="return confirm('Yakin ingin menghapus nilai ini?')">
      <i class="fa fa-trash"></i>
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
$(document).ready(function(){
  $("#navLinks li:nth-child(4) a").addClass('active');
});
</script>

</body>
</html>
