<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login - SMAK ST. BENEDIKTUS PALUE</title>

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css?v=2">
	<link rel="icon" href="logos.png">
</head>
<body class="body-login">

<div class="black-fill d-flex justify-content-center align-items-center">
	<div class="text-center w-100">

		<form class="login mx-auto"
		      method="post"
		      action="req/login.php">

			<img src="logos.png" width="100" class="mb-3">
			<h3 class="mb-4">LOGIN</h3>

			<?php if (isset($_GET['error'])) { ?>
				<div class="alert alert-danger">
					<?=$_GET['error']?>
				</div>
			<?php } ?>

			<div class="mb-3 text-start">
				<label class="form-label">Username</label>
				<input type="text" class="form-control" name="uname">
			</div>

			<div class="mb-3 text-start">
				<label class="form-label">Password</label>
				<input type="password" class="form-control" name="pass">
			</div>

			<div class="mb-4 text-start">
				<label class="form-label">Login Sebagai</label>
				<select class="form-control" name="role">
					<option value="1">Admin</option>
					<option value="2">Guru</option>
					<option value="3">Siswa</option>
					<option value="4">Kepala Sekolah</option>
				</select>
			</div>

			<div class="d-flex flex-column gap-3">
	<button type="submit" class="btn btn-primary">
		Login
	</button>

	<a href="forgot.php" class="text-decoration-none">
		Lupa Username / Password?
	</a>
</div>
</form>

			<div class="mt-3">
				<a href="index.php" class="text-decoration-none text-light">
					← Kembali ke Home
				</a>
			</div>
		</form>

		<div class="mt-4 text-light">
			Copyright &copy; SMAK ST. BENEDIKTUS PALUE School. All rights reserved.
		</div>

	</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
