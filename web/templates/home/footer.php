	<!-- ======= Footer ======= -->
	<footer id="footer">
		<div class="footer-top">
			<div class="container">
				<div class="row">
					<div class="col-lg-4 col-md-4 footer-contact">
						<h3>FIND IT FORUMS</h3>
						<p>
							Carrer D'Alberic, 18<br />
							46008 València, Valencia<br />
							Spain (España)<br /><br />
							<strong>Phone:</strong><a class="text-decoration-none text-white ms-2" href="tel:123456789">Not disclosed</a><br />
							<strong>Email:</strong><a class="text-decoration-none text-white ms-2" href="mailto:findit.forums@gmail.com">findit.forums@gmail.com</a><br />
						</p>
					</div>

					<div class="col-lg-4 col-md-4 footer-links">
						<h4>Useful Links</h4>
						<ul>
							<li><i class="bx bx-chevron-right"></i> <a href="#">Home</a></li>
							<li><i class="bx bx-chevron-right"></i> <a href="#about">About us</a></li>
							<li><i class="bx bx-chevron-right"></i> <a href="templates/docs/Findit_TermsOfAgreement.pdf" target="_blank">Terms of service</a></li>
						</ul>
					</div>

					<div class="col-lg-4 col-md-4 footer-newsletter">
						<h4>Join Our Newsletter</h4>
						<p>Subscribe to get the latest news about the platform!</p>
						<form action="index.php?ctl=newsletter" method="post" name="formNewsletter" id="formNewsletter">
							<input type="email" name="email" /><input type="submit" value="Subscribe" />
						</form>
					</div>
				</div>
			</div>
		</div>

		<div class="container">
			<div class="copyright-wrap d-md-flex py-4">
				<div class="me-md-auto text-center text-md-start">
					<div class="copyright">
						&copy; Copyright <strong><span>Techie</span></strong>. All Rights Reserved
					</div>
					<div class="credits">
						Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
					</div>
				</div>
				<div class="social-links text-center text-md-right pt-3 pt-md-0">
					<a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
					<a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
					<a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
					<a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
					<a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
				</div>
			</div>
		</div>
	</footer>
	<!-- End Footer -->
	<!-- Login Modal -->
	<div class="modal fade" id="loginModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title text-center fw-light fs-5" id="loginModalLabel">Sign into your account</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btnCloseLogin"></button>
				</div>
				<div class="modal-body">
					<form action="index.php?ctl=login" name="formLogin" id="formLogin" method="post">
						<div class="form-floating mb-3">
							<input type="text" class="form-control" id="loginModalFocus" name="user" placeholder="name@example.com" required />
							<label for="floatingInput">Username or Email</label>
						</div>
						<div class="form-floating mb-3">
							<input type="password" class="form-control" id="loginModalPassword" name="passw" placeholder="Password" required maxlength="30" />
							<label for="floatingPassword">Password</label>
						</div>

						<div class="form-check form-switch mb-3">
							<input class="form-check-input" type="checkbox" role="switch" id="showPassword">
							<label class="form-check-label" for="showPassword">Show password</label>
						</div>
						<div class="d-grid">
							<button class="btn btn-primary btn-login text-uppercase fw-bold form-submit" type="submit" id="bLogin" name="bLogin">
								Sign in<i class="bi bi-box-arrow-in-right ms-2"></i>
							</button>
							<?php
							if (isset($_SESSION['message']) && $_SESSION['message'] != '') {
								echo '<div class="alert alert-warning p-1 mt-2 mb-1 text-center" role="alert" id="contactAlert">
											<i class="bi bi-exclamation-circle me-2"></i>' . $_SESSION['message'] .
									'</div>';
							} ?>
						</div>
					</form>
					<p class="text-decoration-none text-center mt-3 mb-0"><a class="link-offset-2" data-bs-target="#forgotModal" data-bs-toggle="modal">Forgot your password?</a></p>
				</div>
				<div class="modal-footer justify-content-center">
					<button class="btn btn-danger btn-google btn-login text-uppercase fw-bold" type="submit" disabled>
						<i class="bi bi-google me-2"></i> Sign in with Google
					</button>
					<button class="btn btn-primary btn-facebook btn-login text-uppercase fw-bold" type="submit" disabled>
						<i class="bi bi-facebook me-2"></i> Sign in with Facebook
					</button>
					<p class="mt-4">
						Don't have an account?
						<a class="text-decoration-none link-offset-2" data-bs-target="#signupModal" data-bs-toggle="modal">Sign up here!</a>
					</p>
				</div>
			</div>
		</div>
	</div>
	<!--END Login Modal-->
	<!--Signup Modal-->
	<div class="modal fade modal-xl" id="signupModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="signupModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-fullscreen-md-down">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title text-center fw-light fs-5" id="signupModalLabel">Create your account</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btnCloseSignup"></button>
				</div>
				<div class="modal-body">
					<form action="index.php?ctl=signup" method="post" name="formSignup" id="formSignup">
						<fieldset>
							<legend class="text-center">User Info</legend>
							<div class="row row-cols-1 row-cols-sm-2 gx-md-2 mb-2 mb-md-0">
								<div class="col">
									<div class="form-floating mb-3">
										<input type="text" class="form-control" id="signupModalFocus" placeholder="First name" name="name" title="Enter your first name" required />
										<label for="signupModalFocus">First name</label>
									</div>
								</div>
								<div class="col">
									<div class="form-floating mb-3">
										<input type="text" class="form-control" id="signupModalSurname" placeholder="Surname" name="lastname" title="Enter your surname" required />
										<label for="signupModalSurname">Surname</label>
									</div>
								</div>
								<div class="col">
									<div class="form-floating mb-3">
										<select class="form-select" id="signupModalCountry" name="country" title="Choose a country" required>
											<?php
											foreach ($countriesList as $country) {
												echo '<option value="' . $country["country_id"] . '">' . $country["name"] . '</option>';
											}
											?>
										</select>
										<label for="signupModalCountry">Country</label>
									</div>
								</div>
								<div class="col">
									<div class="form-floating mb-3">
										<select class="form-select" id="signupModalProvince" name="province" title="Choose a province" required>
											<?php
											foreach ($provincesList as $province) {
												echo '<option value="' . $province["province_id"] . '">' . $province["name"] . '</option>';
											}
											?>
										</select>
										<label for="signupModalProvince">Province</label>
									</div>
								</div>
							</div>
							<div class="d-md-flex wrap py-2">
								<span class="mb-0 me-4">Gender (Optional):</span>
								<div class="form-check form-check-inline mb-0 me-4">
									<input class="form-check-input" type="radio" name="gender" id="female" value="female" />
									<label class="form-check-label" for="female">Female</label>
								</div>
								<div class="form-check form-check-inline mb-0 me-4">
									<input class="form-check-input" type="radio" name="gender" id="male" value="male" />
									<label class="form-check-label" for="male">Male</label>
								</div>
								<div class="form-check form-check-inline mb-0">
									<input class="form-check-input" type="radio" name="gender" id="other" value="other" />
									<label class="form-check-label" for="other">Other</label>
								</div>
							</div>
						</fieldset>
						<fieldset class="mt-3">
							<legend class="text-center">Login Info</legend>

						</fieldset>
						<div class="row row-cols-1 row-cols-sm-2 gx-md-2 mb-2 mb-md-0">
							<div class="col">
								<div class="form-floating mb-3">
									<input type="text" name="email" class="form-control" id="signupModalEmail" placeholder="name@example.com" title="Enter your email" required />
									<label for="signupModalEmail">Email</label>
								</div>
							</div>
							<div class="col">
								<div class="form-floating mb-3">
									<input type="text" name="remail" class="form-control" id="signupModalReemail" placeholder="name@example.com" title="Enter your email" required />
									<label for="signupModalReemail">Repeat Email</label>
								</div>
							</div>
						</div>
						<div class="row row-cols-1 gx-md-2 mb-2 mb-md-0">
							<div class="col">
								<div class="form-floating mb-3">
									<input type="text" class="form-control" id="signupModalUsername" name="user" placeholder="Username" title="Choose a username" required />
									<label for="signupModalUsername">Username</label>
								</div>
							</div>
						</div>
						<div class="row row-cols-1 row-cols-sm-2 gx-md-2 mb-2 mb-md-0">
							<div class="col">
								<div class="form-floating mb-3">
									<input type="password" class="form-control" id="signupModalPassword" name="password" placeholder="Password" title="Tip: Use a strong password" required maxlength="30" />
									<label for="signupModalPassword">Password</label>
								</div>
							</div>
							<div class="col">
								<div class="form-floating mb-3">
									<input type="password" class="form-control" id="signupModalRepassword" name="repassword" placeholder="Repeat Password" title="Repeat password" required maxlength="30" />
									<label for="signupModalRepassword">Repeat Password</label>
								</div>
							</div>
						</div>
						<p class="small mb-3 p-0 text-center">
							Password requirements: lowercase, uppercase, one special character: $, @, *, +, -, _, &. (8 - 30 characters)
						</p>

						<div class="form-check d-flex justify-content-center mb-2">
							<input class="form-check-input me-2" type="checkbox" value="" name="termsAgree" id="termsAgree" required />
							<label class="form-check-label" for="termsAgree">
								I agree all statements in
								<!--<a class="" data-bs-toggle="modal" href="#termsModal" role="link">Terms of Service</a>-->
								<a class="text-decoration-none" href="templates/docs/FindIt_TermsOfAgreement.pdf" target="_blank" role="link">Terms of Service</a>
							</label>
						</div>
						<div class="d-grid">
							<button class="btn btn-primary btn-login text-uppercase fw-bold form-submit" type="submit" name="bSignup" id="bSignup">
								Sign up
							</button>
							<p class="small mb-3 p-0 text-center">
								<?php if (isset($errores)) {
									foreach ($errores as $error) {
										echo '<div class="alert alert-danger p-1 mt-2 mb-1 text-center" role="alert">
										<i class="bi bi-info-circle me-2"></i>' . $error .
											'</div>';
									}
								} else if (isset($_SESSION['signup'])) {
									echo '<div class="alert alert-info p-1 mt-2 mb-1 text-center" role="alert">
										<i class="bi bi-info-circle me-2"></i>' . $_SESSION['signup'] .
										'</div>';
								} ?>
							</p>
						</div>
					</form>
				</div>
				<div class="modal-footer justify-content-center">
					<div class="row row-cols-1">
						<button class="btn btn-danger btn-google btn-login text-uppercase fw-bold" type="submit" name="bGoogle" id="bGoogle" disabled>
							<i class="bi bi-google me-2"></i> Sign up with Google
						</button>
						<button class="btn btn-primary btn-facebook btn-login text-uppercase fw-bold mt-2" type="submit" name="bFacebook" id="bFacebook" disabled>
							<i class="bi bi-facebook me-2"></i> Sign up with Facebook
						</button>
						<p class="mt-4 text-center">
							Already have an account?
							<a class="text-decoration-none link-offset-2" data-bs-target="#loginModal" data-bs-toggle="modal">Sign in</a>
						</p>
						<!--<input type="button" value="Stop loading" onclick="stopFormLoading(document.getElementById('bSignup'),'Sign up')" />-->
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--END Signup Modal-->
	<!-- Forgot Password Modal -->
	<div class="modal fade" id="forgotModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="forgotModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title text-center fw-light fs-5" id="forgotModalLabel">Password Reset</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btnCloseForgot"></button>
				</div>
				<div class="modal-body">
					<form class="needs-validation" action="" name="formForgot" id="formForgot" method="post">
						<div class="form-floating mb-3">
							<input type="email" class="form-control" id="forgotModalFocus" placeholder="name@example.com" required />
							<label for="floatingInput">Email</label>
						</div>
						<div class="form-floating mb-3">
							<input type="password" class="form-control" id="forgotModalPassw" placeholder="Password" maxlength="30" />
							<label for="floatingPassword">Last password you remember (Optional)</label>
						</div>

						<div class="d-grid">
							<button class="btn btn-primary btn-login text-uppercase fw-bold form-click" type="submit" name="bForgot" id="bForgot">
								Reset Password<i class="bi bi-arrow-clockwise ms-2"></i>
							</button>
							<?php /*
							if (isset($_SESSION['message']) && $_SESSION['message'] != '') {
								echo '<div class="alert alert-info p-1 mt-2 mb-1 text-center" role="alert" id="forgotAlert">
								<i class="bi bi-info-circle me-2"></i>' . $_SESSION['message'] .
									'</div>';
							} */ ?>
						</div>
						<div class="d-grid" id="forgotAppend"></div>
					</form>
				</div>
				<div class="modal-footer justify-content-center">
					<p>
						Remembered your password?
						<a class="text-decoration-none link-offset-2" data-bs-target="#loginModal" data-bs-toggle="modal">Back to Login</a>
					</p>
					<!--<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary">Save changes</button>-->
				</div>
			</div>
		</div>
	</div>
	<!--END Forgot Password Modal-->
	<!-- COOKIES MODAL -->
	<div class="modal fade" id="myModalCookies" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title fs-5" id="staticBackdropLabel">
						Cookie Policy Notice
					</h1>
					<img class="img-fluid" src="templates/home/assets/img/findit-logo-mail.png" alt="Find It Logo" width="50">

				</div>
				<div class="modal-body">
					<p class="mb-3 py-sm-2 py-md-3 text-center">Hi there! You need to accept the cookie policy to be able to browse our site.</p>
				</div>
				<div class="modal-footer justify-content-around">
					<a class="text-decoration-none" href="templates/docs/FindIt_TermsOfAgreement.pdf" target="_blank" role="link">Terms of Service</a>
					<form action="" method="post" name="formCookies" id="formCookies">
						<button type="submit" name="bAcceptCookies" id="bAcceptCookies" class="btn btn-primary" data-bs-dismiss="modal">
							Fine by me
						</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- END COOKIES MODAL -->
	<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
	<div id="preloader"></div>
	<!-- JS FILES -->
	<script src="js/jquery-3.6.3.min.js"></script>
	<script src="templates/home/assets/js/lib.js"></script>
	<script src="js/modals.js"></script>
	<script src="js/ajax.js"></script>

	<!-- Vendor JS Files -->
	<script src="templates/home/assets/vendor/purecounter/purecounter_vanilla.js"></script>
	<script src="templates/home/assets/vendor/aos/aos.js"></script>
	<script src="templates/home/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="templates/home/assets/vendor/glightbox/js/glightbox.min.js"></script>
	<script src="templates/home/assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
	<script src="templates/home/assets/vendor/swiper/swiper-bundle.min.js"></script>
	<script src="templates/home/assets/vendor/php-email-form/validate.js"></script>

	<!-- Template Main JS File -->
	<script src="templates/home/assets/js/main.js"></script>
	<!-- Cookie Policy JS File -->
	<?php if (!isset($_COOKIE['acceptCookies']) && !isset($cookiesAccepted)) { ?>
		<script src="./js/cookies.js"></script>
	<?php } ?>
	</body>

	</html>