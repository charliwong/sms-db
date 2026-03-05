<?php
session_start();

if (!isset($_SESSION['teacher_id']) || $_SESSION['role'] !== 'Teacher') {
    header("Location: ../login.php");
    exit;
}

if (!isset($_GET['class_id']) || !is_numeric($_GET['class_id']) || !isset($_GET['date'])) {
    header("Location: attendance-add.php");
    exit;
}

include "../DB_connection.php";
include "data/class.php";
include "data/student.php";

$teacher_id = $_SESSION['teacher_id'];
$class_id   = (int)$_GET['class_id'];
$date       = $_GET['date'];

/* ===============================
   VALIDASI KELAS MILIK GURU
=================================*/
$stmt = $conn->prepare("SELECT class FROM teachers WHERE teacher_id = ?");
$stmt->execute(array($teacher_id));
$teacher = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$teacher) {
    header("Location: attendance-add.php?error=Guru tidak ditemukan");
    exit;
}

$allowed_classes = array_map('intval', explode(',', $teacher['class']));

if (!in_array($class_id, $allowed_classes)) {
    header("Location: attendance-add.php?error=Akses ditolak");
    exit;
}

/* ===============================
   AMBIL DATA KELAS
=================================*/
$class = getClassById($class_id, $conn);
if (!$class) {
    header("Location: attendance-add.php?error=Kelas tidak ditemukan");
    exit;
}

/* ===============================
   AMBIL DATA SISWA
=================================*/
$students = getStudentsByClassId($class_id, $conn);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Input Kehadiran</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css?v=2">
    <link rel="icon" href="../logos.png">
</head>
<body>

<?php include "inc/navbar.php"; ?>

<div class="container my-5">

    <h4 class="text-center fw-bold mb-4">
        Input Kehadiran <br>
        <small class="text-muted">
            Tanggal: <?= htmlspecialchars($date) ?>
        </small>
    </h4>

<?php if (!empty($students)): ?>

<form action="attendance-save.php" method="post">

    <input type="hidden" name="class_id" value="<?= $class_id ?>">
    <input type="hidden" name="date" value="<?= htmlspecialchars($date) ?>">

    <div class="card shadow-sm">
        <div class="card-body table-responsive">

            <table class="table table-bordered text-center align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nama Siswa</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>

                <?php $no = 1; foreach ($students as $s): ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td>
                        <?= htmlspecialchars($s['fname'].' '.$s['lname']); ?>
                        <input type="hidden" name="student_id[]" value="<?= $s['student_id']; ?>">
                    </td>
                    <td>
                        <select name="status[]" class="form-select" required>
                            <option value="">-- Pilih --</option>
                            <option value="Hadir">Hadir</option>
                            <option value="Izin">Izin</option>
                            <option value="Alpha">Alpha</option>
                        </select>
                    </td>
                </tr>
                <?php endforeach; ?>

                </tbody>
            </table>

        </div>
    </div>

    <div class="mt-4 text-center">
        <button type="submit" class="btn btn-success">
            💾 Simpan Kehadiran
        </button>

        <a href="attendance-add.php" class="btn btn-secondary">
            ⬅ Kembali
        </a>
    </div>

</form>

<?php else: ?>

    <div class="alert alert-info text-center">
        Tidak ada siswa di kelas ini.
    </div>

<?php endif; ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    var nav = document.querySelector("#navLinks li:nth-child(3) a");
    if(nav){ nav.classList.add('active'); }
</script>
</body>
</html>