<?php
// All Grades
function getAllGrades($conn){
   $sql = "SELECT * FROM grades";
   $stmt = $conn->prepare($sql);
   $stmt->execute();

   return ($stmt->rowCount() >= 1)
     ? $stmt->fetchAll(PDO::FETCH_ASSOC)
     : 0;
}

// Get Grade by ID
function getGradeById($grade_id, $conn){
   $sql = "SELECT * FROM grades WHERE grade_id=?";
   $stmt = $conn->prepare($sql);
   $stmt->execute([$grade_id]);

   return ($stmt->rowCount() === 1)
     ? $stmt->fetch(PDO::FETCH_ASSOC)
     : 0;
}

// DELETE
function removeGrade($id, $conn){
   $sql  = "DELETE FROM grades WHERE grade_id=?";
   $stmt = $conn->prepare($sql);
   return $stmt->execute([$id]) ? 1 : 0;
}
