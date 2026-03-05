<?php

function getScoresByTeacher($teacher_id, $conn, $semester = '') {

  $sql = "
    SELECT
      sg.grade_record_id,
      sg.nilai_akhir,
      sg.semester,
      sg.academic_year,

      CONCAT(st.fname,' ',st.lname) AS student_name,
      sub.subject AS subject_name,
      CONCAT(g.grade_code,'-',g.grade) AS class_name

    FROM student_grades sg
    JOIN students st ON sg.student_id = st.student_id
    JOIN subjects sub ON sg.subject_id = sub.subject_id
    JOIN class c ON sg.class_id = c.class_id
    JOIN grades g ON c.grade = g.grade_id

    WHERE sg.teacher_id = ?
  ";

  $params = [$teacher_id];

  if (!empty($semester)) {
    $sql .= " AND sg.semester = ?";
    $params[] = $semester;
  }

  $sql .= " ORDER BY st.fname ASC";

  $stmt = $conn->prepare($sql);
  $stmt->execute($params);

  return $stmt->rowCount() > 0 ? $stmt->fetchAll() : 0;
}

function getScoreByIdForTeacher($conn, $grade_record_id, $teacher_id) {

  $sql = "
    SELECT
      sg.grade_record_id,
      sg.nilai_akhir,
      sg.semester,

      CONCAT(st.fname,' ',st.lname) AS student_name,
      sub.subject AS subject_name,
      CONCAT(g.grade_code,'-',g.grade) AS class_name

    FROM student_grades sg
    JOIN students st ON sg.student_id = st.student_id
    JOIN subjects sub ON sg.subject_id = sub.subject_id
    JOIN class c ON sg.class_id = c.class_id
    JOIN grades g ON c.grade = g.grade_id

    WHERE sg.grade_record_id = ?
      AND sg.teacher_id = ?
    LIMIT 1
  ";

  $stmt = $conn->prepare($sql);
  $stmt->execute([$grade_record_id, $teacher_id]);

  return $stmt->rowCount() ? $stmt->fetch() : false;
}

function updateScoreForTeacher($conn, $grade_record_id, $teacher_id, $final_score) {

  $sql = "
    UPDATE student_grades
    SET nilai_akhir = ?
    WHERE grade_record_id = ?
      AND teacher_id = ?
  ";

  $stmt = $conn->prepare($sql);
  return $stmt->execute([
    $final_score,
    $grade_record_id,
    $teacher_id
  ]);
}
