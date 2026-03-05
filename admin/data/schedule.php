<?php

// Ambil semua jadwal
function getAllSchedules($conn) {
    $sql = "SELECT * FROM schedule ORDER BY schedule_id DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        return $stmt->fetchAll();
    } else {
        return 0;
    }
}

// Ambil satu jadwal berdasarkan ID
function getScheduleById($schedule_id, $conn) {
    $sql = "SELECT * FROM schedule WHERE schedule_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$schedule_id]);

    if ($stmt->rowCount() > 0) {
        return $stmt->fetch();
    } else {
        return 0;
    }
}

// Tambah jadwal
function insertSchedule($conn, $subject_id, $grade_id, $start_time, $end_time, $academic_year, $semester) {
    $sql = "INSERT INTO schedule 
            (subject_id, grade_id, start_time, end_time, academic_year, semester)
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    return $stmt->execute([
        $subject_id,
        $grade_id,
        $start_time,
        $end_time,
        $academic_year,
        $semester
    ]);
}

// Update jadwal
function updateSchedule($conn, $subject_id, $grade_id, $start_time, $end_time, $academic_year, $semester, $schedule_id) {
    $sql = "UPDATE schedule SET
                subject_id = ?,
                grade_id = ?,
                start_time = ?,
                end_time = ?,
                academic_year = ?,
                semester = ?
            WHERE schedule_id = ?";

    $stmt = $conn->prepare($sql);
    return $stmt->execute([
        $subject_id,
        $grade_id,
        $start_time,
        $end_time,
        $academic_year,
        $semester,
        $schedule_id
    ]);
}

// Hapus jadwal
function deleteSchedule($schedule_id, $conn) {
    $sql = "DELETE FROM schedule WHERE schedule_id = ?";
    $stmt = $conn->prepare($sql);
    return $stmt->execute([$schedule_id]);
}

function removeSchedule($schedule_id, $conn) {
    return deleteSchedule($schedule_id, $conn);
}
