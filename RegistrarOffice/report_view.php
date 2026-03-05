<?php
session_start();
if (!isset($_SESSION['r_user_id']) || $_SESSION['role'] !== 'Registrar Office') {
    header("Location: ../login.php");
    exit;
}

include "../DB_connection.php";
include "../Teacher/data/class.php";
include "../Teacher/data/grade.php";
include "../Teacher/data/section.php";

/* FILTER */
$report_type   = isset($_GET['report_type']) ? $_GET['report_type'] : '';
$class_id      = isset($_GET['class_id']) ? $_GET['class_id'] : '';
$semester      = isset($_GET['semester']) ? $_GET['semester'] : '';
$academic_year = isset($_GET['academic_year']) ? $_GET['academic_year'] : '';

$classes = getAllClasses($conn);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cek Laporan</title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/style.css?v=2">
  <link rel="icon" href="../logos.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<?php include "inc/navbar.php"; ?>

<div class="container my-5">

<h3 class="fw-bold mb-4 text-primary">📊 Lihat Laporan</h3>

<!-- FILTER -->
<form method="get" class="card p-4 shadow mb-4">
    <div class="row g-3">

        <div class="col-md-3">
            <label class="form-label">Jenis Laporan</label>
            <select name="report_type" class="form-select" required>
                <option value="">-- Pilih --</option>
                <option value="teacher" <?=($report_type=='teacher')?'selected':''?>>Data Guru</option>
                <option value="student" <?=($report_type=='student')?'selected':''?>>Data Siswa</option>
                <option value="grade" <?=($report_type=='grade')?'selected':''?>>Data Nilai</option>
            </select>
        </div>

        <div class="col-md-3">
            <label class="form-label">Kelas</label>
            <select name="class_id" class="form-select">
                <option value="">Semua</option>
                <?php foreach ($classes as $c):
                    $g = getGradeById($c['grade'], $conn);
                    $s = getSectioById($c['section'], $conn);
                ?>
                <option value="<?=$c['class_id']?>" <?=($class_id==$c['class_id'])?'selected':''?>>
                    <?=$g['grade_code'].' '.$g['grade'].$s['section']?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-3">
            <label class="form-label">Semester</label>
            <select name="semester" class="form-select">
                <option value="">Semua</option>
                <option value="1" <?=($semester=='1')?'selected':''?>>1</option>
                <option value="2" <?=($semester=='2')?'selected':''?>>2</option>
            </select>
        </div>

        <div class="col-md-3">
            <label class="form-label">Tahun Ajaran</label>
            <input type="text" name="academic_year"
                   class="form-control"
                   placeholder="2025/2026"
                   value="<?=$academic_year?>">
        </div>

    </div>

    <div class="mt-4 text-end">
        <button class="btn btn-primary">🔍 Tampilkan</button>
    </div>
</form>

<?php if ($report_type): ?>

<div class="card shadow p-4">

<?php
/* =======================
   DATA GURU
======================= */
if ($report_type == 'teacher') {

    $stmt = $conn->prepare("SELECT * FROM teachers");
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<h5 class='fw-bold mb-3'>📘 Laporan Data Guru</h5>";
    echo "<table class='table table-bordered'>
            <tr>
              <th>#</th>
              <th>Nama</th>
              <th>Email</th>
            </tr>";

    $i=1;
    foreach ($rows as $r) {
        echo "<tr>
                <td>$i</td>
                <td>{$r['fname']} {$r['lname']}</td>
                <td>{$r['email_address']}</td>
              </tr>";
        $i++;
    }
    echo "</table>";
}

/* =======================
   DATA SISWA
======================= */
if ($report_type == 'student') {

    $sql = "SELECT * FROM students";
    $params = [];

    if ($class_id) {
        $sql .= " WHERE grade IN (SELECT grade FROM class WHERE class_id=?)";
        $params[] = $class_id;
    }

    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<h5 class='fw-bold mb-3'>📗 Laporan Data Siswa</h5>";
    echo "<table class='table table-bordered'>
            <tr>
              <th>#</th>
              <th>Nama</th>
              <th>Email</th>
            </tr>";

    $i=1;
    foreach ($rows as $r) {
        echo "<tr>
                <td>$i</td>
                <td>{$r['fname']} {$r['lname']}</td>
                <td>{$r['email_address']}</td>
              </tr>";
        $i++;
    }
    echo "</table>";
}

/* =======================
   DATA NILAI
======================= */
if ($report_type == 'grade') {

    $sql = "SELECT sg.*, s.fname, s.lname
            FROM student_grades sg
            JOIN students s ON sg.student_id = s.student_id
            WHERE 1";
    $params = [];

    if ($class_id) {
        $sql .= " AND sg.class_id=?";
        $params[] = $class_id;
    }
    if ($semester) {
        $sql .= " AND sg.semester=?";
        $params[] = $semester;
    }
    if ($academic_year) {
        $sql .= " AND sg.academic_year=?";
        $params[] = $academic_year;
    }

    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<h5 class='fw-bold mb-3'>📕 Laporan Nilai</h5>";
    echo "<table class='table table-bordered'>
            <tr>
              <th>#</th>
              <th>Nama</th>
              <th>Nilai Akhir</th>
            </tr>";

    $i=1;
    foreach ($rows as $r) {
        echo "<tr>
                <td>$i</td>
                <td>{$r['fname']} {$r['lname']}</td>
                <td>{$r['nilai_akhir']}</td>
              </tr>";
        $i++;
    }
    echo "</table>";
}
?>

<div class="text-end mt-3">
    <a target="_blank"
       href="report_print.php?<?=http_build_query($_GET)?>"
       class="btn btn-success">
       🖨️ Cetak Laporan
    </a>
</div>

</div>
<?php endif; ?>

</div>
</body>
</html>
