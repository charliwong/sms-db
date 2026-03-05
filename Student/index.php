<?php 
session_start();
if (isset($_SESSION['student_id']) && 
    isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'Student') {
       include "../DB_connection.php";
       include "data/student.php";
       include "data/subject.php";
       include "data/grade.php";
       include "data/section.php";

       $student_id = $_SESSION['student_id'];

       $student = getStudentById($student_id, $conn);
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Home - Siswa</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="../css/style.css">
	<link rel="icon" href="../logos.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<?php include "inc/navbar.php"; ?>

<?php if ($student != 0) { ?>
<div class="container mt-5 d-flex justify-content-center">

  <div class="card shadow-sm" style="max-width: 800px; width:100%;">
    
    <!-- HEADER -->
    <div class="card-header bg-primary text-white text-center">
      <img src="../img/student-<?=$student['gender']?>.png"
           class="rounded-circle mb-2"
           width="90">
      <h5 class="mb-0">@<?=$student['username']?></h5>
      <small>Profil Siswa</small>
    </div>

    <!-- BODY -->
    <div class="card-body">

      <div class="row">

        <!-- LEFT -->
        <div class="col-md-6">
          <ul class="list-group list-group-flush">
            <li class="list-group-item">
              <b>Nama Depan:</b> <?=$student['fname']?>
            </li>
            <li class="list-group-item">
              <b>Nama Belakang:</b> <?=$student['lname']?>
            </li>
            <li class="list-group-item">
              <b>Email:</b> <?=$student['email_address']?>
            </li>
            <li class="list-group-item">
              <b>Jenis Kelamin:</b> <?=$student['gender']?>
            </li>
            <li class="list-group-item">
              <b>Tanggal Lahir:</b> <?=$student['date_of_birth']?>
            </li>
          </ul>
        </div>

        <!-- RIGHT -->
        <div class="col-md-6">
          <ul class="list-group list-group-flush">
            <li class="list-group-item">
              <b>Kelas:</b>
              <?php
                $g = getGradeById($student['grade'], $conn);
                echo $g['grade_code'].'-'.$g['grade'];
              ?>
            </li>
            <li class="list-group-item">
              <b>Sesi:</b>
              <?php
                $s = getSectioById($student['section'], $conn);
                echo $s['section'];
              ?>
            </li>
            <li class="list-group-item">
              <b>Alamat:</b> <?=$student['address']?>
            </li>
            <li class="list-group-item">
              <b>Tanggal Pendaftaran:</b> <?=$student['date_of_joined']?>
            </li>
          </ul>
        </div>

      </div>

      <hr>

      <!-- PARENT INFO -->
      <h6 class="fw-bold text-center mb-3">Informasi Orang Tua</h6>
      <div class="row text-center">
        <div class="col-md-4">
          <b>Nama Depan</b><br>
          <?=$student['parent_fname']?>
        </div>
        <div class="col-md-4">
          <b>Nama Belakang</b><br>
          <?=$student['parent_lname']?>
        </div>
        <div class="col-md-4">
          <b>Nomor Telepon</b><br>
          <?=$student['parent_phone_number']?>
        </div>
      </div>

    </div>
  </div>
</div>

     <?php 
        }else {
          header("Location: student.php");
          exit;
        }
     ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>	
   <script>
        $(document).ready(function(){
             $("#navLinks li:nth-child(1) a").addClass('active');
        });
    </script>
</body>
</html>
<?php 

  }else {
    header("Location: ../login.php");
    exit;
  } 
}else {
	header("Location: ../login.php");
	exit;
} 

?>