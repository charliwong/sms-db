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
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin - Dashboard</title>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="../css/style.css?v=2">
<link rel="icon" href="logos.png">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<script>
document.querySelectorAll('.navbar-nav a').forEach(function(link){
  link.addEventListener('click', function(){
    let nav = document.querySelector('.navbar-collapse');
    if (nav.classList.contains('show')) {
      new bootstrap.Collapse(nav).toggle();
    }
  });
});
</script>

<body>

<?php include "inc/navbar.php"; ?>

<div class="container my-5">
<h3 class="text-center mb-4 fw-bold text-primary">
Admin Dashboard
</h3>

<div class="row g-4">

<!-- USERS -->
<div class="col-md-3 col-sm-6">
<a href="user.php" class="dash-card">
<i class="fa fa-users"></i>
<span>Pengguna</span>
</a>
</div>

<!-- TEACHERS -->
<div class="col-md-3 col-sm-6">
<a href="teacher.php" class="dash-card">
<i class="fa fa-user-md"></i>
<span>Guru</span>
</a>
</div>

<!-- STUDENTS -->
<div class="col-md-3 col-sm-6">
<a href="student.php" class="dash-card">
<i class="fa fa-graduation-cap"></i>
<span>Siswa</span>
</a>
</div>

<!-- NILAI -->
<div class="col-md-3 col-sm-6">
<a href="score.php" class="dash-card">
<i class="fa fa-line-chart"></i>
<span>Nilai</span>
</a>
</div>

<!-- REGISTRAR -->
<div class="col-md-3 col-sm-6">
<a href="registrar-office.php" class="dash-card">
<i class="fa fa-pencil-square"></i>
<span>Registrasi</span>
</a>
</div>

<!-- KELAS -->
<div class="col-md-3 col-sm-6">
<a href="class.php" class="dash-card">
<i class="fa fa-cubes"></i>
<span>Kelas</span>
</a>
</div>

<!-- SESI -->
<div class="col-md-3 col-sm-6">
<a href="section.php" class="dash-card">
<i class="fa fa-columns"></i>
<span>Sesi</span>
</a>
</div>

<!-- KEHADIRAN -->
<div class="col-md-3 col-sm-6">
<a href="attendance.php" class="dash-card">
<i class="fa fa-calendar-check-o"></i>
<span>Kehadiran</span>
</a>
</div>

<!-- TINGKAT -->
<div class="col-md-3 col-sm-6">
<a href="grade.php" class="dash-card">
<i class="fa fa-level-up"></i>
<span>Tingkatan</span>
</a>
</div>

<!-- MAPEL -->
<div class="col-md-3 col-sm-6">
<a href="course.php" class="dash-card">
<i class="fa fa-book"></i>
<span>Mata Pelajaran</span>
</a>
</div>

<!-- JADWAL -->
<div class="col-md-3 col-sm-6">
<a href="schedule.php" class="dash-card">
<i class="fa fa-clock-o"></i>
<span>Jadwal</span>
</a>
</div>

<!-- PESAN -->
<div class="col-md-3 col-sm-6">
<a href="message.php" class="dash-card">
<i class="fa fa-envelope"></i>
<span>Pesan</span>
</a>
</div>

<!-- 🔥 LIHAT LAPORAN -->
<div class="col-md-3 col-sm-6">
<a href="report_view.php" class="dash-card">
<i class="fa fa-eye"></i>
<span>Lihat Laporan</span>
</a>
</div>

<!-- 🔥 CETAK LAPORAN -->
<div class="col-md-3 col-sm-6">
<a href="report_print.php" class="dash-card">
<i class="fa fa-print"></i>
<span>Cetak Laporan</span>
</a>
</div>

<!-- SETTINGS -->
<div class="col-md-3 col-sm-6">
<a href="settings.php" class="dash-card">
<i class="fa fa-cogs"></i>
<span>Settings</span>
</a>
</div>

<!-- LOGOUT -->
<div class="col-md-3 col-sm-6">
<a href="../logout.php" class="dash-card">
<i class="fa fa-sign-out"></i>
<span>Logout</span>
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
