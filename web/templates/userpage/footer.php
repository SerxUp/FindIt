<!-- ======= Footer ======= -->
<footer id="footer">
	<div class="container">
		<div class="copyright">
			&copy; Copyright <strong><span>iPortfolio</span></strong>
		</div>
		<div class="credits">
			<!-- All the links in the footer should remain intact. -->
			<!-- You can delete the links only if you purchased the pro version. -->
			<!-- Licensing information: https://bootstrapmade.com/license/ -->
			<!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/iportfolio-bootstrap-portfolio-websites-template/ -->
			Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
		</div>
	</div>
</footer><!-- End  Footer -->
<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- DISABLE USER MODAL -->
<div class="modal fade" id="visibilityModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<form action="index.php?ctl=postVisibility" method="post" name="formVisibility" id="formVisibility">
				<div class="modal-header">
					<h1 class="modal-title fs-5" id="staticBackdropLabel">Change Post Visibility</h1>
					<input type="text" class="visually-hidden" name="username">
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div class="row row-cols-1 gx-md-2 mb-2 mb-md-0">
						<div class="col">
							<div class="form-floating mb-3">
								<select class="form-select" id="visibilityModalVis" name="visibility" title="New visibility" required>
									<option value="2">Public</option>
									<option value="1">Friends</option>
									<option value="0">Private</option>
								</select>
								<label for="signupModalProvince">Change visibility to: </label>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
					<button type="submit" id="bChangeVisibility" name="bChangeVisibility" class="btn btn-primary" data-bs-dismiss="modal">Continue</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- JS FILES -->
<script src="templates/home/assets/js/lib.js"></script>
<!-- Vendor JS Files -->
<script src="templates/userpage/assets/vendor/purecounter/purecounter_vanilla.js"></script>
<script src="templates/userpage/assets/vendor/aos/aos.js"></script>
<script src="templates/userpage/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="templates/userpage/assets/vendor/glightbox/js/glightbox.min.js"></script>
<script src="templates/userpage/assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
<script src="templates/userpage/assets/vendor/swiper/swiper-bundle.min.js"></script>
<script src="templates/userpage/assets/vendor/typed.js/typed.min.js"></script>
<script src="templates/userpage/assets/vendor/waypoints/noframework.waypoints.js"></script>
<script src="templates/userpage/assets/vendor/php-email-form/validate.js"></script>
<script src="templates/userpage/assets/vendor/simple-datatables/simple-datatables.js"></script>

<!-- Template Main JS File -->
<script src="templates/userpage/assets/js/main.js"></script>

</body>

</html>