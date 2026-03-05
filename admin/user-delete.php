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
if (empty($_GET['id']) || empty($_GET['role'])) {
    header("Location: user.php?error=Parameter tidak lengkap");
    exit;
}

$id   = (int) $_GET['id'];
$role = trim($_GET['role']);

/* =========================
   TENTUKAN TABEL & ID
========================= */
switch ($role) {
    case "Admin":
        $table = "admin";
        $idCol = "admin_id";
        break;

    case "Teacher":
        $table = "teachers";
        $idCol = "teacher_id";
        break;

    case "Student":
        $table = "students";
        $idCol = "student_id";
        break;

    case "Registrar":
        $table = "registrar_office";
        $idCol = "r_user_id";
        break;

    default:
        header("Location: user.php?error=Role tidak valid");
        exit;
}


/* =========================
   BLOKIR HAPUS DIRI SENDIRI
========================= */
if ($role === "Admin" && $id === (int)$_SESSION['admin_id']) {
    header("Location: user.php?error=Tidak bisa menghapus akun sendiri");
    exit;
}

/* =========================
   CEK DATA ADA / TIDAK
========================= */
$check = $conn->prepare("SELECT {$idCol} FROM {$table} WHERE {$idCol} = ?");
$check->execute([$id]);

if ($check->rowCount() === 0) {
    header("Location: user.php?error=Data tidak ditemukan");
    exit;
}

if ($role === 'Teacher') {
    $cek = $conn->prepare(
        "SELECT COUNT(*) FROM student_grades WHERE teacher_id = ?"
    );
    $cek->execute([$id]);

    if ($cek->fetchColumn() > 0) {
        header("Location: user.php?error=Guru masih memiliki data nilai siswa");
        exit;
    }
}

/* =========================
   PROSES DELETE
========================= */
$stmt = $conn->prepare("DELETE FROM {$table} WHERE {$idCol} = ?");
$stmt->execute([$id]);

header("Location: user.php?success=User berhasil dihapus");
exit;
