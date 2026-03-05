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

if (!isset($_GET['id'])) {
    header("Location: score.php?error=ID nilai tidak ditemukan");
    exit;
}

$score_id = $_GET['id'];
$score = getScoreById($conn, $score_id);

if (!$score) {
    header("Location: score.php?error=Data nilai tidak ditemukan");
    exit;
}

$classes  = getAllClasses($conn);
$subjects = getAllSubjects($conn);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Edit Nilai</title>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="../css/style.css?v=2">
<link rel="icon" href="../logos.png">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<?php include "inc/navbar.php"; ?>

<div class="container my-5" style="max-width:700px;">

<h3 class="fw-bold text-primary mb-4">
  ✏️ Edit Nilai Siswa
</h3>

<form action="score-edit-action.php" method="post" class="card p-4 shadow">

<input type="hidden" name="score_id" value="<?=$score['score_id']?>">

<!-- SISWA -->
<div class="mb-3">
  <label class="form-label">Nama Siswa</label>
  <input type="text" class="form-control" value="<?=$score['student_name']?>" disabled>
</div>

<!-- MAPEL -->
<div class="mb-3">
  <label class="form-label">Mata Pelajaran</label>
  <select name="subject_id" class="form-select" required>
    <?php foreach ($subjects as $s): ?>
      <option value="<?=$s['subject_id']?>"
        <?=($score['subject_id']==$s['subject_id'])?'selected':''?>>
        <?=$s['subject_name']?>
      </option>
    <?php endforeach; ?>
  </select>
</div>

<!-- KELAS -->
<div class="mb-3">
  <label class="form-label">Kelas</label>
  <select name="class_id" class="form-select" required>
    <?php foreach ($classes as $c): ?>
      <option value="<?=$c['class_id']?>"
        <?=($score['class_id']==$c['class_id'])?'selected':''?>>
        <?=$c['class_name']?>
      </option>
    <?php endforeach; ?>
  </select>
</div>

<!-- SEMESTER -->
<div class="mb-3">
  <label class="form-label">Semester</label>
  <select name="semester" class="form-select" required>
    <option value="1" <?=$score['semester']=='1'?'selected':''?>>1</option>
    <option value="2" <?=$score['semester']=='2'?'selected':''?>>2</option>
  </select>
</div>

<!-- NILAI -->
<div class="mb-3">
  <label class="form-label">Nilai Akhir</label>
  <input type="number" name="final_score" class="form-control"
         min="0" max="100"
         value="<?=$score['final_score']?>" required>
</div>

<div class="d-flex justify-content-between">
  <a href="score.php" class="btn btn-secondary">
    ← Kembali
  </a>
  <button class="btn btn-primary">
    💾 Simpan Perubahan
  </button>
</div>

</form>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
