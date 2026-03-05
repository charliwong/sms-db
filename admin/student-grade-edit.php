<?php
session_start();
if (!isset($_SESSION['admin_id']) || $_SESSION['role'] != 'Admin') {
    header("Location: ../login.php");
    exit;
}

require_once "../DB_connection.php";

/* ===============================
   VALIDASI ID
================================ */
if (!isset($_GET['id'])) {
    header("Location: student-grade.php");
    exit;
}

$grade_id = $_GET['id'];

/* ===============================
   AMBIL DATA NILAI
================================ */
$stmt = $conn->prepare("
    SELECT * FROM student_grades 
    WHERE grade_record_id = ?
");
$stmt->execute([$grade_id]);
$grade = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$grade) {
    header("Location: student-grade.php?error=Data tidak ditemukan");
    exit;
}

/* ===============================
   DATA MASTER
================================ */
$students = $conn->query("SELECT student_id, fname, lname FROM students")->fetchAll(PDO::FETCH_ASSOC);
$teachers = $conn->query("SELECT teacher_id, fname, lname FROM teachers")->fetchAll(PDO::FETCH_ASSOC);
$subjects = $conn->query("SELECT subject_id, subject AS subject_name FROM subjects")->fetchAll(PDO::FETCH_ASSOC);
$classes = $conn->query("SELECT c.class_id, g.grade, s.section FROM class c JOIN grades g ON g.grade_id = c.grade JOIN section s ON s.section_id = c.section")->fetchAll(PDO::FETCH_ASSOC);

    
/* ===============================
   PROSES UPDATE
================================ */
if (isset($_POST['update'])) {

    $student_id    = $_POST['student_id'];
    $teacher_id    = $_POST['teacher_id'];
    $subject_id    = $_POST['subject_id'];
    $class_id      = $_POST['class_id'];
    $semester      = $_POST['semester'];
    $academic_year = $_POST['academic_year'];

    $tugas_harian  = $_POST['tugas_harian'];
    $tugas_proyek = $_POST['tugas_proyek'];
    $ujian_lisan   = $_POST['ujian_lisan'];
    $uts           = $_POST['uts'];
    $uas           = $_POST['uas'];

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
       UPDATE DATA
    ================================ */
    $stmt = $conn->prepare("
        UPDATE student_grades SET
            student_id    = ?,
            teacher_id    = ?,
            subject_id    = ?,
            class_id      = ?,
            tugas_harian  = ?,
            tugas_proyek = ?,
            ujian_lisan   = ?,
            nilai_uts     = ?,
            nilai_uas     = ?,
            nilai_akhir   = ?,
            semester      = ?,
            academic_year = ?
        WHERE grade_record_id = ?
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
        $academic_year,
        $grade_id
    ]);

    header("Location: student-grade.php?success=Nilai berhasil diperbarui");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Nilai Siswa</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="../css/style.css?v=2">
	<link rel="icon" href="../logos.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
</head>

<body>

<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="col-lg-10 col-xl-9">

        <div class="card">
            <div class="card-header bg-warning text-dark fw-bold">
                <i class="bi bi-pencil-square"></i> Edit Nilai Siswa
            </div>

            <div class="card-body">

                <form method="post">

                <!-- ROW 1 -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Siswa</label>
                        <select name="student_id" class="form-select" required>
                            <?php foreach ($students as $s): ?>
                                <option value="<?= $s['student_id'] ?>"
                                    <?= $grade['student_id'] == $s['student_id'] ? 'selected' : '' ?>>
                                    <?= $s['fname'].' '.$s['lname'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Guru</label>
                        <select name="teacher_id" class="form-select" required>
                            <?php foreach ($teachers as $t): ?>
                                <option value="<?= $t['teacher_id'] ?>"
                                    <?= $grade['teacher_id'] == $t['teacher_id'] ? 'selected' : '' ?>>
                                    <?= $t['fname'].' '.$t['lname'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Mata Pelajaran</label>
                        <select name="subject_id" class="form-select" required>
                            <?php foreach ($subjects as $sb): ?>
                                <option value="<?= $sb['subject_id'] ?>"
                                    <?= $grade['subject_id'] == $sb['subject_id'] ? 'selected' : '' ?>>
                                    <?= $sb['subject_name'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <!-- ROW 2 -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Kelas</label>
                        <select name="class_id" class="form-select" required>
                            <?php foreach ($classes as $row): ?>
                                <option value="<?= $row['class_id'] ?>"
                                    <?= $grade['class_id'] == $row['class_id'] ? 'selected' : '' ?>>
                                    <?= $row['grade'] ?> - <?= $row['section'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Semester</label>
                        <select name="semester" class="form-select">
                            <option value="Ganjil" <?= $grade['semester']=='Ganjil'?'selected':'' ?>>Ganjil</option>
                            <option value="Genap" <?= $grade['semester']=='Genap'?'selected':'' ?>>Genap</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Tahun Ajaran</label>
                        <input type="text" name="academic_year" class="form-control"
                               value="<?= $grade['academic_year'] ?>" required>
                    </div>
                </div>

                <hr>

                <!-- NILAI -->
                <div class="row mb-4 text-center">
                    <div class="col">
                        <label class="form-label">Tugas Harian</label>
                        <input type="number" name="tugas_harian" class="form-control"
                               value="<?= $grade['tugas_harian'] ?>" required>
                    </div>
                    <div class="col">
                        <label class="form-label">Tugas Proyek</label>
                        <input type="number" name="tugas_proyek" class="form-control"
                               value="<?= $grade['tugas_proyek'] ?>" required>
                    </div>
                    <div class="col">
                        <label class="form-label">Ujian Lisan</label>
                        <input type="number" name="ujian_lisan" class="form-control"
                               value="<?= $grade['ujian_lisan'] ?>" required>
                    </div>
                    <div class="col">
                        <label class="form-label">UTS</label>
                        <input type="number" name="uts" class="form-control"
                               value="<?= $grade['nilai_uts'] ?>" required>
                    </div>
                    <div class="col">
                        <label class="form-label">UAS</label>
                        <input type="number" name="uas" class="form-control"
                               value="<?= $grade['nilai_uas'] ?>" required>
                    </div>
                </div>

                <!-- BUTTON -->
                <div class="d-flex justify-content-between">
                    <a href="student-grade.php" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>

                    <button type="submit" name="update" class="btn btn-warning px-4">
                        <i class="bi bi-save"></i> Update Nilai
                    </button>
                </div>

                </form>

            </div>
        </div>

    </div>
</div>

</body>
</html>
