<?php
session_start();
if (!isset($_SESSION['student_id']) || $_SESSION['role'] != 'Student') {
  header("Location: ../login.php");
  exit;
}

include "../DB_connection.php";

include "data/student.php";
include "data/grade.php";
include "data/section.php";
include "data/schedule.php";
include "data/subject.php";

$student = getStudentById($_SESSION['student_id'], $conn);
$schedules = getScheduleByGrade($student['grade'], $conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Jadwal - Siswa</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="../css/style.css">
	<link rel="icon" href="../logos.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<?php include "inc/navbar.php"; ?>

<div class="container mt-5" style="max-width:900px;">
  <h3 class="text-center fw-bold mb-4">
    <i class="fa fa-calendar"></i> Jadwal Saya
  </h3>

  <div class="card shadow-sm">
    <div class="card-body">

      <p class="text-center mb-4">
        Kelas :
        <b>
        <?php
          $g = getGradeById($student['grade'], $conn);
          echo $g['grade_code'].'-'.$g['grade'];
        ?>
        </b>
        |
        Sesi :
        <b>
        <?php
          $s = getSectioById($student['section'], $conn);
          echo $s['section'];
        ?>
        </b>
      </p>

      <?php if ($schedules != 0) { ?>
<table class="table table-bordered text-center">
  <thead class="table-light">
    <tr>
      <th>#</th>
      <th>Mata Pelajaran</th>
      <th>Waktu</th>
      <th>Tahun Akademik</th>
      <th>Semester</th>
    </tr>
  </thead>
  <tbody>
    <?php $i=1; foreach ($schedules as $sc) { ?>
    <tr>
      <td><?= $i++ ?></td>
      <td>
        <?= getSubjectById($sc['subject_id'], $conn)['subject'] ?>
      </td>
      <td>
        <?= $sc['start_time'] ?> - <?= $sc['end_time'] ?>
      </td>
      <td><?= $sc['academic_year'] ?></td>
      <td><?= $sc['semester'] ?></td>
    </tr>
    <?php } ?>
  </tbody>
</table>
<?php } else { ?>
<div class="alert alert-warning text-center">
  Jadwal belum tersedia
</div>
<?php } ?>


    </div>
  </div>
</div>

<script>
  $(document).ready(function(){
    $("#navLinks li:nth-child(3) a").addClass("active");
  });
</script>

</body>
</html>
