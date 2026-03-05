<?php 
session_start();

if (!isset($_SESSION['admin_id']) || $_SESSION['role'] !== 'Admin') {
    header("Location: ../login.php");
    exit;
}

require_once "../DB_connection.php";
require_once "data/user.php";

$users = getAllUsers($conn);
?>

<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="UTF-8">
	<title>Admin - Manajemen Pengguna</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="../css/style.css?v=2">
	<link rel="icon" href="../logos.png">
  <link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
      integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
      crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body>

<?php include "inc/navbar.php"; ?>

<div class="container my-5">
  <h3 class="text-center fw-bold mb-4 text-primary">
    Manajemen Pengguna
  </h3>

  <div class="d-flex justify-content-between mb-4">
    <a href="user-add.php" class="btn btn-primary">
      <i class="fa fa-plus"></i> Tambah Pengguna
    </a>
  </div>

<?php if ($users != 0): ?>
  <div class="card shadow border-0">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover text-center align-middle">
          <thead class="table-light">
            <tr>
              <th>#</th>
              <th>Username</th>
              <th>Nama Lengkap</th>
              <th>Role</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
          <?php $i = 1; foreach ($users as $user): ?>
            <tr>
              <td><?= $i++ ?></td>

              <td><?= htmlspecialchars($user['username']) ?></td>

              <td><?= htmlspecialchars($user['fname'].' '.$user['lname']) ?></td>

              <td>
                <span class="badge bg-secondary">
                  <?= htmlspecialchars($user['role']) ?>
                </span>
              </td>

              <td>
               <a href="user-edit.php?id=<?= $user['id'] ?>&role=<?= urlencode($user['role']) ?>"
   class="btn btn-sm btn-warning">
   <i class="fa-solid fa-pen"></i>
</a>

<a href="user-delete.php?id=<?= $user['id'] ?>&role=<?= urlencode($user['role']) ?>"
   class="btn btn-sm btn-danger"
   onclick="return confirm('Yakin hapus user ini?')">
   <i class="fa-solid fa-trash"></i>
</a>


              </td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
<?php else: ?>
  <div class="alert alert-info text-center">
    Data pengguna belum tersedia
  </div>
<?php endif; ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  document.querySelector("#navLinks li:nth-child(4) a")?.classList.add('active');
</script>
</body>
</html>
