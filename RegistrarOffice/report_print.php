<?php
session_start();
if (!isset($_SESSION['r_user_id']) || $_SESSION['role'] !== 'Registrar Office') {
    header("Location: ../login.php");
    exit;
}

include "../DB_connection.php";

/* PARAMETER */
$report_type   = isset($_GET['report_type']) ? $_GET['report_type'] : '';
$class_id      = isset($_GET['class_id']) ? $_GET['class_id'] : '';
$semester      = isset($_GET['semester']) ? $_GET['semester'] : '';
$academic_year = isset($_GET['academic_year']) ? $_GET['academic_year'] : '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Cetak Laporan</title>

<link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">

<style>
body {
    font-size: 14px;
}
.kop h4, .kop h5 {
    margin: 0;
}
@media print {
    .no-print { display: none; }
}
</style>
</head>
<body>

<div class="container my-4">

<!-- KOP SURAT -->
<div class="text-center kop mb-4">
    <h4><b>SMAK ST. ST. BENEDIKTUS PALUE</b></h4>
    <h5>Jl, Protokol,Maluriwu, palue.</h5>
    <p>Telp. (+62) 123456</p>
    <hr>
</div>

<!-- JUDUL -->
<div class="text-center mb-4">
    <h5 class="fw-bold text-uppercase">
        LAPORAN 
        <?php
        if ($report_type == 'teacher') echo "DATA GURU";
        if ($report_type == 'student') echo "DATA SISWA";
        if ($report_type == 'grade')   echo "DATA NILAI";
        ?>
    </h5>
    <?php if ($academic_year): ?>
        <p>Tahun Ajaran: <?=$academic_year?></p>
    <?php endif; ?>
</div>

<div class="text-end no-print mb-3">
    <button onclick="window.print()" class="btn btn-success">
        🖨️ Cetak
    </button>
</div>

<?php
/* =======================
   DATA GURU
======================= */
if ($report_type == 'teacher') {

    $stmt = $conn->prepare("SELECT * FROM teachers");
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<table class='table table-bordered'>
            <tr>
              <th width='5%'>#</th>
              <th>Nama Guru</th>
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

    echo "<table class='table table-bordered'>
            <tr>
              <th width='5%'>#</th>
              <th>Nama Siswa</th>
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

    echo "<table class='table table-bordered'>
            <tr>
              <th width='5%'>#</th>
              <th>Nama Siswa</th>
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

<!-- TANDA TANGAN -->
<div class="row mt-5">
    <div class="col-6"></div>
    <div class="col-6 text-center">
        <p>Mengetahui,</p>
        <p><b>Kepala Sekolah</b></p>
        <br><br>
        <p>Antonius Cawa</p>
        <p>NUPTK.1234567890</p>
    </div>
</div>

</div>
</body>
</html>
