<?php

function getStudentsByClassId($class_id, $conn){
    $sql = "SELECT student_id, fname, lname
            FROM students
            WHERE class_id = ?
            ORDER BY fname ASC";

    $stmt = $conn->prepare($sql);
    $stmt->execute([$class_id]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getStudentById($id, $conn){
    $sql = "SELECT * FROM students WHERE student_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);

    return ($stmt->rowCount() === 1)
        ? $stmt->fetch(PDO::FETCH_ASSOC)
        : 0;
}
