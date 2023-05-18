<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1.0" name="viewport">

	<title>Find It | User Page</title>
	<meta content="" name="description">
	<meta content="" name="keywords">

	<!-- Favicons -->
	<link href="templates/home/assets/img/findit-favicon.png" rel="icon">
	<link href="templates/home/assets/img/findit-favicon.png" rel="apple-touch-icon">

	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

	<!-- Vendor CSS Files -->
	<link href="templates/userpage/assets/vendor/aos/aos.css" rel="stylesheet">
	<link href="templates/userpage/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="templates/userpage/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
	<link href="templates/userpage/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
	<link href="templates/userpage/assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
	<link href="templates/userpage/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
	<link href="templates/userpage/assets/vendor/simple-datatables/style.css" rel="stylesheet">

	<!-- Template Main CSS File -->
	<link href="templates/userpage/assets/css/style.css" rel="stylesheet">

	<!-- =======================================================
  * Template Name: iPortfolio
  * Updated: Mar 10 2023 with Bootstrap v5.2.3
  * Template URL: https://bootstrapmade.com/iportfolio-bootstrap-portfolio-websites-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

	<!-- ======= Mobile nav toggle button ======= -->
	<i class="bi bi-list mobile-nav-toggle d-xl-none"></i>

	<!-- ======= Header ======= -->
	<header id="header">
		<div class="d-flex flex-column">

			<div class="profile">
				<?php if (isset($_SESSION['picture_path'])) {
					echo '<img src="templates/imgs/avatar.png" alt="" class="img-fluid rounded-circle">';
				} else {
					echo '<img src="' . $_SESSION['picture_path'] . '" alt="" class="img-fluid rounded-circle">';
				}
				?>

				<h1 class="text-light"><a href="#hero"><?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'user'; ?></a></h1>
				<!--
				<div class="social-links mt-3 text-center">
					<a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
					<a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
					<a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
					<a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
					<a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
				</div>
-->
			</div>

			<nav id="navbar" class="nav-menu navbar">
				<ul>
					<li><a href="#hero" class="nav-link scrollto active"><i class='bx bxs-star'></i> <span>Start</span></a></li>
					<li><a href="#myposts" class="nav-link scrollto"><i class='bx bxs-folder-open'></i> <span>My Posts</span></a></li>
					<li><a href="#new" class="nav-link scrollto"><i class='bx bxs-edit'></i> <span>New Post</span></a></li>
					<li><a href="#saved" class="nav-link scrollto"><i class='bx bxs-bookmark-heart'></i> <span>Saved Posts</span></a></li>
					<li><a href="#forum" class="nav-link scrollto"><i class='bx bx-network-chart'></i> <span>Forum</span></a></li>
					<hr class="mt-5">
					<li><a href="index.php?ctl=home" class="nav-link"><i class='bx bx-home'></i> <span>Back Home</span></a></li>
					<li><a href="index.php?ctl=exit" class="nav-link"><i class='bx bx-log-out'></i> <span>Sign out</span></a></li>

				</ul>
			</nav><!-- .nav-menu -->
		</div>
	</header><!-- End Header -->