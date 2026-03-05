<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if (!isset($_SESSION['admin_id']) || $_SESSION['role'] != 'Admin') {
    header("Location: ../login.php");
    exit;
}

require_once "../DB_connection.php";

/* ===== VALIDASI ID ===== */
if (!isset($_GET['schedule_id'])) {
    header("Location: schedule.php?error=ID jadwal tidak ditemukan");
    exit;
}
$id = $_GET['schedule_id'];

/* ===== AMBIL DATA JADWAL ===== */
$stmt = $conn->prepare("SELECT * FROM schedule WHERE schedule_id=?");
$stmt->execute([$id]);
$data = $stmt->fetch();

if (!$data) {
    header("Location: schedule.php?error=Data tidak ditemukan");
    exit;
}

/* ===== DATA DROPDOWN ===== */
$subjects = $conn->query("SELECT subject_id, subject FROM subjects")->fetchAll();
$teachers = $conn->query("SELECT teacher_id, fname, lname FROM teachers")->fetchAll();
$grades   = $conn->query("SELECT grade_id, grade FROM grades")->fetchAll();

/* ===== UPDATE DATA ===== */
if (isset($_POST['update'])) {
    $stmt = $conn->prepare(
        "UPDATE schedule SET
        subject_id=?, teacher_id=?, grade_id=?, day=?, start_time=?, end_time=?,
        room=?, academic_year=?, semester=?
        WHERE schedule_id=?"
    );

    $stmt->execute([
        $_POST['subject_id'],
        $_POST['teacher_id'],
        $_POST['grade_id'],
        $_POST['day'],
        $_POST['start_time'],
        $_POST['end_time'],
        $_POST['room'],
        $_POST['academic_year'],
        $_POST['semester'],
        $id
    ]);

    header("Location: schedule.php?success=Jadwal berhasil diperbarui");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin - Update Jadwal</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="../css/style.css?v=2">
	<link rel="icon" href="../logos.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<?php include "inc/navbar.php"; ?>

<div class="container my-5">
<h3 class="text-center text-primary fw-bold mb-4">✏️ Edit Jadwal</h3>

<form method="post" class="row g-3">

<div class="col-md-4">
<label>Mata Pelajaran</label>
<select name="subject_id" class="form-select" required>
<?php foreach ($subjects as $s): ?>
<option value="<?= $s['subject_id'] ?>"
<?= ($data['subject_id'] == $s['subject_id']) ? 'selected' : '' ?>>
<?= $s['subject'] ?>
</option>
<?php endforeach; ?>
</select>
</div>

<div class="col-md-4">
<label>Guru</label>
<select name="teacher_id" class="form-select" required>
<?php foreach ($teachers as $t): ?>
<option value="<?= $t['teacher_id'] ?>"
<?= ($data['teacher_id'] == $t['teacher_id']) ? 'selected' : '' ?>>
<?= $t['fname'].' '.$t['lname'] ?>
</option>
<?php endforeach; ?>
</select>
</div>

<div class="col-md-4">
<label>Tingkatan</label>
<select name="grade_id" class="form-select" required>
<?php foreach ($grades as $g): ?>
<option value="<?= $g['grade_id'] ?>"
<?= ($data['grade_id'] == $g['grade_id']) ? 'selected' : '' ?>>
<?= $g['grade'] ?>
</option>
<?php endforeach; ?>
</select>
</div>

<div class="col-md-3">
<label>Hari</label>
<select name="day" class="form-select" required>
<?php
$days = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
foreach ($days as $d):
?>
<option value="<?= $d ?>" <?= ($data['day']==$d)?'selected':'' ?>><?= $d ?></option>
<?php endforeach; ?>
</select>
</div>

<div class="col-md-3">
<label>Mulai</label>
<input type="time" name="start_time" class="form-control"
value="<?= $data['start_time'] ?>" required>
</div>

<div class="col-md-3">
<label>Selesai</label>
<input type="time" name="end_time" class="form-control"
value="<?= $data['end_time'] ?>" required>
</div>

<div class="col-md-3">
<label>Ruangan</label>
<input type="text" name="room" class="form-control"
value="<?= $data['room'] ?>" required>
</div>

<div class="col-md-4">
<label>Tahun Akademik</label>
<input type="text" name="academic_year" class="form-control"
value="<?= $data['academic_year'] ?>" required>
</div>

<div class="col-md-2">
<label>Semester</label>
<select name="semester" class="form-select" required>
<option value="1" <?= $data['semester']==1?'selected':'' ?>>1</option>
<option value="2" <?= $data['semester']==2?'selected':'' ?>>2</option>
</select>
</div>

<div class="col-12 text-center">
<button name="update" class="btn btn-primary">Update Jadwal</button>
<a href="schedule.php" class="btn btn-secondary">Kembali</a>
</div>

</form>
</div>
</body>
</html>
