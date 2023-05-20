<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<meta content="width=device-width, initial-scale=1.0" name="viewport" />

	<title>Find It | Home</title>
	<meta content="" name="description" />
	<meta content="" name="keywords" />

	<!-- Favicons -->
	<link href="templates/home/assets/img/findit-favicon.png" rel="icon" />
	<link href="templates/home/assets/img/findit-favicon.png" rel="apple-touch-icon" />

	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet" />

	<!-- Vendor CSS Files -->
	<link href="templates/home/assets/vendor/aos/aos.css" rel="stylesheet" />
	<link href="templates/home/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
	<link href="templates/home/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet" />
	<link href="templates/home/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet" />
	<link href="templates/home/assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet" />
	<link href="templates/home/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet" />

	<!-- Template Main CSS File -->
	<link href="templates/home/assets/css/style.css" rel="stylesheet" />

	<!-- =======================================================
  * Template Name: Techie
  * Updated: Mar 10 2023 with Bootstrap v5.2.3
  * Template URL: https://bootstrapmade.com/techie-free-skin-bootstrap-3/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>
	<!-- ======= Header ======= -->
	<header id="header" class="fixed-top">
		<div class="container d-flex align-items-center justify-content-between">
			<a href="index.php" class="logo"><img src="templates/home/assets/img/findit-logo-transparent.png" alt="FIND IT LOGO" class="img-fluid" /></a>

			<nav id="navbar" class="navbar">
				<ul>
					<li><a class="nav-link scrollto active" href="#hero">Home</a></li>
					<li><a class="nav-link scrollto" href="#about">About</a></li>
					<li><a class="nav-link scrollto" href="#features">Features</a></li>
					<!--<li><a class="nav-link scrollto" href="#portfolio">Portfolio</a></li>-->
					<li><a class="nav-link scrollto" href="#contact">Contact</a></li>
					<li class="dropdown">
						<a class="nav-link" href="#"><span>More</span> <i class="bi bi-chevron-down"></i></a>
						<ul>
							<li><a href="https://github.com/SerxUp/FindIt" target="_blank">GitHub Repository</a></li>
							<li><a class="scrollto" href="#donations">Donations</a></li>
							<li><a class="scrollto" href="#testimonials">Testimonials</a></li>
							<li><a class="scrollto" href="#faq">FAQS</a></li>
							<?php if ($_SESSION['user_status'] > 0) {
								echo '<li class="dropdown">
								<a class="nav-link" href="#"><span>User</span> <i class="bi bi-chevron-right"></i></a>
								<ul>
									<li><a class="scrollto" href="index.php?ctl=userpage#myposts">My Posts</a></li>
									<li><a class="scrollto" href="index.php?ctl=userpage#new">New Post</a></li>
									<li><a class="scrollto" href="index.php?ctl=userpage#saved">Saved Posts</a></li>
									<li><a class="scrollto" href="index.php?ctl=userpage#forum">Forum</a></li>
									<li><a class="scrollto" href="index.php?ctl=exit">Log Out</a></li>
								</ul>
							</li>';
							} ?>
						</ul>
					</li>
					<?php if ($_SESSION['user_status'] > 0) {
						echo '<li><a class="getstarted text-decoration-none" href="index.php?ctl=userpage" role="link">My Account</a></li>';
					} else {
						echo '<li><a class="getstarted text-decoration-none" id="loginModalBtn" data-bs-toggle="modal" data-bs-target="#loginModal" role="link">Login | Sign Up</a></li>';
					}
					?>
				</ul>
				<i class="bi bi-list mobile-nav-toggle"></i>
			</nav>
			<!-- .navbar -->
		</div>
	</header>
	<!-- End Header -->