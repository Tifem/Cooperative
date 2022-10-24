<!doctype html>
<html lang="zxx">
    
<!-- Mirrored from templates.envytheme.com/dashli/default/log-in.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 10 Oct 2022 15:13:45 GMT -->
<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!-- Bootstrap Min CSS --> 
		<link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
		<!-- Owl Theme Default Min CSS --> 
		<link rel="stylesheet" href="{{asset('assets/css/owl.theme.default.min.css')}}">
		<!-- Owl Carousel Min CSS --> 
		<link rel="stylesheet" href="{{asset('assets/css/owl.carousel.min.css')}}">
		<!-- Animate Min CSS --> 
		<link rel="stylesheet" href="{{asset('assets/css/animate.min.css')}}">
		<!-- Remixicon CSS --> 
		<link rel="stylesheet" href="{{asset('assets/css/remixicon.css')}}">
		<!-- boxicons CSS --> 
		<link rel="stylesheet" href="{{asset('assets/css/boxicons.min.css')}}">
		<!-- MetisMenu Min CSS --> 
		<link rel="stylesheet" href="{{asset('assets/css/metismenu.min.css')}}">
		<!-- Simplebar Min CSS --> 
		<link rel="stylesheet" href="{{asset('assets/css/simplebar.min.css')}}">
		<!-- Style CSS -->
		<link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
		<!-- Dark Mode CSS -->
		<link rel="stylesheet" href="{{asset('assets/css/dark-mode.css')}}">
		<!-- Responsive CSS -->
		<link rel="stylesheet" href="{{asset('assets/css/responsive.css')}}">
		
		<!-- Favicon -->
		<link rel="icon" type="image/png" href="assets/images/favicon.png">
		<!-- Title -->
		<title>Promix - Admin Dashboard Bootstrap 5 Template</title>
    </head>

    <body class="body-bg-f5f5f5">
		<!-- Start Preloader Area -->
		<div class="preloader">
            <div class="content">
                <div class="box"></div>
            </div>
        </div>
		<!-- End Preloader Area -->

		<!-- Start User Area -->
		<div class="user-area">
			<div class="container">
				<div class="user-form-content">
					<h3>Log in</h3>
                    <p>Sign in to continue to Promix.</p>
				
					<form class="user-form"  method="POST" action="{{ route('login') }}">
                        @csrf
						<div class="row">
							<div class="col-12">
								<div class="form-group">
									<label>Email</label>
									<input class="form-control @error('email') is-invalid @enderror" type="email" name="email" placeholder="Enter your email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
								</div>
							</div>

							<div class="col-12">
								<div class="form-group">
									<label>Password</label>
									<input class="form-control  @error('password') is-invalid @enderror" type="password" name="password" placeholder="Enter your password" required autocomplete="current-password">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
								</div>
							</div>

							<div class="col-12">
								<div class="login-action">
									<span class="log-rem">
										<input id="remember-2" type="checkbox">
										<label>Keep me logged in</label>
									</span>
									
									<span class="forgot-login">
										<a href="sign-in.html">Forgot your password?</a>
									</span>
								</div>
							</div>

							<div class="col-12">
								<button class="default-btn" type="submit">
									Sign in
								</button>
							</div>

							

							
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- End User Area -->

		<div class="dark-bar">
			<a href="ecommerce.html" class="d-flex align-items-center">
			   <span class="dark-title">Enable Dark Theme</span>
			</a>

			<div class="form-check form-switch">
				<input type="checkbox" class="checkbox" id="darkSwitch">
			</div>
		</div>

		<!-- Start Go Top Area -->
		<div class="go-top">
			<i class="ri-arrow-up-s-fill"></i>
			<i class="ri-arrow-up-s-fill"></i>
		</div>
		<!-- End Go Top Area -->

        <!-- Jquery Min JS -->
        <script src="assets/js/jquery.min.js"></script> 
        <!-- Bootstrap Bundle Min JS -->
        <script src="assets/js/bootstrap.bundle.min.js"></script>
		<!-- Owl Carousel Min JS -->
		<script src="assets/js/owl.carousel.min.js"></script>
		<!-- Metismenu Min JS -->
        <script src="assets/js/metismenu.min.js"></script>
		<!-- Simplebar Min JS -->
        <script src="assets/js/simplebar.min.js"></script>
		<!-- mixitup Min JS -->
        <script src="assets/js/mixitup.min.js"></script>
		<!-- Dark Mode Switch Min JS -->
        <script src="assets/js/dark-mode-switch.min.js"></script>
		<!-- Form Validator Min JS -->
		<script src="assets/js/form-validator.min.js"></script>
		<!-- Contact JS -->
		<script src="assets/js/contact-form-script.js"></script>
		<!-- Ajaxchimp Min JS -->
		<script src="assets/js/ajaxchimp.min.js"></script>
        <!-- Custom JS -->
		<script src="assets/js/custom.js"></script>
    </body>

<!-- Mirrored from templates.envytheme.com/dashli/default/log-in.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 10 Oct 2022 15:13:45 GMT -->
</html>