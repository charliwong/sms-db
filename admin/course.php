<?php 
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role'])) {

  if ($_SESSION['role'] == 'Admin') {

    include "../DB_connection.php";
    include "data/subject.php";
    include "data/grade.php";

    $courses = getAllSubjects($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin - Mata Pelajaran</title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/style.css?v=2">
  <link rel="icon" href="../logos.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<?php include "inc/navbar.php"; ?>

<div class="container my-5">

  <!-- Judul -->
  <h3 class="text-center fw-bold mb-4 text-primary">
    Manajemen Mata Pelajaran
  </h3>

  <!-- Tombol Tambah (SELALU ADA) -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <a href="course-add.php" class="btn btn-primary">
      <i class="fa fa-plus"></i> Tambah Mata Pelajaran
    </a>
  </div>

  <!-- Alert -->
  <?php if (isset($_GET['error'])) { ?>
    <div class="alert alert-danger">
      <?=$_GET['error']?>
    </div>
  <?php } ?>

  <?php if (isset($_GET['success'])) { ?>
    <div class="alert alert-success">
      <?=$_GET['success']?>
    </div>
  <?php } ?>

  <!-- CEK DATA -->
  <?php if ($courses != 0) { ?>

  <!-- Card -->
  <div class="card shadow-lg border-0 mx-auto" style="max-width: 900px;">
    <div class="card-body">

      <!-- Table -->
      <div class="table-responsive">
        <table class="table table-hover align-middle text-center">
          <thead class="table-light">
            <tr>
              <th style="width:60px;">#</th>
              <th>Mata Pelajaran</th>
              <th>Kode</th>
              <th>Tingkatan</th>
              <th style="width:150px;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $i = 1; foreach ($courses as $course) { ?>
            <tr>
              <td><?=$i++?></td>
              <td class="fw-semibold"><?=$course['subject']?></td>
              <td>
                <span class="badge bg-secondary">
                  <?=$course['subject_code']?>
                </span>
              </td>
              <td>
                <?php 
                  $grade = getGradeById($course['grade'], $conn);
                  if ($grade) {
                    echo $grade['grade_code'].'-'.$grade['grade'];
                  }
                ?>
              </td>
              <td>
                <a href="course-edit.php?course_id=<?=$course['subject_id']?>"
                   class="btn btn-sm btn-warning">
                  <i class="fa fa-edit"></i>
                </a>
                <a href="course-delete.php?course_id=<?=$course['subject_id']?>"
                   class="btn btn-sm btn-danger"
                   onclick="return confirm('Yakin ingin menghapus mata pelajaran ini?')">
                  <i class="fa fa-trash"></i>
                </a>
              </td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>

    </div>
  </div>

  <?php } else { ?>

  <!-- JIKA DATA KOSONG -->
  <div class="alert alert-info text-center mt-4">
    <i class="fa fa-book fa-2x mb-2"></i><br>
    Belum ada mata pelajaran yang ditambahkan.<br>
    Silakan klik <b>Tambah Mata Pelajaran</b> untuk menambahkan data.
  </div>

  <?php } ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  $(document).ready(function(){
    $("#navLinks li:nth-child(8) a").addClass('active');
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
