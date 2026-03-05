<?php
session_start();
if (!isset($_SESSION['admin_id']) || $_SESSION['role'] != 'Admin') {
    header("Location: ../login.php");
    exit;
}

require_once "../DB_connection.php";

$error = "";
$success = "";

if (isset($_POST['save'])) {

    $role     = $_POST['role'];
    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $fname    = trim($_POST['fname']);
    $lname    = trim($_POST['lname']);

    if ($username == "" || $_POST['password'] == "" || $fname == "" || $lname == "") {
        $error = "Semua field wajib diisi!";
    } else {

        switch ($role) {
            case "Admin":
                $sql = "INSERT INTO admin (username, password, fname, lname)
                        VALUES (?,?,?,?)";
                break;

            case "Guru":
                $sql = "INSERT INTO teachers (username, password, fname, lname)
                        VALUES (?,?,?,?)";
                break;

            case "Siswa":
                $sql = "INSERT INTO students (username, password, fname, lname)
                        VALUES (?,?,?,?)";
                break;

            case "Tata Usaha":
                $sql = "INSERT INTO registrar_office (username, password, fname, lname)
                        VALUES (?,?,?,?)";
                break;

            default:
                $error = "Role tidak valid";
        }

        if ($error == "") {
            $stmt = $conn->prepare($sql);
            $stmt->execute([$username, $password, $fname, $lname]);
            $success = "User berhasil ditambahkan";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Pengguna</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css?v=2">
</head>
<body>

<?php include "inc/navbar.php"; ?>

<div class="container my-5">
    <div class="card shadow border-0 mx-auto" style="max-width:600px">
        <div class="card-body">
            <h4 class="text-center mb-4 text-primary fw-bold">
                ➕ Tambah Pengguna
            </h4>

            <?php if ($error): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="alert alert-success">
                    <?= $success ?>
                    <br>
                    <a href="user.php">← Kembali ke daftar user</a>
                </div>
            <?php endif; ?>

            <form method="post">

                <div class="mb-3">
                    <label class="form-label">Role</label>
                    <select name="role" class="form-select" required>
                        <option value="">-- Pilih Role --</option>
                        <option value="Admin">Admin</option>
                        <option value="Guru">Guru</option>
                        <option value="Siswa">Siswa</option>
                        <option value="Tata Usaha">Tata Usaha</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Depan</label>
                    <input type="text" name="fname" class="form-control" required>
                </div>

                <div class="mb-4">
                    <label class="form-label">Nama Belakang</label>
                    <input type="text" name="lname" class="form-control" required>
                </div>

                <div class="d-flex justify-content-between">
                    <button name="save" class="btn btn-primary">
                        Simpan
                    </button>
                    <a href="user.php" class="btn btn-secondary">
                        Batal
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>

</body>
</html>
