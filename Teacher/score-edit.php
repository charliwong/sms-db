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

if (!isset($_GET['grade_record_id'])) {
    header("Location: score.php?error=ID nilai tidak ditemukan");
    exit;
}

$grade_record_id = $_GET['grade_record_id'];
$teacher_id      = $_SESSION['teacher_id'];

/* ambil data nilai + validasi guru */
$score = getScoreByIdForTeacher($conn, $grade_record_id, $teacher_id);

if (!$score) {
    header("Location: score.php?error=Data nilai tidak ditemukan atau tidak berhak diakses");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Guru - Edit Nilai</title>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="../css/style.css?v=2">
<link rel="icon" href="../logos.png">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<?php include "inc/navbar.php"; ?>

<div class="container my-5" style="max-width:720px;">

<h3 class="fw-bold text-primary mb-4">
  ✏️ Edit Nilai Siswa
</h3>

<form action="score-edit-action.php" method="post" class="card p-4 shadow">

<input type="hidden" name="grade_record_id" value="<?=$score['grade_record_id']?>">

<!-- SISWA -->
<div class="mb-3">
  <label class="form-label">Nama Siswa</label>
  <input type="text" class="form-control"
         value="<?=$score['student_name']?>" disabled>
</div>

<!-- MAPEL -->
<div class="mb-3">
  <label class="form-label">Mata Pelajaran</label>
  <input type="text" class="form-control"
         value="<?=$score['subject_name']?>" disabled>
</div>

<!-- KELAS -->
<div class="mb-3">
  <label class="form-label">Kelas</label>
  <input type="text" class="form-control"
         value="<?=$score['class_name']?>" disabled>
</div>

<!-- SEMESTER -->
<div class="mb-3">
  <label class="form-label">Semester</label>
  <input type="text" class="form-control"
         value="<?=$score['semester']?>" disabled>
</div>

<hr>

<!-- NILAI -->
<div class="mb-3">
  <label class="form-label">Nilai Akhir</label>
  <input type="number"
         name="nilai_akhir"
         class="form-control"
         min="0" max="100"
         value="<?=$score['nilai_akhir']?>"
         required>
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
