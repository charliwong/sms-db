<?php 
session_start();
if ($_SESSION['role']=='Admin' && isset($_GET['schedule_id'])) {

include "../DB_connection.php";
include "data/schedule.php";

removeSchedule($_GET['schedule_id'],$conn);
header("Location: schedule.php?success=Deleted");
exit;
}
