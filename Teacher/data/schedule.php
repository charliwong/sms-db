<?php

function getScheduleByTeacher($teacher_id, $conn) {
  $sql = "
    SELECT *
    FROM schedule
    WHERE teacher_id = ?
    ORDER BY FIELD(day,
      'Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'
    ), start_time ASC
  ";
  $stmt = $conn->prepare($sql);
  $stmt->execute([$teacher_id]);

  if ($stmt->rowCount() > 0) {
    return $stmt->fetchAll();
  }
  return 0;
}

