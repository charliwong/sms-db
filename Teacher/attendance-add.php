<?php
session_start();
if (!isset($_SESSION['teacher_id']) || $_SESSION['role'] !== 'Teacher') {
    header("Location: ../login.php");
    exit;
}

include "../DB_connection.php";
include "data/class.php";

$classes = getAllClasses($conn);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guru - Input Kehadiran</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css?v=2">
    <link rel="icon" href="../logos.png">
</head>
<body>

<?php include "inc/navbar.php"; ?>

<div class="container mt-5" style="max-width:600px;">
    <div class="card shadow border-0">
        <div class="card-header bg-success text-white fw-bold">
            Input Kehadiran Siswa
        </div>

        <div class="card-body">
            <form action="attendance-form.php" method="get">

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

                <!-- Tanggal -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Tanggal</label>
                    <input type="date"
                           name="date"
                           class="form-control"
                           required>
                </div>

                <div class="d-grid">
                    <button class="btn btn-success">
                        Lanjut Input Kehadiran →
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    var nav = document.querySelector("#navLinks li:nth-child(3) a");
    if(nav){ nav.classList.add('active'); }
</script>
</body>
</html>
