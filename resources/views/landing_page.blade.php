<!doctype html>
<html lang="zxx">
    
<!-- Mirrored from templates.envytheme.com/dashli/default/invoices.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 10 Oct 2022 15:11:29 GMT -->
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
    <link rel="icon" type="image/png" href="{{asset('assets/images/favicon.png')}}">
    <style>
        @media print {
            #startam {
                display:none;
            }
            #dontShow {
                display:none;
            }
            #hideam {
                display:none;
                width: 100%;
            }
            #footers {
                display:none;
            }
            #footerds {
                display:none;
            }
        }
        </style>
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

		<!-- Start Sidebar Area -->
        <div class="side-menu-area" id="footerds" >
            <div class="side-menu-logo bg-linear" >
                <a href="ecommerce.html" class="navbar-brand d-flex align-items-center">
                    <img src="assets/images/logo.png" alt="image">
                    <span>Promix</span>
                </a>

                <div class="burger-menu d-none d-lg-block">
                    <span class="top-bar"></span>
                    <span class="middle-bar"></span>
                    <span class="bottom-bar"></span>
                </div>

                <div class="responsive-burger-menu d-block d-lg-none">
                    <span class="top-bar"></span>
                    <span class="middle-bar"></span>
                    <span class="bottom-bar"></span>
                </div>
            </div>
           
            <nav class="sidebar-nav" data-simplebar id="dontShow">
                <ul id="sidebar-menu" class="sidebar-menu">
                    <li class="nav-item-title">MENU</li>
                    <li>
                        <a href="#" >
                            <i class="ri-dashboard-line"></i>
                            <span class="menu-title">Dashboards</span>
                        </a>
                       

                <div class="dark-bar">
                    <a href="ecommerce.html" class="d-flex align-items-center">
                       <span class="dark-title">Enable Dark Theme</span>
                    </a>
    
                    <div class="form-check form-switch">
                        <input type="checkbox" class="checkbox" id="darkSwitch">
                    </div>
                </div>
            </nav>
        </div>
		<!-- End Sidebar Area -->

		<!-- Start Main Content Area -->
        <div class="main-content d-flex flex-column">

            <div class="container-fluid">
                <nav class="navbar main-top-navbar navbar-expand-lg navbar-light bg-light">
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <div class="responsive-burger-menu d-block d-lg-none">
                            <span class="top-bar"></span>
                            <span class="middle-bar"></span>
                            <span class="bottom-bar"></span>
                        </div>

                      

                        <div class="option-item for-mobile-devices d-block d-lg-none">
                            <i class="search-btn ri-search-line"></i>
                            <i class="close-btn ri-close-line"></i>
                            
                            <div class="search-overlay search-popup">
                                <div class='search-box'>
                                    <form class="search-form">
                                        <input class="search-input" name="search" placeholder="Search" type="text">

                                        <button class="search-button" type="submit">
                                            <i class="ri-search-line"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <ul class="navbar-nav ms-auto mb-lg-0">
                            

                           

                         

                          

                            <li class="nav-item dropdown profile-nav-item">
                                <a class="nav-link dropdown-toggle avatar" href="#" id="navbarDropdown-4" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="assets/images/avatar.png" alt="Images" >
                                    <h3>{{Auth::User()->name}}</h3>
                                    <span>{{Auth::User()->user_type}}</span>
                                </a>

                                <div class="dropdown-menu">
                                    <div class="dropdown-header d-flex flex-column align-items-center">
                                        <div class="figure mb-3">
                                            <img src="assets/images/avatar.png" class="rounded-circle" alt="image">
                                        </div>
    
                                        <div class="info text-center">
                                            <span class="name">{{Auth::User()->name}}</span>
                                            <p class="mb-3 email">
                                                <a href="https://templates.envytheme.com/cdn-cgi/l/email-protection#046c6168686b4461696168686d736570776b6a2a676b69"><span class="__cf_email__" data-cfemail="abc3cec7c7c4ebcec6cec7c7c2dccadfd8c4c585c8c4c6">[email&#160;protected]<br> {{Auth::User()->email}}</span></a>
                                            </p>
                                        </div>
                                    </div>
    
                                    <div class="dropdown-body">
                                        <ul class="profile-nav p-0 pt-3">
                                            <li class="nav-item">
                                                <a href="profile.html" class="nav-link">
                                                    <i class="ri-user-line"></i> 
                                                    <span>Profile</span>
                                                </a>
                                            </li>
    
                                            <li class="nav-item">
                                                <a href="inbox.html" class="nav-link">
                                                    <i class="ri-mail-send-line"></i> 
                                                    <span>My Inbox</span>
                                                </a>
                                            </li>
    
                                            <li class="nav-item">
                                                <a href="edit-profile.html" class="nav-link">
                                                    <i class="ri-edit-box-line"></i> 
                                                    <span>Edit Profile</span>
                                                </a>
                                            </li>
    
                                            <li class="nav-item">
                                                <a href="settings.html" class="nav-link">
                                                    <i class="ri-settings-5-line"></i> 
                                                    <span>Settings</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
    
                                    <div class="dropdown-footer">
                                        <ul class="profile-nav">
                                            <li class="nav-item">
                                                <a href="/logout" class="nav-link">
                                                    <i class="ri-login-circle-line"></i> 
                                                    <span>Logout</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </li>

                            <!--
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <i class="ri-settings-5-line"></i>
                                </a>
                            </li>
                            -->
                        </ul>
                    </div>
                </nav>
            </div>

            <div class="page-title-area">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="col-lg-6 col-sm-6">
                            <div class="page-title">
                                <h3>Deduction Slip</h3>
                            </div>
                        </div>

                        <div class="col-lg-6 col-sm-6">
                            <ul class="page-title-list">
                                {{-- <li>Pages</li> --}}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
           
            <div class="invoice-area" >
                <div class="invoice-header mb-24 d-flex justify-content-between" id="hideam" style="width: 100%; margin:auto;">
                    <div class="invoice-left-text">
                 
                        {{-- <h2> {{$user->name}} Cooperative</h2> --}}
                        <h6>Name  <span style="padding-left: 20px">{{Auth::User()->name}}</span></h6>
                        <h6>Date <span style="padding-left:25px ">{{Auth::User()->created_at}}</span> </h6>
                    </div>

                    <div class="invoice-right-text"  >
                        {{-- <h3 class="mb-0 text-uppercase">Pay Slip</h3> --}}
                    </div>
                </div>

                <div class="col-md-6 col-sm-12">

                    <form method='get' action='{{route('home')}}' class='row bg-white' >

                        <div class="col-sm-6 col-md-10"  style="margin-top: 10px;">
                            <div class="form-group form-focus select-focus">
                                <label class="focus-label">Filter Savings and Loans by Month and Year</label>
                                <div class="cal-icon">
                                    {{-- <input type="text" name="class" value="{{$class->id}}" hidden> --}}
                                    <select class='form-control' name="months">
                                        <option value=''>Filter Savings and Loans by Month and Year</option>
                                        @foreach($months as $key => $month)
                                            <option value="{{ $month }}" {{$month ==  $monthStart ?' selected': ''  }}>{{ $month }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-2">
                            <div class="form-group form-focus select-focus">
                                <label class="focus-label"> </label>
                                <div class="cal-icon">
                                    <input type='submit' value='continue' class='fw-btn-fill btn-gradient-yellow mt-4 default-btn '>
                                </div>
                            </div>

                        </div>

                    </form>
                </div>
            </div>

            
      

            <div class="flex-grow-1"></div>

            <div class="footer-area">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <div class="copy-right">
                                {{-- <p>Copyright @2022 Dashli. Designed By <a href="https://envytheme.com/" target="_blank">EnvyTheme</a></p> --}}
                            </div>
                        </div>

                        
                    </div>
                </div>
            </div>
        </div>
		<!-- End Main Content Area -->

		<!-- Start Go Top Area -->
		<div class="go-top">
			<i class="ri-arrow-up-s-fill"></i>
			<i class="ri-arrow-up-s-fill"></i>
		</div>
		<!-- End Go Top Area -->

        <!-- Jquery Min JS -->
        <script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script src="assets/js/jquery.min.js"></script> 
        <!-- Bootstrap Bundle Min JS -->
        <script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
		<!-- Owl Carousel Min JS -->
		<script src="{{asset('assets/js/owl.carousel.min.js')}}"></script>
		<!-- Metismenu Min JS -->
        <script src="{{asset('assets/js/metismenu.min.js')}}"></script>
		<!-- Simplebar Min JS -->
        <script src="{{asset('assets/js/simplebar.min.js')}}"></script>
		<!-- mixitup Min JS -->
        <script src="{{asset('assets/js/mixitup.min.js')}}"></script>
		<!-- Dark Mode Switch Min JS -->
        <script src="{{asset('assets/js/dark-mode-switch.min.js')}}"></script>
		<!-- Form Validator Min JS -->
		<script src="{{asset('assets/js/form-validator.min.js')}}"></script>
		<!-- Contact JS -->
		<script src="{{asset('assets/js/contact-form-script.js')}}"></script>
		<!-- Ajaxchimp Min JS -->
		<script src="{{asset('assets/js/ajaxchimp.min.js')}}"></script>
        <!-- Custom JS -->
		<script src="{{asset('assets/js/custom.js')}}"></script>
    </body>

</html>