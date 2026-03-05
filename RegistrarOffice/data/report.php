<?php
function getStudentReport($student_id, $semester, $year, $conn) {
    $sql = "SELECT 
                s.fname, s.lname,
                g.grade_code, g.grade,
                sec.section,
                sub.subject_code,
                sub.subject,
                sc.results,
                sc.semester,
                sc.year
            FROM students s
            JOIN scores sc ON s.student_id = sc.student_id
            JOIN subjects sub ON sc.subject_id = sub.subject_id
            JOIN grades g ON s.grade = g.grade_id
            JOIN sections sec ON s.section = sec.section_id
            WHERE s.student_id = ?
            AND sc.semester = ?
            AND sc.year = ?";

    $stmt = $conn->prepare($sql);
    $stmt->execute([$student_id, $semester, $year]);

    return $stmt->rowCount() > 0 ? $stmt->fetchAll() : 0;
}
