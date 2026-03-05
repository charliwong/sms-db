<?php  
function getAllUsers($conn) {
    $sql = "
    SELECT admin_id AS id, username, fname, lname, 'Admin' AS role
    FROM admin

    UNION ALL

    SELECT teacher_id AS id, username, fname, lname, 'Teacher' AS role
    FROM teachers

    UNION ALL

    SELECT student_id AS id, username, fname, lname, 'Student' AS role
    FROM students

    UNION ALL

    SELECT r_user_id AS id, username, fname, lname, 'Registrar' AS role
    FROM registrar_office
    ";

    return $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}
