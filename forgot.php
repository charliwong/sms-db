<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>pemulihan data user</title>

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css?v=2">
	<link rel="icon" href="logos.png"></head>
<body class="body-forgot">

<div class="black-fill">


<div class="container mt-5">
	<div class="card mx-auto" style="max-width:400px;">
		<div class="card-body">
			<h4 class="mb-3">Reset Password</h4>

			<form method="post" action="req/forgot.php">
                <div class="mb-3">
                    <label>Akses Pengguna Sebagai</label>
                    <select name="role" class="form-control" required>
                        <option value="admin">Admin</option>
                        <option value="teacher">Guru</option>
                        <option value="student">Siswa</option>
                        <option value="kepala_sekolah">Kepala Sekolah</option>
                    </select>
                </div>
				<div class="mb-3">
					<label>Email Terdaftar</label>
					<input type="email" name="email" class="form-control" required>
				</div>

				<button class="btn btn-primary w-100">
					Kirim Link Reset
				</button>
			</form>

			<div class="mt-3 text-center">
				<a href="login.php">← Kembali ke Login</a>
			</div>

		</div>
	</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
