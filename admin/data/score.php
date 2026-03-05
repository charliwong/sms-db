<?php
/* ============================
   SCORE DATA FUNCTIONS
   TABLE: student_grades
============================ */

function getAllScores($conn, $class_id = '', $semester = '') {

    $sql = "
        SELECT
            sg.grade_record_id AS score_id,
            sg.nilai_akhir     AS final_score,
            sg.semester,

            CONCAT(s.fname, ' ', s.lname) AS student_name,
            sub.subject                   AS subject_name,

            CONCAT(gr.grade_code, ' ', gr.grade, sec.section) AS class_name

        FROM student_grades sg
        JOIN students s ON sg.student_id = s.student_id
        JOIN subjects sub ON sg.subject_id = sub.subject_id
        JOIN class c ON sg.class_id = c.class_id
        JOIN grades gr ON c.grade = gr.grade_id
        JOIN section sec ON c.section = sec.section_id
        WHERE 1
    ";

    $params = [];

    if (!empty($class_id)) {
        $sql .= " AND sg.class_id = ?";
        $params[] = $class_id;
    }

    if (!empty($semester)) {
        $sql .= " AND sg.semester = ?";
        $params[] = $semester;
    }

    $sql .= " ORDER BY s.fname ASC";

    $stmt = $conn->prepare($sql);
    $stmt->execute($params);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/* Ambil nilai by ID */
function getScoreById($conn, $score_id) {
    $sql = "SELECT * FROM student_grades WHERE grade_record_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$score_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/* Hapus nilai */
function deleteScore($conn, $score_id) {
    $sql = "DELETE FROM student_grades WHERE grade_record_id = ?";
    $stmt = $conn->prepare($sql);
    return $stmt->execute([$score_id]);
}
