<nav class="navbar navbar-expand-lg navbar-dark navbar-custom shadow-sm">
  <div class="container-fluid">

    <!-- Brand -->
    <a class="navbar-brand d-flex align-items-center" href="index.php">
      <img src="../logo.png" width="40" class="me-2">
      <span class="fw-semibold">Academic System</span>
    </a>

    <!-- Toggle -->
    <button class="navbar-toggler" type="button"
      data-bs-toggle="collapse"
      data-bs-target="#navbarSupportedContent">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Menu -->
    <div class="collapse navbar-collapse" id="navbarSupportedContent">

      <!-- Left Menu -->
      <ul class="navbar-nav me-auto mb-2 mb-lg-0 gap-lg-1" id="navLinks">
        <li class="nav-item">
          <a class="nav-link" href="index.php">
            <i class="fa fa-dashboard me-1"></i> Dashboard
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="schedule.php">
            <i class="fa fa-calendar me-1"></i> Jadwal
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="students.php">
            <i class="fa fa-university me-1"></i> Kelas Saya
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="attendance.php">
            <i class="fa fa-check-square me-1"></i> Kehadiran
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="score.php">
            <i class="fa fa-pencil me-1"></i> Nilai
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="pass.php">
            <i class="fa fa-lock me-1"></i> Change Password
          </a>
        </li>
      </ul>

      <!-- Right Menu -->
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button"
             data-bs-toggle="dropdown">
            <i class="fa fa-user-circle me-1"></i> Account
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li>
              <a class="dropdown-item text-danger" href="../logout.php">
                <i class="fa fa-sign-out me-1"></i> Logout
              </a>
            </li>
          </ul>
        </li>
      </ul>

    </div>
  </div>
</nav>
