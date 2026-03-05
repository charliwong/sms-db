<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

if (isset($_SESSION['admin_id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Admin') {

        include "../DB_connection.php";
        include "data/schedule.php";
        include "data/subject.php";
        include "data/grade.php";

        $schedules = getAllSchedules($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin - Jadwal</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="../css/style.css?v=2">
	<link rel="icon" href="../logos.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<?php include "inc/navbar.php"; ?>

<div class="container my-5 position-relative" style="z-index:1;">
<h3 class="text-center text-primary fw-bold">Manajemen Jadwal</h3>

<a href="schedule-add.php" class="btn btn-primary mb-3">
  <i class="fa fa-plus"></i> Tambah Jadwal
</a>

<?php if ($schedules != 0) { ?>
<table class="table table-bordered text-center">
<thead>
<tr>
  <th>#</th>
  <th>Mata Pelajaran</th>
  <th>Tingkatan</th>
  <th>Waktu</th>
  <th>Tahun Akademik</th>
  <th>Semester</th>
  <th>Tinjau</th>
</tr>
</thead>
<tbody>
<?php $i=0; foreach($schedules as $s){ $i++; ?>
<tr>
  <td><?=$i?></td>
  <td><?=getSubjectById($s['subject_id'],$conn)['subject']?></td>
  <td><?=getGradeById($s['grade_id'],$conn)['grade']?></td>
  <td><?=$s['start_time']?> - <?=$s['end_time']?></td>
  <td><?=$s['academic_year']?></td>
  <td><?=$s['semester']?></td>
  <td>
    <a href="schedule-edit.php?schedule_id=<?=$s['schedule_id']?>" class="btn btn-warning btn-sm">Edit</a>
    <a href="schedule-delete.php?schedule_id=<?=$s['schedule_id']?>" class="btn btn-danger btn-sm">Delete</a>
  </td>
</tr>
<?php } ?>
</tbody>
</table>
<?php } else { ?>
<div class="alert alert-info">Jadwal Kosong</div>
<?php } ?>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>  
<script>
  $(document).ready(function(){
    $("#navLinks li:nth-child(3) a").addClass('active');
  });
</script>

</body>
</html>
<?php
    } else {
        header("Location: ../login.php");
        exit;
    }
} else {
    header("Location: ../login.php");
    exit;
}
?>
