<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if (!isset($_SESSION['admin_id']) || $_SESSION['role'] != 'Admin') {
    header("Location: ../login.php");
    exit;
}

require_once "../DB_connection.php";

// ambil data dropdown
$subjects = $conn->query("SELECT subject_id, subject FROM subjects")->fetchAll();
$teachers = $conn->query("SELECT teacher_id, fname, lname FROM teachers")->fetchAll();
$grades   = $conn->query("SELECT grade_id, grade FROM grades")->fetchAll();

if (isset($_POST['save'])) {
    $subject_id = $_POST['subject_id'];
    $teacher_id = $_POST['teacher_id'];
    $grade_id   = $_POST['grade_id'];
    $day        = $_POST['day'];
    $start_time = $_POST['start_time'];
    $end_time   = $_POST['end_time'];
    $room       = $_POST['room'];
    $year       = $_POST['academic_year'];
    $semester   = $_POST['semester'];

    $stmt = $conn->prepare(
        "INSERT INTO schedule
        (subject_id, teacher_id, grade_id, day, start_time, end_time, room, academic_year, semester)
        VALUES (?,?,?,?,?,?,?,?,?)"
    );

    $stmt->execute([
        $subject_id,
        $teacher_id,
        $grade_id,
        $day,
        $start_time,
        $end_time,
        $room,
        $year,
        $semester
    ]);

    header("Location: schedule.php?success=Jadwal berhasil ditambahkan");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin - Tambah Jadwal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../logos.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css?v=2">
</head>
<body>

<?php include "inc/navbar.php"; ?>

<div class="container my-5">
    <h3 class="text-center text-primary fw-bold mb-4">➕ Tambah Jadwal</h3>

    <form method="post" class="row g-3">

        <div class="col-md-4">
            <label class="form-label">Mata Pelajaran</label>
            <select name="subject_id" class="form-select" required>
                <option value="">-- Pilih --</option>
                <?php foreach ($subjects as $s): ?>
                    <option value="<?= $s['subject_id'] ?>"><?= $s['subject'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-4">
            <label class="form-label">Guru</label>
            <select name="teacher_id" class="form-select" required>
                <option value="">-- Pilih --</option>
                <?php foreach ($teachers as $t): ?>
                    <option value="<?= $t['teacher_id'] ?>">
                        <?= $t['fname'].' '.$t['lname'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-4">
            <label class="form-label">Tingkatan</label>
            <select name="grade_id" class="form-select" required>
                <option value="">-- Pilih --</option>
                <?php foreach ($grades as $g): ?>
                    <option value="<?= $g['grade_id'] ?>"><?= $g['grade'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-3">
            <label class="form-label">Hari</label>
            <select name="day" class="form-select" required>
                <option>Senin</option>
                <option>Selasa</option>
                <option>Rabu</option>
                <option>Kamis</option>
                <option>Jumat</option>
                <option>Sabtu</option>
            </select>
        </div>

        <div class="col-md-3">
            <label class="form-label">Mulai</label>
            <input type="time" name="start_time" class="form-control" required>
        </div>

        <div class="col-md-3">
            <label class="form-label">Selesai</label>
            <input type="time" name="end_time" class="form-control" required>
        </div>

        <div class="col-md-3">
            <label class="form-label">Ruangan</label>
            <input type="text" name="room" class="form-control" required>
        </div>

        <div class="col-md-4">
            <label class="form-label">Tahun Akademik</label>
            <input type="text" name="academic_year" class="form-control" placeholder="2025/2026" required>
        </div>

        <div class="col-md-2">
            <label class="form-label">Semester</label>
            <select name="semester" class="form-select" required>
                <option value="1">1</option>
                <option value="2">2</option>
            </select>
        </div>

        <div class="col-12 text-center">
            <button name="save" class="btn btn-primary">
                Simpan Jadwal
            </button>
            <a href="schedule.php" class="btn btn-secondary">
                Kembali
            </a>
        </div>

    </form>
</div>

</body>
</html>
