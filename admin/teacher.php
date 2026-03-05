<?php 
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role'])) {

  if ($_SESSION['role'] == 'Admin') {

    include "../DB_connection.php";
    include "data/teacher.php";
    include "data/subject.php";
    include "data/grade.php";
    include "data/class.php";
    include "data/section.php";

    $teachers = getAllTeachers($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin - Teachers</title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/style.css?v=2">
  <link rel="icon" href="../logos.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<?php include "inc/navbar.php"; ?>

<div class="container my-5">
<h3 class="text-center mb-4 fw-bold text-primary">
Dashboard Guru
</h3>
  <!-- Judul -->
  <h3 class="text-center fw-bold mb-4 text-primary">
    Manajemen Guru
  </h3>

  <!-- Tombol Tambah (SELALU TAMPIL) -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <a href="teacher-add.php" class="btn btn-primary">
      <i class="fa fa-plus"></i> Tambah Guru Baru
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
  <?php if ($teachers != 0) { ?>

  <!-- Card -->
  <div class="card shadow-lg border-0 mx-auto" style="max-width: 1100px;">
    <div class="card-body">

      <!-- Search -->
      <form action="teacher-search.php" method="get" class="mb-4">
        <div class="input-group">
          <input type="text"
                 class="form-control"
                 name="searchKey"
                 placeholder="Cari guru...">
          <button class="btn btn-primary">
            <i class="fa fa-search"></i>
          </button>
        </div>
      </form>

      <!-- Table -->
      <div class="table-responsive">
        <table class="table table-hover align-middle text-center">
          <thead class="table-light">
            <tr>
              <th>#</th>
              <th>ID</th>
              <th>Nama</th>
              <th>Username</th>
              <th>Mata Pelajaran</th>
              <th>Kelas</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $i = 1; foreach ($teachers as $teacher) { ?>
            <tr>
              <td><?=$i++?></td>
              <td><?=$teacher['teacher_id']?></td>
              <td class="text-start">
                <a href="teacher-view.php?teacher_id=<?=$teacher['teacher_id']?>"
                   class="fw-semibold text-decoration-none">
                  <?=$teacher['fname']?> <?=$teacher['lname']?>
                </a>
              </td>
              <td><?=$teacher['username']?></td>

              <!-- Mata Pelajaran -->
              <td>
                <?php
                  $subjects = '';
                  foreach (str_split(trim($teacher['subjects'])) as $subject_id) {
                    $sub = getSubjectById($subject_id, $conn);
                    if ($sub) {
                      $subjects .= $sub['subject_code'].', ';
                    }
                  }
                  echo rtrim($subjects, ', ');
                ?>
              </td>

              <!-- Kelas -->
              <td>
                <?php
                  $classes = '';
                  foreach (str_split(trim($teacher['class'])) as $class_id) {
                    $class = getClassById($class_id, $conn);
                    if ($class) {
                      $grade = getGradeById($class['grade'], $conn);
                      $section = getSectioById($class['section'], $conn);
                      if ($grade && $section) {
                        $classes .= $grade['grade_code'].'-'.$grade['grade'].$section['section'].', ';
                      }
                    }
                  }
                  echo rtrim($classes, ', ');
                ?>
              </td>

              <!-- Aksi -->
              <td>
                <a href="teacher-edit.php?teacher_id=<?=$teacher['teacher_id']?>"
                   class="btn btn-sm btn-warning">
                  <i class="fa fa-edit"></i>
                </a>
                <a href="teacher-delete.php?teacher_id=<?=$teacher['teacher_id']?>"
                   class="btn btn-sm btn-danger"
                   onclick="return confirm('Yakin ingin menghapus data guru ini?')">
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
    <i class="fa fa-info-circle fa-2x mb-2"></i><br>
    Belum ada data guru.<br>
    Silakan klik <b>Tambah Guru Baru</b> untuk menambahkan data.
  </div>

  <?php } ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  $(document).ready(function(){
    $("#navLinks li:nth-child(2) a").addClass('active');
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
