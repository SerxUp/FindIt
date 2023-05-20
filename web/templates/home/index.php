<?php ob_start();
if (isset($_SESSION['fatal_error'])) {
} ?>
<!-- ======= Hero Section ======= -->
<section id="hero" class="d-flex align-items-center">
	<div class="container-fluid" data-aos="fade-up">
		<div class="row justify-content-center">
			<div class="col-xl-5 col-lg-6 pt-3 pt-lg-0 order-2 order-lg-1 d-flex flex-column justify-content-center">
				<h1>Find It! Forums, Redefined.</h1>
				<h2>Connect with a worldwide forum community.</h2>
				<div>
					<?php
					if (isset($_SESSION['user_status'])) {
						if ($_SESSION['user_status'] > 0) {
							echo "<a class='btn-get-started text-decoration-none' href='index.php?ctl=userpage' id='userPageBtn'>My Account</a>";
						} else {
							echo "<a class='btn-get-started text-decoration-none' id='loginModalBtn' data-bs-toggle='modal' data-bs-target='#loginModal'>Login | Sign Up</a>";
						}
					}
					?>
				</div>
			</div>
			<div class="col-xl-4 col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-in" data-aos-delay="150">
				<img src="templates/home/assets/img/hero-img.png" class="img-fluid animated" alt="home page: main image" />
			</div>
		</div>
	</div>
</section>
<!-- End Hero -->

