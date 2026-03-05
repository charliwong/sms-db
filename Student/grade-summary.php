<?php 
session_start();

if (
    !isset($_SESSION['student_id']) ||
    $_SESSION['role'] !== 'Student'
) {
    header("Location: ../login.php");
    exit;
}

include "../DB_connection.php";
include "data/score.php";

$student_id = $_SESSION['student_id'];
$grades = getStudentGrades($student_id, $conn);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Nilai - Siswa</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="../css/style.css">
	<link rel="icon" href="../logos.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<?php include "inc/navbar.php"; ?>

<div class="container my-5">
    <h4 class="text-center fw-bold text-primary mb-4">
        📊 Rekap Nilai Saya
    </h4>

<?php if ($grades): ?>

<?php
$currentYear = null;
foreach ($grades as $g):
    if ($currentYear !== $g['academic_year']):
        if ($currentYear !== null) echo "</tbody></table></div>";
        $currentYear = $g['academic_year'];
?>
    <div class="card shadow-sm mb-4">
        <div class="card-header text-center fw-bold">
            Tahun Akademik <?= $currentYear ?>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered text-center align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Kelas</th>
                        <th>Mata Pelajaran</th>
                        <th>Tugas Harian</th>
                        <th>Proyek</th>
                        <th>Lisan</th>
                        <th>UTS</th>
                        <th>UAS</th>
                        <th>Nilai Akhir</th>
                        <th>Semester</th>
                    </tr>
                </thead>
                <tbody>
<?php endif; ?>

<tr>
    <td><?= $g['grade_code'].' '.$g['grade'] ?></td>
    <td><?= htmlspecialchars($g['subject']) ?></td>
    <td><?= $g['tugas_harian'] ?></td>
    <td><?= $g['tugas_proyek'] ?></td>
    <td><?= $g['ujian_lisan'] ?></td>
    <td><?= $g['nilai_uts'] ?></td>
    <td><?= $g['nilai_uas'] ?></td>
    <td>
        <span class="badge bg-success">
            <?= $g['nilai_akhir'] ?>
        </span>
    </td>
    <td><?= $g['semester'] ?></td>
</tr>

<?php endforeach; ?>

                </tbody>
            </table>
        </div>
    </div>

<?php else: ?>
    <div class="alert alert-info text-center">
        Nilai belum tersedia
    </div>
<?php endif; ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.querySelector("#navLinks li:nth-child(2) a")?.classList.add('active');
</script>
</body>
</html>
