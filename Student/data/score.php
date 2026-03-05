<?php

// Get student_score by ID
function getScoreById($student_id, $conn){
   $sql = "SELECT * FROM student_score
           WHERE student_id=? ORDER BY year DESC";
   $stmt = $conn->prepare($sql);
   $stmt->execute([$student_id]);

   if ($stmt->rowCount() > 0) {
     $student_scores = $stmt->fetchAll();
     return $student_scores;
   }else {
    return 0;
   }
}

function gradeCalc($grade){
   $g = "";
   if ($grade >= 92) {
       $g = "A+";
   }else if ($grade >= 86) {
       $g = "A";
   }else if ($grade >= 80) {
       $g = "A-";
   }else if ($grade >= 75) {
       $g = "B+";
   }else if ($grade >= 70) {
       $g = "B";
   }else if ($grade >= 66) {
       $g = "B-";
   }else if ($grade >= 60) {
       $g = "C";
   }else if ($grade >= 55) {
       $g = "C-";
   }else if ($grade >= 50) {
       $g = "D+";
   }else if ($grade >= 45) {
       $g = "D";
   }else if ($grade >= 40) {
       $g = "D-";
   }else if ($grade < 39) {
       $g = "F";
   }
   return $g;
}

// Get grades from student_grades (READ ONLY - Student)
function getStudentGrades($student_id, $conn){

    $sql = "
        SELECT 
            sg.tugas_harian,
            sg.tugas_proyek,
            sg.ujian_lisan,
            sg.nilai_uts,
            sg.nilai_uas,
            sg.nilai_akhir,
            sg.semester,
            sg.academic_year,

            sub.subject,
            sub.subject_code,
            g.grade,
            g.grade_code

        FROM student_grades sg
        JOIN subjects sub ON sg.subject_id = sub.subject_id
        JOIN grades g ON sg.class_id = g.grade_id
        WHERE sg.student_id = ?
        ORDER BY sg.academic_year DESC, sg.semester DESC
    ";

    $stmt = $conn->prepare($sql);
    $stmt->execute([$student_id]);

    if ($stmt->rowCount() > 0) {
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        return [];
    }
}
?>