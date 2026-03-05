<?php 
include "DB_connection.php";
include "data/setting.php";
$setting = getSetting($conn);

if ($setting != 0) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Welcome to <?=$setting['school_name']?></title>

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css?v=2">
	<link rel="icon" href="logos.png">
</head>

<body class="body-home">

<div class="black-fill">

	<!-- ===== NAVBAR ===== -->
	<nav class="navbar navbar-expand-lg fixed-top" id="homeNav">
		<div class="container">
			<a class="navbar-brand d-flex align-items-center gap-2" href="#">
				<img src="logos.png" width="60">
				<strong><?=$setting['school_name']?></strong>
			</a>

			<button class="navbar-toggler" type="button" data-bs-toggle="collapse"
			        data-bs-target="#navbarNav">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="navbarNav">
				<ul class="navbar-nav ms-auto gap-3">
					<li class="nav-item">
						<a class="nav-link fw-semibold" href="#">Home</a>
					</li>
					<li class="nav-item">
						<a class="nav-link fw-semibold" href="#about">Tentang Sekolah</a>
					</li>
					<li class="nav-item">
						<a class="nav-link fw-semibold" href="#contact">Kritik dan Saran</a>
					</li>
					<li class="nav-item">
						<a class="btn btn-primary px-4" href="login.php">
							Login
						</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>

	<!-- ===== HERO / WELCOME ===== -->
	<section class="welcome-text text-center">
		<img src="logos.png">
		<h4 class="mt-3">
			Welcome to <?=$setting['school_name']?>
		</h4>
		<p class="mt-2">
			<?=$setting['slogan']?>
		</p>
	</section>

	<!-- ===== ABOUT ===== -->
	<section id="about">
		<div class="container d-flex justify-content-center">
			<div class="card card-1">
				<div class="row g-4 align-items-center">
					<div class="col-md-4 text-center">
						<img src="logos.png" class="img-fluid" width="120">
					</div>
					<div class="col-md-8">
						<h5>Tentang Sekolah</h5>
						<p><?=$setting['about']?></p>
						<small class="text-muted">
							<?=$setting['school_name']?>
						</small>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- ===== CONTACT ===== -->
	<section id="contact">
		<div class="container d-flex justify-content-center">
			<form method="post" action="req/contact.php">

				<h3>Kritik dan Saran</h3>

				<?php if (isset($_GET['error'])) { ?>
					<div class="alert alert-danger">
						<?=$_GET['error']?>
					</div>
				<?php } ?>

				<?php if (isset($_GET['success'])) { ?>
					<div class="alert alert-success">
						<?=$_GET['success']?>
					</div>
				<?php } ?>

				<div class="mb-3">
					<label class="form-label">Email Address</label>
					<input type="email" class="form-control" name="email">
				</div>

				<div class="mb-3">
					<label class="form-label">Nama Lengkap</label>
					<input type="text" class="form-control" name="full_name">
				</div>

				<div class="mb-4">
					<label class="form-label">Pesan</label>
					<textarea class="form-control" name="message" rows="4"></textarea>
				</div>

				<div class="text-center">
					<button type="submit" class="btn btn-primary px-5">
						Kirim Pesan
					</button>
				</div>
			</form>
		</div>
	</section>

	<!-- ===== FOOTER ===== -->
	<footer class="text-center text-light py-4">
		Copyright &copy; <?=$setting['current_year']?>
		<?=$setting['school_name']?>. All rights reserved.
	</footer>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
} else {
	header("Location: login.php");
	exit;
}
?>
