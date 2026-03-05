<?php 
session_start();
if (isset($_SESSION['teacher_id']) && 
    isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'Teacher') {
       include "../DB_connection.php";
       include "data/teacher.php";
       include "data/subject.php";
       include "data/grade.php";
       include "data/section.php";
       include "data/class.php";


       $teacher_id = $_SESSION['teacher_id'];
       $teacher = getTeacherById($teacher_id, $conn);
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Guru - Home</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="../css/style.css?v=2">
	<link rel="icon" href="../logos.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <?php 
        include "inc/navbar.php";
        if ($teacher != 0) {
     ?>
     
     <div class="container mt-5 d-flex justify-content-center">
  <div class="card shadow" style="max-width: 420px; width: 100%;">
    
    <img src="../img/teacher-<?=$teacher['gender']?>.png"
         class="card-img-top p-3"
         style="height:220px; object-fit:contain"
         alt="Teacher">

    <div class="card-body text-center">
      <h5 class="card-title fw-bold">@<?=$teacher['username']?></h5>
      <span class="badge bg-primary">Guru</span>
    </div>

    <ul class="list-group list-group-flush">
      <li class="list-group-item"><b>Nama:</b> <?=$teacher['fname']?> <?=$teacher['lname']?></li>
      <li class="list-group-item"><b>Username:</b> <?=$teacher['username']?></li>
      <li class="list-group-item"><b>No. Karyawan:</b> <?=$teacher['employee_number']?></li>
      <li class="list-group-item"><b>Tanggal Lahir:</b> <?=$teacher['date_of_birth']?></li>
      <li class="list-group-item"><b>Telepon:</b> <?=$teacher['phone_number']?></li>
      <li class="list-group-item"><b>Email:</b> <?=$teacher['email_address']?></li>
      <li class="list-group-item"><b>Kualifikasi:</b> <?=$teacher['qualification']?></li>
      <li class="list-group-item"><b>Alamat:</b> <?=$teacher['address']?></li>
      <li class="list-group-item"><b>Jenis Kelamin:</b> <?=$teacher['gender']?></li>
      <li class="list-group-item"><b>Tanggal Bergabung:</b> <?=$teacher['date_of_joined']?></li>
    
      <li class="list-group-item">
        <b>Mata Pelajaran:</b><br>
        <?php 
          $s = '';
          $subjects = str_split(trim($teacher['subjects']));
          foreach ($subjects as $subject) {
            $s_temp = getSubjectById($subject, $conn);
            if ($s_temp != 0) 
              $s .= '<span class="badge bg-secondary me-1">'.$s_temp['subject_code'].'</span>';
          }
          echo $s;
        ?>
      </li>

      <li class="list-group-item">
        <b>Kelas:</b><br>
        <?php 
          $c = '';
          $classes = str_split(trim($teacher['class']));
          foreach ($classes as $class_id) {
            $class = getClassById($class_id, $conn);
            $g = getGradeById($class['grade'], $conn);
            $sec = getSectioById($class['section'], $conn);
            if ($g != 0)
              echo '<span class="badge bg-success me-1">'.$g['grade_code'].'-'.$g['grade'].$sec['section'].'</span>';
          }
        ?>
      </li>
    </ul>
  </div>
</div>

     </div>
     <?php 
        }else {
          header("Location: logout.php?error=An error occurred");
          exit;
        }
     ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>	
   <script>
        $(document).ready(function(){
             $("#navLinks li:nth-child(1) a").addClass('active');
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