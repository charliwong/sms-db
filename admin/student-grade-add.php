<?php
session_start();
if (!isset($_SESSION['admin_id']) || $_SESSION['role'] != 'Admin') {
    header("Location: ../login.php");
    exit;
}

require_once "../DB_connection.php";

/* ===============================
   AMBIL DATA MASTER
================================ */

// siswa
$students = $conn->query("
    SELECT student_id, fname, lname 
    FROM students 
    ORDER BY fname
")->fetchAll(PDO::FETCH_ASSOC);

// guru
$teachers = $conn->query("
    SELECT teacher_id, fname, lname 
    FROM teachers 
    ORDER BY fname
")->fetchAll(PDO::FETCH_ASSOC);

// mapel  ✅ PERBAIKAN DI SINI
$subjects = $conn->query("
    SELECT subject_id, subject 
    FROM subjects
")->fetchAll(PDO::FETCH_ASSOC);

// kelas (mengikuti struktur kamu di student-grade.php)
$classes = $conn->query("
    SELECT grade_id, grade, grade_code 
    FROM grades
")->fetchAll(PDO::FETCH_ASSOC);

/* ===============================
   PROSES SIMPAN
================================ */
if (isset($_POST['save'])) {

    $student_id     = $_POST['student_id'];
    $teacher_id     = $_POST['teacher_id'];
    $subject_id     = $_POST['subject_id'];
    $class_id       = $_POST['class_id'];
    $semester       = $_POST['semester'];
    $academic_year  = $_POST['academic_year'];

    $tugas_harian   = $_POST['tugas_harian'];
    $tugas_proyek   = $_POST['tugas_proyek'];
    $ujian_lisan    = $_POST['ujian_lisan'];
    $uts            = $_POST['uts'];
    $uas            = $_POST['uas'];

    /* ===============================
       VALIDASI
    ================================ */
    if (
        empty($student_id) ||
        empty($teacher_id) ||
        empty($subject_id) ||
        empty($class_id)
    ) {
        header("Location: student-grade-add.php?error=Data wajib belum lengkap");
        exit;
    }

    /* ===============================
       HITUNG NILAI AKHIR
    ================================ */
    $nilai_akhir = round(
        ($tugas_harian * 0.2) +
        ($tugas_proyek * 0.2) +
        ($ujian_lisan * 0.2) +
        ($uts * 0.2) +
        ($uas * 0.2),
        2
    );

    /* ===============================
       INSERT DATA
    ================================ */
    $stmt = $conn->prepare("
        INSERT INTO student_grades (
            student_id,
            teacher_id,
            subject_id,
            class_id,
            tugas_harian,
            tugas_proyek,
            ujian_lisan,
            nilai_uts,
            nilai_uas,
            nilai_akhir,
            semester,
            academic_year
        ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)
    ");

    $stmt->execute([
        $student_id,
        $teacher_id,
        $subject_id,
        $class_id,
        $tugas_harian,
        $tugas_proyek,
        $ujian_lisan,
        $uts,
        $uas,
        $nilai_akhir,
        $semester,
        $academic_year
    ]);

    header("Location: student-grade.php?success=Nilai berhasil ditambahkan");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Nilai Siswa</title>
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-4">

<h4 class="mb-4 text-primary">➕ Tambah Nilai Siswa</h4>

<?php if (isset($_GET['error'])): ?>
<div class="alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></div>
<?php endif; ?>

<form method="post">

<div class="row mb-3">
    <div class="col-md-4">
        <label>Siswa</label>
        <select name="student_id" class="form-select" required>
            <option value="">-- Pilih Siswa --</option>
            <?php foreach ($students as $s): ?>
                <option value="<?= $s['student_id'] ?>">
                    <?= $s['fname'].' '.$s['lname'] ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="col-md-4">
        <label>Guru</label>
        <select name="teacher_id" class="form-select" required>
            <option value="">-- Pilih Guru --</option>
            <?php foreach ($teachers as $t): ?>
                <option value="<?= $t['teacher_id'] ?>">
                    <?= $t['fname'].' '.$t['lname'] ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="col-md-4">
        <label>Mata Pelajaran</label>
        <select name="subject_id" class="form-select" required>
            <option value="">-- Pilih Mapel --</option>
            <?php foreach ($subjects as $sb): ?>
                <option value="<?= $sb['subject_id'] ?>">
                    <?= $sb['subject'] ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-4">
        <label>Kelas</label>
        <select name="class_id" class="form-select" required>
            <option value="">-- Pilih Kelas --</option>
            <?php foreach ($classes as $c): ?>
                <option value="<?= $c['grade_id'] ?>">
                    <?= $c['grade_code'].' '.$c['grade'] ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="col-md-4">
        <label>Semester</label>
        <select name="semester" class="form-select">
            <option value="Ganjil">Ganjil</option>
            <option value="Genap">Genap</option>
        </select>
    </div>

    <div class="col-md-4">
        <label>Tahun Ajaran</label>
        <input type="text" name="academic_year" class="form-control"
               placeholder="2025/2026" required>
    </div>
</div>

<hr>

<div class="row mb-3">
    <div class="col"><input type="number" name="tugas_harian" class="form-control" placeholder="Tugas Harian" required></div>
    <div class="col"><input type="number" name="tugas_proyek" class="form-control" placeholder="Tugas Proyek" required></div>
    <div class="col"><input type="number" name="ujian_lisan" class="form-control" placeholder="Ujian Lisan" required></div>
    <div class="col"><input type="number" name="uts" class="form-control" placeholder="UTS" required></div>
    <div class="col"><input type="number" name="uas" class="form-control" placeholder="UAS" required></div>
</div>

<button type="submit" name="save" class="btn btn-primary">Simpan</button>
<a href="student-grade.php" class="btn btn-secondary">Kembali</a>

</form>
</body>
</html>
