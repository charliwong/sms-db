<?php
session_start();

/* =========================
   HAK AKSES
========================= */
if (
    !isset($_SESSION['admin_id']) &&
    (!isset($_SESSION['teacher_id']) || $_SESSION['role'] != 'Guru')
) {
    header("Location: ../login.php");
    exit;
}

require_once "../DB_connection.php";

/* =========================
   DATA DROPDOWN FILTER
   (AMBIL DARI TABEL class)
========================= */
$classes = $conn->query("
    SELECT 
        c.class_id,
        g.grade_code,
        g.grade,
        s.section
    FROM class c
    JOIN grades g ON g.grade_id = c.grade
    JOIN section s ON s.section_id = c.section
    ORDER BY g.grade_code, s.section
")->fetchAll(PDO::FETCH_ASSOC);

$subjects = $conn->query("
    SELECT subject_id, subject 
    FROM subjects
")->fetchAll(PDO::FETCH_ASSOC);

/* =========================
   QUERY NILAI (DINAMIS)
========================= */
$where  = [];
$params = [];

if (!empty($_GET['class_id'])) {
    $where[]  = "sg.class_id = ?";
    $params[] = $_GET['class_id'];
}

if (!empty($_GET['subject_id'])) {
    $where[]  = "sg.subject_id = ?";
    $params[] = $_GET['subject_id'];
}

if (!empty($_GET['semester'])) {
    $where[]  = "sg.semester = ?";
    $params[] = $_GET['semester'];
}

if (!empty($_GET['academic_year'])) {
    $where[]  = "sg.academic_year = ?";
    $params[] = $_GET['academic_year'];
}

$sql = "
SELECT 
    sg.grade_record_id,
    sg.tugas_harian,
    sg.tugas_proyek,
    sg.ujian_lisan,
    sg.nilai_uts,
    sg.nilai_uas,
    sg.nilai_akhir,
    sg.semester,
    sg.academic_year,

    st.fname AS student_fname,
    st.lname AS student_lname,

    sub.subject,

    g.grade,
    g.grade_code,
    s.section

FROM student_grades sg
JOIN students st ON sg.student_id = st.student_id
JOIN subjects sub ON sg.subject_id = sub.subject_id
JOIN class c ON sg.class_id = c.class_id
JOIN grades g ON g.grade_id = c.grade
JOIN section s ON s.section_id = c.section
";

if ($where) {
    $sql .= " WHERE " . implode(" AND ", $where);
}

$sql .= " ORDER BY sg.academic_year DESC, sg.semester DESC";

$stmt = $conn->prepare($sql);
$stmt->execute($params);
$grades = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Nilai Siswa</title>
    <link rel="icon" href="../logos.png">
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css?v=3">
</head>
<body>

<?php include "inc/navbar.php"; ?>

<div class="container my-5">

    <h3 class="text-center fw-bold text-primary mb-4">
        Manajemen Nilai Siswa
    </h3>

    <div class="d-flex justify-content-between mb-3">
        <a href="student-grade-add.php" class="btn btn-primary">
            ➕ Input Nilai
        </a>
    </div>

    <!-- FILTER -->
    <form method="get" class="row g-3 mb-4">

        <div class="col-md-3">
            <select name="class_id" class="form-select">
                <option value="">Semua Kelas</option>
                <?php foreach ($classes as $c): ?>
                    <option value="<?= $c['class_id'] ?>"
                        <?= (isset($_GET['class_id']) && $_GET['class_id'] == $c['class_id']) ? 'selected' : '' ?>>
                        <?= $c['grade_code'].' '.$c['grade'].' - '.$c['section'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-3">
            <select name="subject_id" class="form-select">
                <option value="">Semua Mapel</option>
                <?php foreach ($subjects as $s): ?>
                    <option value="<?= $s['subject_id'] ?>"
                        <?= (isset($_GET['subject_id']) && $_GET['subject_id'] == $s['subject_id']) ? 'selected' : '' ?>>
                        <?= $s['subject'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-2">
            <select name="semester" class="form-select">
                <option value="">Semester</option>
                <option value="Ganjil" <?= (isset($_GET['semester']) && $_GET['semester']=='Ganjil') ? 'selected' : '' ?>>
                    Ganjil
                </option>
                <option value="Genap" <?= (isset($_GET['semester']) && $_GET['semester']=='Genap') ? 'selected' : '' ?>>
                    Genap
                </option>
            </select>
        </div>

        <div class="col-md-2">
            <input type="text"
                   name="academic_year"
                   class="form-control"
                   placeholder="2024/2025"
                   value="<?= isset($_GET['academic_year']) ? $_GET['academic_year'] : '' ?>">
        </div>

        <div class="col-md-2">
            <button class="btn btn-primary w-100">
                🔍 Filter
            </button>
        </div>

    </form>

    <!-- TABLE -->
    <?php if ($grades): ?>
        <div class="card shadow border-0">
            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Mata Pelajaran</th>
                            <th>Tugas Harian</th>
                            <th>Tugas Proyek</th>
                            <th>Ujian Lisan</th>
                            <th>UTS</th>
                            <th>UAS</th>
                            <th>Nilai Akhir</th>
                            <th>Semester</th>
                            <th>Tahun</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $no=1; foreach ($grades as $g): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($g['student_fname'].' '.$g['student_lname']) ?></td>
                            <td><?= htmlspecialchars($g['grade_code'].' '.$g['grade'].' - '.$g['section']) ?></td>
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
                            <td><?= $g['academic_year'] ?></td>
                            <td>
                                <a href="student-grade-edit.php?id=<?= $g['grade_record_id'] ?>"
                                   class="btn btn-sm btn-warning">
                                    ✏️
                                </a>
                                <a href="student-grade-delete.php?id=<?= $g['grade_record_id'] ?>"
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Hapus nilai ini?')">
                                    🗑️
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center">
            Data nilai belum tersedia
        </div>
    <?php endif; ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.querySelector("#navLinks li:nth-child(9) a")?.classList.add('active');
</script>
</body>
</html>
