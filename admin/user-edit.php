<?php
session_start();

if (!isset($_SESSION['admin_id']) || $_SESSION['role'] !== 'Admin') {
    header("Location: ../login.php");
    exit;
}

require_once "../DB_connection.php";

/* =========================
   VALIDASI PARAMETER
========================= */
if (!isset($_GET['id'], $_GET['role'])) {
    die("Parameter ID / Role tidak ditemukan");
}

$id   = (int) $_GET['id'];
$role = trim($_GET['role']);

/* =========================
   MAPPING ROLE → TABEL
========================= */
$table = "";
$idCol = "";

$role = strtolower(trim($_GET['role']));

switch ($role) {
    case 'admin':
        $table = 'admin';
        $idCol = 'admin_id';
        break;

    case 'teacher':
        $table = 'teachers';
        $idCol = 'teacher_id';
        break;

    case 'student':
        $table = 'students';
        $idCol = 'student_id';
        break;

    case 'registrar':
    case 'registrar_office':
        $table = 'registrar_office';
        $idCol = 'r_user_id';
        break;

    default:
        die("Role tidak dikenali: " . htmlspecialchars($role));
}


/* =========================
   AMBIL DATA USER
========================= */
$stmt = $conn->prepare("SELECT username, fname, lname FROM {$table} WHERE {$idCol} = ?");
$stmt->execute([$id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("Data user tidak ditemukan di tabel {$table}");
}

/* =========================
   UPDATE DATA
========================= */
if (isset($_POST['update'])) {
    $username = trim($_POST['username']);
    $fname    = trim($_POST['fname']);
    $lname    = trim($_POST['lname']);

    $update = $conn->prepare(
        "UPDATE {$table}
         SET username = ?, fname = ?, lname = ?
         WHERE {$idCol} = ?"
    );

    $update->execute([$username, $fname, $lname, $id]);

    header("Location: user.php?success=edit");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h4 class="mb-4 text-primary">✏️ Edit User (<?=htmlspecialchars($role)?>)</h4>

    <form method="post" class="card p-4 shadow">

        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control"
                   value="<?=htmlspecialchars($user['username'])?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Nama Depan</label>
            <input type="text" name="fname" class="form-control"
                   value="<?=htmlspecialchars($user['fname'])?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Nama Belakang</label>
            <input type="text" name="lname" class="form-control"
                   value="<?=htmlspecialchars($user['lname'])?>" required>
        </div>

        <div class="mt-3">
            <button name="update" class="btn btn-primary">Simpan Perubahan</button>
            <a href="user.php" class="btn btn-secondary">Kembali</a>
        </div>

    </form>
</div>

</body>
</html>
