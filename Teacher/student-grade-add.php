<?php
session_start();
if (!isset($_SESSION['teacher_id']) || $_SESSION['role'] !== 'Teacher') {
    header("Location: ../login.php");
    exit;
}

include "../DB_connection.php";
include "data/class.php";
include "data/subject.php";

$classes  = getAllClasses($conn);
$subjects = getAllSubjects($conn);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guru - Nilai Siswa</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css?v=2">
    <link rel="icon" href="../logos.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<?php include "inc/navbar.php"; ?>

<div class="container mt-5" style="max-width:600px;">
    <div class="card shadow border-0">
        <div class="card-header bg-primary text-white fw-bold">
            Input Nilai Siswa
        </div>

        <div class="card-body">
            <form action="input_grade.php" method="get">

                <!-- Pilih Kelas -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Kelas</label>
                    <select name="class_id" class="form-select" required>
                        <option value="">-- Pilih Kelas --</option>
                        <?php foreach ($classes as $c): ?>
                            <option value="<?=$c['class_id']?>">
                                <?=$c['grade_code'].' '.$c['grade'].$c['section']?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Mata Pelajaran -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Mata Pelajaran</label>
                    <select name="subject_id" class="form-select" required>
                        <option value="">-- Pilih Mapel --</option>
                        <?php foreach ($subjects as $s): ?>
                            <option value="<?=$s['subject_id']?>">
                                <?=$s['subject']?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Semester -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Semester</label>
                    <select name="semester" class="form-select" required>
                        <option value="">-- Pilih Semester --</option>
                        <option value="1">Semester 1</option>
                        <option value="2">Semester 2</option>
                    </select>
                </div>

                <!-- Tahun Akademik -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Tahun Akademik</label>
                    <input type="text"
                           name="academic_year"
                           class="form-control"
                           placeholder="Contoh: 2024/2025"
                           required>
                </div>

                <div class="d-grid">
                    <button class="btn btn-primary">
                        Lanjut Input Nilai →
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.querySelector("#navLinks li:nth-child(4) a")?.classList.add('active');
</script>
</body>
</html>
