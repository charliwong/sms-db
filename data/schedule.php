<?php 

function getAllSchedules($conn){
  $sql = "SELECT * FROM schedule";
  $stmt = $conn->prepare($sql);
  $stmt->execute();

  if ($stmt->rowCount() > 0) {
    return $stmt->fetchAll();
  } else {
    return 0;
  }
}

function getScheduleById($id, $conn){
  $sql = "SELECT * FROM schedule WHERE schedule_id=?";
  $stmt = $conn->prepare($sql);
  $stmt->execute([$id]);

  if ($stmt->rowCount() > 0) {
    return $stmt->fetch();
  } else {
    return 0;
  }
}

function removeSchedule($id, $conn){
  $sql = "DELETE FROM schedule WHERE schedule_id=?";
  $stmt = $conn->prepare($sql);
  return $stmt->execute([$id]);
}
