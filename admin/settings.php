<?php 
session_start();
if (isset($_SESSION['admin_id']) && 
    isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'Admin') {
       include "../DB_connection.php";
       include "data/setting.php";
       $setting = getSetting($conn);
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin - Setting</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="../css/style.css?v=2">
	<link rel="icon" href="../logos.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <?php 
        include "inc/navbar.php";  ?>

   <div class="container d-flex justify-content-center align-items-start mt-5">
    <form method="post"
        action="req/setting-edit.php"
        class="card shadow p-4"
       style="width: 100%; max-width: 600px;">

    <h4 class="text-center mb-3">Pengaturan Sekolah</h4> <hr>

    <?php if (isset($_GET['error'])) { ?>
      <div class="alert alert-danger text-center" role="alert">
        <?=$_GET['error']?>
      </div>
    <?php } ?>

    <?php if (isset($_GET['success'])) { ?>
      <div class="alert alert-success text-center" role="alert">
        <?=$_GET['success']?>
      </div>
    <?php } ?>

    <div class="mb-3">
      <label class="form-label">Nama Sekolah</label>
      <input type="text" class="form-control"
             name="school_name"
             value="<?=$setting['school_name']?>">
    </div>

    <div class="mb-3">
      <label class="form-label">Slogan</label>
      <input type="text" class="form-control"
             name="slogan"
             value="<?=$setting['slogan']?>">
    </div>

    <div class="mb-3">
      <label class="form-label">Tentang Sekolah</label>
      <textarea class="form-control"
                name="about"
                rows="4"><?=$setting['about']?></textarea>
    </div>

    <div class="row">
      <div class="col-md-6 mb-3">
        <label class="form-label">Tahun Sekarang</label>
        <input type="text" class="form-control"
               name="current_year"
               value="<?=$setting['current_year']?>">
      </div>

      <div class="col-md-6 mb-3">
        <label class="form-label">Semester Sekarang</label>
        <input type="text" class="form-control"
               name="current_semester"
               value="<?=$setting['current_semester']?>">
      </div>
    </div>

    <div class="d-grid mt-3">
      <button type="submit" class="btn btn-primary">
        Update Settings
      </button>
    </div>
</form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>	
    <script>
        $(document).ready(function(){
             $("#navLinks li:nth-child(10) a").addClass('active');
        });
    </script>

</body>
</html>
<?php 

  }else {
    header("Location: ../login.php");
    exit;
  } 
}else {
	header("Location: ../login.php");
	exit;
} 

?>