<main id="main">
	<!-- ======= About Section ======= -->
	<section id="about" class="about">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 order-1 order-lg-2" data-aos="zoom-in" data-aos-delay="150">
					<img src="templates/home/assets/img/about.jpg" class="img-fluid" alt="" />
				</div>
				<div class="col-lg-6 pt-4 pt-lg-0 order-2 order-lg-1 content" data-aos="fade-right">
					<h3>What can we tell you about <strong>Find It Forums</strong>?</h3>
					<p class="fst-italic">
						These are some of the goals we stand for:
					</p>
					<ul>
						<li><i class="bi bi-check-circle"></i> We provide a user-friendly platform for everyone, free of charge.</li>
						<li><i class="bi bi-check-circle"></i> As part of the Find It Open Source project, the community can take part in the development and debugging of the platform.</li>
						<li><i class="bi bi-check-circle"></i> And because we are always trying to improve, so all feedback is welcome.</li>
					</ul>
					<a href="https://github.com/SerxUp/FindIt" target="_blank" role="link" class="read-more"><i class='bx bxl-github'></i> Learn More</a>
				</div>
			</div>
		</div>
	</section>
	<!-- End About Section -->

	<!-- ======= Counts Section ======= -->
	<section id="counts" class="counts">
		<div class="container">
			<div class="row counters">
				<div class="col-lg-3 col-6 text-center">
					<?php
					if (isset($userCount)) {
						echo '<span data-purecounter-start="0" data-purecounter-end="' . $userCount . '" data-purecounter-duration="1" class="purecounter"></span>';
					} else {
						echo '<span data-purecounter-start="0" data-purecounter-end="99" data-purecounter-duration="1" class="purecounter"></span>';
					}
					?>
					<p>Users</p>
				</div>

				<div class="col-lg-3 col-6 text-center">
					<?php
					if (isset($postCount)) {
						echo '<span data-purecounter-start="0" data-purecounter-end="' . $postCount . '" data-purecounter-duration="1" class="purecounter"></span>';
					} else {
						echo '<span data-purecounter-start="0" data-purecounter-end="99" data-purecounter-duration="1" class="purecounter"></span>';
					}
					?>
					<p>Posts</p>
				</div>

				<div class="col-lg-3 col-6 text-center">
					<span data-purecounter-start="0" data-purecounter-end="999" data-purecounter-duration="3" class="purecounter"></span>
					<p>Hours of Development</p>
				</div>

				<div class="col-lg-3 col-6 text-center">
					<span data-purecounter-start="100" data-purecounter-end="1" data-purecounter-duration="1" class="purecounter"></span>
					<p>Hard Worker</p>
				</div>
			</div>
		</div>
	</section>
	<!-- End Counts Section -->

	<!-- ======= Features Section ======= -->
	<section id="features" class="features">
		<div class="container" data-aos="fade-up">
			<div class="section-title">
				<h2>Features</h2>
				<p>
					As a feature-rich platform, these are some of <strong>Find It Forums</strong> highlight features:
				</p>
			</div>

			<div class="row">
				<div class="col-lg-6 order-2 order-lg-1 d-flex flex-column align-items-lg-center">
					<div class="icon-box mt-5 mt-lg-0" data-aos="fade-up" data-aos-delay="100">
						<i class='bx bx-lock-open'></i>
						<h4>Open Source</h4>
						<p>Distributed under GNU General Public License v3.0 (<a href="https://github.com/SerxUp/FindIt" target="_blank">GitHub</a>).</p>
					</div>
					<div class="icon-box mt-5" data-aos="fade-up" data-aos-delay="200">
						<i class='bx bx-network-chart'></i>
						<h4>Global Network of Forums</h4>
						<p>You can access it from almost anywhere in the globe.</p>
					</div>
					<div class="icon-box mt-5" data-aos="fade-up" data-aos-delay="300">
						<i class='bx bx-money-withdraw'></i>
						<h4>Free of charge</h4>
						<p>A platform with no associated costs for its users.</p>
					</div>
					<div class="icon-box mt-5" data-aos="fade-up" data-aos-delay="400">
						<i class="bx bx-shield"></i>
						<h4>Secure AF</h4>
						<p>We keep your data secure, or we die trying.</p>
					</div>
				</div>
				<div class="image col-lg-6 order-1 order-lg-2" data-aos="zoom-in" data-aos-delay="100">
					<img src="templates/home/assets/img/features.svg" alt="" class="img-fluid" />
				</div>
			</div>
		</div>
	</section>
	<!-- End Features Section -->

	<!-- ======= Testimonials Section ======= -->
	<section id="testimonials" class="testimonials section-bg">
		<div class="container" data-aos="fade-up">
			<div class="section-title">
				<h2>Testimonials</h2>
				<p>
					Here we showcase the testimonials of team members, associates and users of <strong>Find It Forums</strong>, who were nice enough to write a few words about either their experience while using the platform, or some personal thoughts that wanted to share in relation with this project.
				</p>
			</div>

			<div class="testimonials-slider swiper" data-aos="fade-up" data-aos-delay="100">
				<div class="swiper-wrapper">
					<div class="swiper-slide">
						<div class="testimonial-item">
							<p>
								<i class="bx bxs-quote-alt-left quote-icon-left"></i>
								All I wanna say in regards of the experience of developing this proyect is that I had hair a few months ago... But still, I would do it again!<br><br>Now I have to go to Turkey to get some hair implants...
								<i class="bx bxs-quote-alt-right quote-icon-right"></i>
							</p>
							<img src="templates/home/assets/img/testimonials/testimonials-1.jpg" class="testimonial-img" alt="" />
							<h3>Sergio Adam</h3>
							<h4>CEO &amp; Founder</h4>
						</div>
					</div>
					<!-- End testimonial item -->

					<div class="swiper-slide">
						<div class="testimonial-item">
							<p>
								<i class="bx bxs-quote-alt-left quote-icon-left"></i>
								Export tempor illum tamen malis malis eram quae irure esse labore quem cillum quid cillum eram malis quorum
								velit fore eram velit sunt aliqua noster fugiat irure amet legam anim culpa.
								<i class="bx bxs-quote-alt-right quote-icon-right"></i>
							</p>
							<img src="templates/home/assets/img/testimonials/testimonials-2.jpg" class="testimonial-img" alt="" />
							<h3>Marina Garcia</h3>
							<h4>The girlfriend</h4>
						</div>
					</div>
					<!-- End testimonial item -->

					<div class="swiper-slide">
						<div class="testimonial-item">
							<p>
								<i class="bx bxs-quote-alt-left quote-icon-left"></i>
								Enim nisi quem export duis labore cillum quae magna enim sint quorum nulla quem veniam duis minim tempor
								labore quem eram duis noster aute amet eram fore quis sint minim.
								<i class="bx bxs-quote-alt-right quote-icon-right"></i>
							</p>
							<img src="templates/home/assets/img/testimonials/testimonials-3.jpg" class="testimonial-img" alt="" />
							<h3>Jena Karlis</h3>
							<h4>Store Owner</h4>
						</div>
					</div>
					<!-- End testimonial item -->

					<div class="swiper-slide">
						<div class="testimonial-item">
							<p>
								<i class="bx bxs-quote-alt-left quote-icon-left"></i>
								Fugiat enim eram quae cillum dolore dolor amet nulla culpa multos export minim fugiat minim velit minim dolor
								enim duis veniam ipsum anim magna sunt elit fore quem dolore labore.
								<i class="bx bxs-quote-alt-right quote-icon-right"></i>
							</p>
							<img src="templates/home/assets/img/testimonials/testimonials-4.jpg" class="testimonial-img" alt="" />
							<h3>Matt Brandon</h3>
							<h4>Freelancer</h4>
						</div>
					</div>
					<!-- End testimonial item -->

					<div class="swiper-slide">
						<div class="testimonial-item">
							<p>
								<i class="bx bxs-quote-alt-left quote-icon-left"></i>
								Quis quorum aliqua sint quem legam fore sunt eram irure aliqua veniam tempor noster veniam enim culpa labore
								duis sunt culpa nulla illum cillum fugiat legam esse veniam culpa.
								<i class="bx bxs-quote-alt-right quote-icon-right"></i>
							</p>
							<img src="templates/home/assets/img/testimonials/testimonials-5.jpg" class="testimonial-img" alt="" />
							<h3>John Larson</h3>
							<h4>Entrepreneur</h4>
						</div>
					</div>
					<!-- End testimonial item -->
				</div>
				<div class="swiper-pagination"></div>
			</div>
		</div>
	</section>
	<!-- End Testimonials Section -->

	<!-- ======= Pricing Section ======= -->
	<section id="donations" class="pricing">
		<div class="container" data-aos="fade-up">
			<div class="section-title">
				<h2>Donations</h2>
				<p>
					We believe that our platform should be <strong>completely free</strong> for all users, since it aims to provide a service accesible to anyone, and not hidden behind a paywall. With that said, our team of developers needs eat from time to time (rarely).<br><br>That is why we thank any member that is able to donate a small amount destined to fund this project and help make this site better.
				</p>
			</div>


			<div class="row">
				<div class="col-lg-4 col-md-6 offset-lg-4 offset-md-3" data-aos="fade-up" data-aos-delay="100">
					<div class="box">
						<h3>PayPal Donation</h3>
						<img class="img-fluid" src="templates/home/assets/img/paypal-qr.png" alt="PayPal Donation QR Code">
						<div class="btn-wrap">
							<form action="https://www.paypal.com/donate" method="post" target="_blank">
								<input type="hidden" name="hosted_button_id" value="5WPKG2J3WZDKL" />
								<input type="image" src="https://www.paypalobjects.com/en_US/ES/i/btn/btn_donateCC_LG.gif" border="0" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Donate with PayPal button" />
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- End Pricing Section -->

	<!-- ======= Frequently Asked Questions Section ======= -->
	<section id="faq" class="faq">
		<div class="container" data-aos="fade-up">
			<div class="section-title">
				<h2>Frequently Asked Questions</h2>
				<p>
					You may have some doubts about this platform, that is why we collected the most common questions that one of our users may encounter.<br>Still, if you don't find the answer you are looking for here, feel free to scroll down to the <a href="#contact" class="btn btn-outline-light btn-sm fw-bold text-decoration-none">Contact section</a> to send a message to our Support Team.
				</p>
			</div>

			<div class="faq-list">
				<ul>
					<li data-aos="fade-up" data-aos="fade-up" data-aos-delay="100">
						<i class="bx bx-help-circle icon-help"></i>
						<a data-bs-toggle="collapse" class="collapse" data-bs-target="#faq-list-1">How can I create an account? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
						<div id="faq-list-1" class="collapse show" data-bs-parent=".faq-list">
							<p>
								Creating an account is very easy! All you need to do is click the "Login | Sign Up" button, then "Sign up here!".<br>From there you need to input your user information and click "Sign Up". Finally, you will get an email with a link to verify your account.
							</p>
						</div>
					</li>

					<li data-aos="fade-up" data-aos-delay="200">
						<i class="bx bx-help-circle icon-help"></i>
						<a data-bs-toggle="collapse" data-bs-target="#faq-list-2" class="collapsed">What can I do as a user? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
						<div id="faq-list-2" class="collapse" data-bs-parent=".faq-list">
							<p>
								As a Find It Forums User, you can create posts, delete them, browse other user's posts, save them, and even leave a comment!.
							</p>
						</div>
					</li>

					<li data-aos="fade-up" data-aos-delay="300">
						<i class="bx bx-help-circle icon-help"></i>
						<a data-bs-toggle="collapse" data-bs-target="#faq-list-3" class="collapsed">What if I have a platform-related issue? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
						<div id="faq-list-3" class="collapse" data-bs-parent=".faq-list">
							<p>
								If you have any issue whatsoever, feel free to send a message to our Support Team through the "Contact" form. We will assess your issue and get back to you ASAP.
							</p>
						</div>
					</li>

					<li data-aos="fade-up" data-aos-delay="400">
						<i class="bx bx-help-circle icon-help"></i>
						<a data-bs-toggle="collapse" data-bs-target="#faq-list-4" class="collapsed">Why use Find It Forums instead of something else? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
						<div id="faq-list-4" class="collapse" data-bs-parent=".faq-list">
							<p>
								You can always choose the platform that works best for you! Find It Forums delivers a modern, responsive UI, high data security, and comes free of charge.
							</p>
						</div>
					</li>

					<li data-aos="fade-up" data-aos-delay="500">
						<i class="bx bx-help-circle icon-help"></i>
						<a data-bs-toggle="collapse" data-bs-target="#faq-list-5" class="collapsed">Can I add other users as friends?
							<i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
						<div id="faq-list-5" class="collapse" data-bs-parent=".faq-list">
							<p>
								This is a feature that is in the works, and will be available soon. Just like the newsletter subscription!
							</p>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</section>
	<!-- End Frequently Asked Questions Section -->
	<!-- ======= Contact Section ======= -->
	<section id="contact" class="contact section-bg">
		<div class="container" data-aos="fade-up">
			<div class="section-title">
				<h2>Contact</h2>
				<p>
					Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint consectetur velit.
					Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat sit in iste officiis commodi quidem
					hic quas.
				</p>
			</div>

			<div class="row">
				<div class="col-lg-6">
					<a href="https://goo.gl/maps/sgnL2MewxvHZjghG6?coh=178571&entry=tt" class="text-decoration-none" target="_blank">
						<div class="info-box mb-4">
							<i class="bx bx-map"></i>
							<h3>Our Address</h3>
							<p>Carrer D'Alberic, 18, 46008 València, Valencia</p>
						</div>
					</a>
				</div>

				<div class="col-lg-3 col-md-6">
					<a href="mailto:findit.forums@example.com" class="text-decoration-none">
						<div class="info-box mb-4">

							<i class="bx bx-envelope"></i>
							<h3>Email Us</h3>
							<p>findit.forums@example.com</p>
						</div>
					</a>
				</div>

				<div class="col-lg-3 col-md-6">
					<a href="tel:+34123456789" class="text-decoration-none">
						<div class="info-box mb-4">
							<i class="bx bx-phone-call"></i>
							<h3>Call Us</h3>
							<p>+34 123 456 789</p>
						</div>
					</a>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-3">
					<iframe class="mb-md-3" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d1540.0395899415362!2d-0.3886541!3d39.4675399!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd604f46da4855e1%3A0x9c6c795bc92d164e!2sI.E.S.%20Abastos!5e0!3m2!1ses!2ses!4v1683801102638!5m2!1ses!2ses" width="100%" height="384px" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
				</div>

				<div class="col-lg-6">
					<form id="formContact">
						<div class="row">
							<div class="col-md-6 form-group">
								<input type="text" name="contactName" class="form-control" id="contactName" placeholder="Name" maxlength="30" required />
							</div>
							<div class="col-md-6 form-group">
								<input type="text" class="form-control" name="contactLastname" id="contactLastname" placeholder="Surname" maxlength="30" required />
							</div>
						</div>
						<div class="row">
							<div class="col-md-6 form-group mt-3">
								<input type="email" class="form-control" name="contactEmail" id="contactEmail" placeholder="Email" required />
							</div>
							<div class="col-md-6 form-group mt-3">
								<input type="text" class="form-control" name="contactSubject" id="contactSubject" placeholder="Subject (Optional)" maxlength="30" />
							</div>
						</div>
						<div class="form-group mt-3">
							<textarea class="form-control" name="contactMessage" id="contactMessage" rows="5" placeholder="Message" maxlength="300" required></textarea>
						</div>
						<div class="text-center">
							<button class="btn btn-primary mt-3 form-click" type="submit" name="bContact" id="bContact">Send Message</button>
							<button class="btn btn-secondary mt-3 form-click" type="reset" name="bContactReset" id="bContactReset">Reset</button>
						</div>
						<div class="d-flex align-items-center justify-content-center" id="contactAppend">
							<!-- Generate alert w/ js 
							<div class="alert alert-success p-1 mt-3" role="alert" id="contactAlert">
								<i class="bi bi-check-circle me-2"></i>Message sent successfully!
							</div>-->
						</div>
				</div>
				<div class="col-lg-3">
					<div class="info-box mb-4">
						<img src="templates/home/assets/img/contact-qr.png" class="img-fluid p-2" alt="Contact QR Code" />
						<p class="p-2">You can also scan this QR Code to Contact us from your smartphone!</p>
					</div>
				</div>
				</form>
			</div>
		</div>
		</div>
	</section>
	<!-- End Contact Section -->

</main>
<!-- End #main -->

<?php
$navActive = "home";
$contenido = ob_get_clean();
$pie = 'templates/home/footer.php';
$menu = 'templates/home/header.php';
?>

<?php include 'templates/layout.php' ?>