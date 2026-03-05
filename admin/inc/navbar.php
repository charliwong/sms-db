<?php
$current = basename($_SERVER['PHP_SELF']);
function active($page) {
  global $current;
  return ($current == $page) ? 'active' : '';
}
?>

<nav class="navbar navbar-expand-lg navbar-dark navbar-custom shadow-sm">
  <div class="container-fluid">

    <!-- Brand -->
    <a class="navbar-brand d-flex align-items-center" href="index.php">
      <img src="../logos.png" width="40" class="me-2">
      <span class="fw-semibold">Academic System</span>
    </a>

    <!-- Toggle -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
      data-bs-target="#navbarSupportedContent">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Menu -->
    <div class="collapse navbar-collapse" id="navbarSupportedContent">

      <!-- LEFT -->
      <ul class="navbar-nav me-auto mb-2 mb-lg-0 gap-lg-1">

        <!-- Dashboard -->
        <li class="nav-item">
          <a class="nav-link <?=active('index.php')?>" href="index.php">
            Dashboard
          </a>
        </li>

        <!-- MASTER DATA -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
            Master Data
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item <?=active('user.php')?>" href="user.php">Pengguna</a></li>
            <li><a class="dropdown-item <?=active('teacher.php')?>" href="teacher.php">Guru</a></li>
            <li><a class="dropdown-item <?=active('student.php')?>" href="student.php">Siswa</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item <?=active('grade.php')?>" href="grade.php">Tingkatan</a></li>
            <li><a class="dropdown-item <?=active('class.php')?>" href="class.php">Kelas</a></li>
            <li><a class="dropdown-item <?=active('section.php')?>" href="section.php">Sesi</a></li>
          </ul>
        </li>

        <!-- AKADEMIK -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
            Akademik
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item <?=active('course.php')?>" href="course.php">Mata Pelajaran</a></li>
            <li><a class="dropdown-item <?=active('schedule.php')?>" href="schedule.php">Jadwal</a></li>
            <li><a class="dropdown-item <?=active('score.php')?>" href="score.php">Nilai</a></li>
            <li><a class="dropdown-item <?=active('attendance.php')?>" href="attendance.php">Kehadiran</a></li>
          </ul>
        </li>

        <!-- REGISTRASI -->
        <li class="nav-item">
          <a class="nav-link <?=active('registrar-office.php')?>" href="registrar-office.php">
            Registrasi
          </a>
        </li>

        <!-- PESAN -->
        <li class="nav-item">
          <a class="nav-link <?=active('message.php')?>" href="message.php">
            Pesan
          </a>
        </li>

        <!-- LAPORAN -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
            Laporan
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item <?=active('report_view.php')?>" href="report_view.php">Lihat Laporan</a></li>
            <li><a class="dropdown-item <?=active('report_print.php')?>" href="report_print.php">Cetak Laporan</a></li>
          </ul>
        </li>

      </ul>

      <!-- RIGHT -->
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
            Account
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item <?=active('settings.php')?>" href="settings.php">Settings</a></li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <a class="dropdown-item text-danger" href="../logout.php">
                Logout
              </a>
            </li>
          </ul>
        </li>
      </ul>

    </div>
  </div>
</nav>
