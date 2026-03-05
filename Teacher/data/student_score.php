<?php  

function getScoreByStudentTeacherSubject(
    $student_id,
    $teacher_id,
    $subject_id,
    $semester,
    $year,
    $conn
){
    $sql = "SELECT *
            FROM student_score
            WHERE student_id = ?
              AND teacher_id = ?
              AND subject_id = ?
              AND semester = ?
              AND year = ?
            LIMIT 1";

    $stmt = $conn->prepare($sql);
    $stmt->execute([
        $student_id,
        $teacher_id,
        $subject_id,
        $semester,
        $year
    ]);

    if ($stmt->rowCount() > 0) {
        return $stmt->fetch();
    }
    return 0;
}
