<?php 
session_start();
if (isset($_SESSION['r_user_id']) && isset($_SESSION['role']) &&
    $_SESSION['role'] == 'Registrar Office') {
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kepala Sekolah Dashboard</title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/style.css?v=2">
  <link rel="icon" href="logos.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<?php include "inc/navbar.php"; ?>

<div class="container my-5">
  <h3 class="text-center mb-4 fw-bold text-primary">
    Kepala Sekolah Dashboard
  </h3>

  <div class="row g-4 justify-content-center">

    <!-- LIHAT LAPORAN -->
    <div class="col-md-4 col-sm-6">
      <a href="report_view.php" class="dash-card">
        <i class="fa fa-eye"></i>
        <span>Lihat Laporan</span>
      </a>
    </div>   

    <!-- DATA SISWA -->
    <div class="col-md-4 col-sm-6">
      <a href="student.php" class="dash-card">
        <i class="fa fa-users"></i>
        <span>Data Siswa</span>
      </a>
    </div>

  </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
      <script>
         $(document).ready(function(){
         $("#navLinks li:nth-child(1) a").addClass('active');
       });
      </script>
</body>
</html>
<?php
} else {
  header("Location: ../login.php");
  exit;
}
?>
