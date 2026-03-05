<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

if (isset($_SESSION['admin_id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Admin') {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Tambah Sesi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css?v=2">
    <link rel="icon" href="../logos.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<?php include "inc/navbar.php"; ?>

<div class="container my-5">
    <h3 class="text-center text-primary fw-bold">Tambah Sesi</h3>

    <a href="section.php" class="btn btn-dark mb-3">
        <i class="fa fa-arrow-left"></i> Kembali
    </a>

    <div class="card shadow">
        <div class="card-body">
            <form method="post" action="req/section-add.php">

                <?php if (isset($_GET['error'])) { ?>
                    <div class="alert alert-danger">
                        <?= $_GET['error'] ?>
                    </div>
                <?php } ?>

                <?php if (isset($_GET['success'])) { ?>
                    <div class="alert alert-success">
                        <?= $_GET['success'] ?>
                    </div>
                <?php } ?>

                <div class="mb-3">
                    <label class="form-label">Nama Sesi</label>
                    <input type="text" name="section" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save"></i> Buat Sesi
                </button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function () {
        $("#navLinks li:nth-child(5) a").addClass('active');
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
