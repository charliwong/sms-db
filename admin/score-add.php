<?php
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role'])) {

  if ($_SESSION['role'] == 'Admin') {

    include "../DB_connection.php";

    // data yang dibutuhkan
    include "data/student.php";
    include "data/subject.php";
    include "data/class.php";
    include "data/score.php";

    $students = getAllStudents($conn);
    $subjects = getAllSubjects($conn);
    $classes  = getAllClasses($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin - Tambah Nilai</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/style.css?v=2">
  <link rel="icon" href="../logos.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<?php include "inc/navbar.php"; ?>

<div class="container my-5">

  <h3 class="text-center fw-bold mb-4 text-primary">
    Tambah Nilai Siswa
  </h3>

  <!-- ALERT -->
  <?php if (isset($_GET['error'])) { ?>
    <div class="alert alert-danger"><?=$_GET['error']?></div>
  <?php } ?>

  <?php if (isset($_GET['success'])) { ?>
    <div class="alert alert-success"><?=$_GET['success']?></div>
  <?php } ?>

  <div class="card shadow-lg border-0 mx-auto" style="max-width: 700px;">
    <div class="card-body">

      <form method="POST" action="score-add-action.php">

        <!-- Siswa -->
        <div class="mb-3">
          <label class="form-label">Siswa</label>
          <select name="student_id" class="form-select" required>
            <option value="">-- Pilih Siswa --</option>
            <?php foreach ($students as $s) { ?>
              <option value="<?=$s['student_id']?>">
                <?=$s['fname']?> <?=$s['lname']?>
              </option>
            <?php } ?>
          </select>
        </div>

        <!-- Mata Pelajaran -->
        <div class="mb-3">
          <label class="form-label">Mata Pelajaran</label>
          <select name="subject_id" class="form-select" required>
            <option value="">-- Pilih Mapel --</option>
            <?php foreach ($subjects as $sub) { ?>
              <option value="<?=$sub['subject_id']?>"><?=$sub['subject']?></option>
            <?php } ?>
          </select>
        </div>

        <!-- Kelas -->
        <div class="mb-3">
          <label class="form-label">Kelas</label>
          <select name="class_id" class="form-select" required>
            <option value="">-- Pilih Kelas --</option>
            <?php foreach ($classes as $c) { ?>
              <option value="<?=$c['class_id']?>"><?=$c['class_name']?></option>
            <?php } ?>
          </select>
        </div>

        <!-- Semester -->
        <div class="mb-3">
          <label class="form-label">Semester</label>
          <select name="semester" class="form-select" required>
            <option value="">-- Pilih Semester --</option>
            <option value="Ganjil">Ganjil</option>
            <option value="Genap">Genap</option>
          </select>
        </div>

        <!-- Tahun Ajaran -->
        <div class="mb-3">
          <label class="form-label">Tahun Ajaran</label>
          <input type="text" name="academic_year" class="form-control"
                 placeholder="2024/2025" required>
        </div>

        <hr>

        <!-- NILAI -->
        <div class="row g-3">
          <div class="col-md-4">
            <label class="form-label">Tugas Harian</label>
            <input type="number" name="tugas_harian" class="form-control" min="0" max="100" required>
          </div>

          <div class="col-md-4">
            <label class="form-label">Tugas Proyek</label>
            <input type="number" name="tugas_proyek" class="form-control" min="0" max="100" required>
          </div>

          <div class="col-md-4">
            <label class="form-label">Ujian Lisan</label>
            <input type="number" name="ujian_lisan" class="form-control" min="0" max="100" required>
          </div>

          <div class="col-md-6">
            <label class="form-label">UTS</label>
            <input type="number" name="nilai_uts" class="form-control" min="0" max="100" required>
          </div>

          <div class="col-md-6">
            <label class="form-label">UAS</label>
            <input type="number" name="nilai_uas" class="form-control" min="0" max="100" required>
          </div>
        </div>

        <div class="d-grid mt-4">
          <button class="btn btn-primary">
            <i class="fa fa-save"></i> Simpan Nilai
          </button>
        </div>

      </form>

    </div>
  </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    $("#navLinks li a:contains('Penilaian')").addClass("active");
  });
</script>

</body>
</html>

<?php
  } else {
    header("Location: ../login.php");
    exit;
  }
} else {
  header("Location: ../login.php");
  exit;
}
?>
