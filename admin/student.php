<?php 
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role'])) {

  if ($_SESSION['role'] == 'Admin') {

    include "../DB_connection.php";
    include "data/student.php";
    include "data/grade.php";

    $students = getAllStudents($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin - Students</title>

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
    Manajemen Siswa
  </h3>

  <!-- Tombol Tambah (SELALU TAMPIL) -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <a href="student-add.php" class="btn btn-primary">
      <i class="fa fa-plus"></i> Tambah Siswa Baru
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
  <?php if ($students != 0) { ?>

  <!-- Card -->
  <div class="card shadow-lg border-0 mx-auto" style="max-width: 1100px;">
    <div class="card-body">

      <!-- Search -->
      <form action="student-search.php" method="get" class="mb-4">
        <div class="input-group">
          <input type="text"
                 class="form-control"
                 name="searchKey"
                 placeholder="Cari siswa...">
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
              <th>NISN</th>
              <th>Nama</th>
              <th>Username</th>
              <th>Kelas</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $i = 1; foreach ($students as $student) { ?>
            <tr>
              <td><?=$i++?></td>
              <td><?=$student['student_id']?></td>
              <td class="text-start">
                <a href="student-view.php?student_id=<?=$student['student_id']?>"
                   class="fw-semibold text-decoration-none">
                  <?=$student['fname']?> <?=$student['lname']?>
                </a>
              </td>
              <td><?=$student['username']?></td>
              <td>
                <?php 
                  $g = getGradeById($student['grade'], $conn);
                  if ($g) {
                    echo $g['grade_code']." - ".$g['grade'];
                  }
                ?>
              </td>
              <td>
                <a href="student-edit.php?student_id=<?=$student['student_id']?>"
                   class="btn btn-sm btn-warning">
                  <i class="fa fa-edit"></i>
                </a>
                <a href="student-delete.php?student_id=<?=$student['student_id']?>"
                   class="btn btn-sm btn-danger"
                   onclick="return confirm('Yakin ingin menghapus data siswa ini?')">
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
    Belum ada data siswa.<br>
    Silakan klik <b>Tambah Siswa Baru</b> untuk menambahkan data.
  </div>

  <?php } ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>  
<script>
  $(document).ready(function(){
    $("#navLinks li:nth-child(3) a").addClass('active');
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
