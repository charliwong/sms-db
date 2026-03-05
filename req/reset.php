<?php
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

switch ($row['user_role']) {
	case 'admin':
		$table = 'admin';
		$id = 'admin_id';
		break;
	case 'teacher':
		$table = 'teacher';
		$id = 'teacher_id';
		break;
	case 'student':
		$table = 'student';
		$id = 'student_id';
		break;
	case 'kepala_sekolah':
		$table = 'kepala_sekolah';
		$id = 'r_user_id';
		break;
}

$sql = "UPDATE $table SET password=? WHERE $id=?";
$conn->prepare($sql)->execute([$password, $row['user_id']]);
