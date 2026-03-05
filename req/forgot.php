<?php
include "../db_conn.php";

if (!isset($_POST['role'], $_POST['email'])) {
	die("Akses tidak valid");
}


$email = $_POST['email'];
$role  = $_POST['role'];

switch ($role) {
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

	default:
		die("Role tidak valid");
}

$sql = "SELECT $id FROM $table WHERE email_address=?";
$stmt = $conn->prepare($sql);
$stmt->execute([$email]);

if ($stmt->rowCount() == 1) {
	$user = $stmt->fetch();

	$token = bin2hex(openssl_random_pseudo_bytes(32));
	$expired = date("Y-m-d H:i:s", strtotime("+1 hour"));

	$conn->prepare(
		"INSERT INTO password_resets (user_id, user_role, token, expired_at)
		 VALUES (?,?,?,?)"
	)->execute([$user[$id], $role, $token, $expired]);

	echo "Link reset berhasil dibuat";
} else {
	echo "Email tidak ditemukan";
}
