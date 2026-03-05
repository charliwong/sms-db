<?php  

// All Sections
function getAllSections($conn){
   $sql = "SELECT * FROM section";
   $stmt = $conn->prepare($sql);
   $stmt->execute();

   if ($stmt->rowCount() >= 1) {
     return $stmt->fetchAll();
   } else {
     return 0;
   }
}

// Get Section by ID
function getSectioById($section_id, $conn){
   $sql = "SELECT * FROM section WHERE section_id = ?";
   $stmt = $conn->prepare($sql);
   $stmt->execute([$section_id]);

   if ($stmt->rowCount() == 1) {
     return $stmt->fetch();
   } else {
     return false;
   }
}

// DELETE
function removeSection($id, $conn){
   $sql  = "DELETE FROM section WHERE section_id = ?";
   $stmt = $conn->prepare($sql);
   return $stmt->execute([$id]);
}
