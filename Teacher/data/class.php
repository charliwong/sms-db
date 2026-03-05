<?php

function getAllClasses($conn){
    $sql = "SELECT 
                c.class_id,
                g.grade_id,
                g.grade_code,
                g.grade,
                c.section
            FROM class c
            JOIN grades g ON c.grade = g.grade_id
            ORDER BY g.grade, c.section";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getClassById($class_id, $conn){
    $sql = "SELECT 
                c.class_id,
                c.section,
                g.grade_id,
                g.grade,
                g.grade_code
            FROM class c
            JOIN grades g ON c.grade = g.grade_id
            WHERE c.class_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->execute([$class_id]);

    return ($stmt->rowCount() === 1)
        ? $stmt->fetch(PDO::FETCH_ASSOC)
        : 0;
}
