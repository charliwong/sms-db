<?php 
session_start();
if (isset($_SESSION['admin_id']) && 
    isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'Admin') {
       include "../DB_connection.php";
       include "data/message.php";
       $messages = getAllMessages($conn);
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin - Messages</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="../css/style.css?v=2">
	<link rel="icon" href="../logos.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <?php 
        include "inc/navbar.php";
        if ($messages != 0) { ?>
     <div class="container my-5" style="max-width: 800px;">

  <h3 class="text-center fw-bold mb-4 text-primary">
    Inbox Messages
  </h3>
  <?php foreach ($messages as $message) { ?>
    <div class="card shadow-sm border-0 mb-3 message-card">

      <!-- Header -->
      <div class="card-body d-flex align-items-center message-header"
           data-bs-toggle="collapse"
           data-bs-target="#message_<?=$message['message_id']?>"
           style="cursor: pointer;">

        <!-- Avatar -->
        <div class="avatar me-3">
          <?= strtoupper(substr($message['sender_full_name'], 0, 1)) ?>
        </div>

        <!-- Sender Info -->
        <div class="flex-grow-1">
          <div class="fw-semibold">
            <?=$message['sender_full_name']?>
          </div>
          <small class="text-muted">
            <?=$message['sender_email']?>
          </small>
        </div>

        <!-- Time -->
        <small class="text-muted">
          <?=$message['date_time']?>
        </small>
      </div>

      <!-- Message Body -->
      <div class="collapse" id="message_<?=$message['message_id']?>">
        <div class="card-body border-top bg-light">
          <p class="mb-0">
            <?=$message['message']?>
          </p>
        </div>
      </div>

    </div>
  <?php } ?>

</div>

        
         <?php }else{ ?>
             <div class="alert alert-info .w-450 m-5" 
                  role="alert">
                Empty!
              </div>
         <?php } ?>
     </div>
     
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>	
    <script>
        $(document).ready(function(){
             $("#navLinks li:nth-child(9) a").addClass('active');
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