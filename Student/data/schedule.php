<?php
// Ambil jadwal berdasarkan grade
function getScheduleByGrade($grade_id, $conn) {
    $sql = "SELECT * FROM schedule 
            WHERE grade_id = ?
            ORDER BY start_time ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$grade_id]);

    if ($stmt->rowCount() > 0) {
        return $stmt->fetchAll();
    } else {
        return 0;
    }
}
