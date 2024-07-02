<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
 <!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge"><![endif]-->
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Page Title -->
	<title><?php echo e(config('app.name')); ?></title>
<!-- /Page title -->

<!-- Seo Tags -->
	<meta name="description" content="Process payroll in minutes and not days! Automate payslips sending and generate your statutory deductions and payments automatically." />
	<meta name="keywords" content="Your meta keywords, here"/>
	<meta name="robots" content="index, follow"> 
<!-- /Seo Tags -->

<!-- Favicon and Touch Icons
========================================================= -->
	<link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
	<link rel="icon" href="img/favicon.ico" type="image/x-icon">
<!-- /Favicon
========================================================= -->

<!-- >> CSS
============================================================================== -->
	<!-- Bootstrap styles -->
	<link href="<?php echo e(asset('landing_assets/vendor/bootstrap/css/bootstrap.min.css')); ?>" rel="stylesheet">
	<!-- /Bootstrap Styles -->
	<!-- Google Web Fonts -->	
	<link href='https://fonts.googleapis.com/css?family=PT+Sans' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Titillium+Web:400,700,300' rel='stylesheet' type='text/css'>
	<!-- /google web fonts -->
	<!-- owl carousel -->
	<link href="<?php echo e(asset('landing_assets/vendor/owl.carousel/owl-carousel/owl.carousel.css')); ?>" rel="stylesheet">
	<link href="<?php echo e(asset('landing_assets/vendor/owl.carousel/owl-carousel/owl.theme.css')); ?>" rel="stylesheet">
	<!-- /owl carousel -->
	<!-- fancybox.css -->
	<link href="<?php echo e(asset('landing_assets/vendor/fancybox/jquery.fancybox.css')); ?>" rel="stylesheet">
	<!-- /fancybox.css -->
	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?php echo e(asset('landing_assets/vendor/font-awesome/css/font-awesome.min.css')); ?>">
	<!-- /Font Awesome -->
	<!-- Main Styles -->
	<link href="<?php echo e(asset('landing_assets/css/styles.css')); ?>" rel="stylesheet">
	<!-- /Main Styles -->
<!-- >> /CSS
============================================================================== -->
</head>

<body>

<!-- Page Loader
========================================================= -->
<div class="loader-container" id="page-loader"> 
  <div class="loading-wrapper loading-wrapper-hide">
  	<div class="loader-animation" id="loader-animation">
  		<svg class="svg-loader" width=100 height=100>
		  <circle cx=50 cy=50 r=25 />
		</svg>
  	</div>    
    <!-- Edit With Your Name -->
    <div class="loader-name" id="loader-name">
      <img src="<?php echo e(asset('landing_assets/img/payrollghana.png')); ?>" alt="">
    </div>
    <!-- /Edit With Your Name -->
  </div>   
</div>
<!-- /End of Page loader
========================================================= -->

<!-- Header
================================================== -->
<header id="header" class="">
	<nav class="navbar">
        <div class="container">
            <!-- Navbar Header -->
            <div class="navbar-header">
            	<!-- Collapse Button -->
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-main-collapse">
                    <i class="fa fa-bars"></i>
                </button>
                <!-- /Collapse Button -->
                <!-- logo -->
                <div class="header-logo" id="header-logo">
                	<a class="navbar-brand back-to-top" href="#main-carousel">
	                   <img src="<?php echo e(asset('landing_assets/img/payrollghana.png')); ?>" alt="">
	                </a>
                </div>                
                <!-- /logo -->
            </div>
            <!-- / Navbar Header -->

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-main-collapse">
            	<!-- Secondary menu -->
            	<ul class="nav navbar-nav navbar-right secondary-menu">
		          <li><a href="<?php echo e(url('auth/login')); ?>"><i class="fa fa-sign-in"></i> Login</a></li>
		          <li><a href="<?php echo e(url('auth/signup')); ?>" class="btn btn-join">SIGN UP</a></li>
		        </ul>
		        <!-- /secondary menu -->
		        <!-- Main menu -->
                <ul class="nav navbar-nav navbar-right hd-list-menu"> 
			        <li><a href="#section-features">Features </a></li>
			        <li><a href="#section-testimonials">Reviews</a></li>  
			        <li><a href="#section-prices">Plans</a></li>	                
			        <li><a href="#section-contact">Contact</a></li>
                </ul>         
                <!-- Main menu -->       
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
</header>
<!-- /Header
================================================== -->


<div class="page-wrapper">
	
	<div id="body-content">

		<!-- Back to Top Button -->
		<div id="back-to-top" class="back-to-top back-to-top-hide"><i class="fa fa-angle-up"></i></div>
		<!-- /Back to Top Button -->

		<!-- SECTION: Intro
		================================================== -->
		<div class="owl-carousel main-carousel" id="main-carousel">

			<!-- slide -->
			<div class="main-intro main-slide1" style="">

				<div class="container">	
					<div class="intro-content-wrapper viewport">
						<!-- INTRO CONTENT -->
						<!-- Adjust the margin-top in style atribute according to content to keep always centered vertically-->
						<div class="intro-content intro-content-slide1">
							<!-- row -->
							<div class="row">
								<!-- col -->
								<div class="col-sm-12">
									<!-- Slide Title-->
									<div class="ic-title-wrapper">
										<h1 class="ic-title">Simplified Payroll</h1>
									</div>
									<!-- /Slide Title -->								
									<!-- Slide Text-->
									<div class="ic-text">
										<p>Automate your payroll and ditch your spreadsheets!</p>
									</div>
									<!-- /Slide Text -->
									<form class="form" id="intro-register-form" hidden>
									
										<div class="ic-register">						
											<!-- row -->
											<div class="row">
												<!-- col -->
												<div class="col-sm-3 ic-register-col">
													<!-- Interactive Input -->
													<span class="input-wrapper">
														<input type="text" class="form-control input__field" name="if-name" id="if-name" required/>
														<label class="input__label" for="if-name">
															<span class="input__label-content"><i class="fa fa-user"></i> Your Name</span>
														</label>
													</span>
													<!-- /Interactive Input -->
												</div>
												<!-- /col -->
												<!-- col -->
												<div class="col-sm-3 ic-register-col">				<!-- Interactive Input -->
													<span class="input-wrapper">
														<input type="email" class="form-control input__field" name="if-email" id="if-email" required/>
														<label class="input__label" for="if-name">
															<span class="input__label-content"><i class="fa fa-envelope"></i> Your Email</span>
														</label>
													</span>
													<!-- /Interactive Input -->	
												</div>
												<!-- /col -->
												<!-- col -->
												<div class="col-sm-3 ic-register-col">
													<!-- Interactive Input -->
													<span class="input-wrapper">
														<input type="tel" class="form-control input__field" name="if-phone" id="if-phone" required/>
														<label class="input__label" for="if-name">
															<span class="input__label-content"><i class="fa fa-phone"></i> Your Phone</span>
														</label>
													</span>
													<!-- /Interactive Input -->	
												</div>
												<!-- /col -->
												<!-- col -->
												<div class="col-sm-3 ic-register-col">
													<button type="submit" class="btn btn-register"><i class="fa fa-paper-plane"></i> Register Now</button>
												</div>
												<!-- /col -->
											</div>
											<!-- /row -->
											<input type="hidden" value="A New Register!" name="subject" id="if-subject">								
										</div>	
									</form>	
									<!-- /Register Form -->							
								</div>
								<!-- /col -->
							</div>
							<!-- /row -->						
															
						</div>	
						<!-- /INTRO CONTENT -->					
					</div>							
				</div>
			</div>
			<!-- /slide -->

			<!-- slide -->
			<div class="main-intro" style="background-image: url('landing_assets/img/bg4.jpg');">
				<div class="container">						
					<div class="intro-content-wrapper viewport">
						<!-- Main Title -->
						<!-- Adjust the margin-top in css according to content to keep always centered vertically-->
						<div class="intro-content countdown-wrapper intro-content-slide2">
							<img src="landing_assets/img/ico-rocket.png" alt="">
							<h2 class="ic-title countdown-title">We Will Launch In</h2>
							<!-- row -->
							<div  class="row">
								<!-- col -->
								<div class="col-sm-10 col-sm-offset-1">
									<!-- countDown -->
									<div class="row" id="countdown"></div>
									<!-- /countDown -->
									<!-- Buttons -->
									<div class="countdown-buttons text-center">
										<a href="https://www.youtube.com/embed/dorZ3vag5PI?autoplay=1" class="btn btn-default box-iframe"><i class="fa fa-play"></i>&nbsp; Watch Video</a>
										<a href="#" class="btn btn-default"><i class="fa fa-envelope"></i>&nbsp;  Subscribe</a>
									</div>
									<!-- /Buttons -->
								</div>
								<!-- /col -->
							</div>	
							<!-- /row -->								
							
						</div>
						<!-- /Main Title -->
					</div>			
				</div>
			</div>
			<!-- /slide -->
			
		</div>		
		<!-- /SECTION: Intro
		================================================== -->

		
		<!-- SECTION: Features
		================================================== -->
		<div class="section-features section-bg" id="section-features">
			<div class="container">				

				<!-- Intro Features -->
				<div class="intro-features-wrapper">
					<!-- row -->
					<div class="row">				
						<!-- item -->
						<div class="col-sm-3 intro-feature-item">
							<div class="intro-feature-icon">
                                <img class="card-img-top" src="<?php echo e(asset('landing/images/inv.jpg')); ?>" style="height:200px" alt="Card image">
							</div>
							<h2 class="intro-feature-title">Process Quickly and Send Statements Instantly!</h2>
							<div class="intro-feature-description">
								<p>Process payroll in minutes and not days! Automate payslips sending and generate your statutory deductions and payments automatically.</p>								
							</div>
						</div>
						<!-- /item -->
						<!-- item -->
						<div class="col-sm-3 intro-feature-item">
							<div class="intro-feature-icon">
                                <img class="card-img-top" src="<?php echo e(asset('landing/images/paid.jpg')); ?>" style="height:200px" alt="Card image">
							</div>
							<h2 class="intro-feature-title">Get employees paid faster .</h2>
							<div class="intro-feature-description">
								<p>Let our software do the work for you whiles you automate your employees’ wages and salaries to get them paid on time and real-time.</p>
							</div>
						</div>
						<!-- /item -->
						<!-- item -->
						<div class="col-sm-3 intro-feature-item">
							<div class="intro-feature-icon">
                                <img class="card-img-top" src="<?php echo e(asset('landing/images/rec.jpg')); ?>" style="height:200px" alt="Card image">
							</div>
							<h2 class="intro-feature-title">Automatically generate reports.</h2>
							<div class="intro-feature-description">
								<p>Print your payroll and statutory reports instantly. You don't have to move a muscle our technology does everything for you.</p>
							</div>
						</div>
						<!-- /item -->
                        <!-- item -->
						<div class="col-sm-3 intro-feature-item">
							<div class="intro-feature-icon">
								<img class="card-img-top" src="<?php echo e(asset('landing/images/save.jpg')); ?>" style="height:200px" alt="Card image">
							</div>
							<h2 class="intro-feature-title">Save more time by streamlining and organizing your work.</h2>
							<div class="intro-feature-description">
								<p>Let us do the hard work for you and use your time profitably in other areas! We got you covered!</p>
							</div>
						</div>
						<!-- /item -->
					</div>
					<!-- /row -->
				</div>
				<!-- /Intro Features -->

				<!-- Tabs -->
				<div class="tabs" hidden>
					<!-- Tab buttons -->
					<ul class="tabs-buttons">
				        <li class="active"><a href="#tab1">Mobile Version</a></li>
				        <li><a href="#tab2">Desktop Version</a></li>
				        <li><a href="#tab3">Tablet Version</a></li>
				    </ul>
				    <!-- /Tab buttons -->
				    <!-- Tabs Content -->
				    <div class="tabs-content">
				    	<!-- Tab -->
				    	<div class="tab" id="tab1">
				    		<!-- Feature Item -->
							<div class="feature-item">
								<div class="row">									
									<div class="col-sm-6 col-sm-push-6">	
										<h3 class="feature-item-title">Awesome on all devices<br/></h3>
										<p>Along with HTML5, CSS3, and svg icons, Startuper also ensures that things look clear in all devices.</p>	
										<!-- row -->
										<div class="row">
											<!-- col -->
											<div class="col-sm-6 feature-item-icons-wrapper">
			                                    <i class="fa fa-rocket feature-item-icon"></i>
			                                    <h4 class="feature-item-icon-title">Best Startup Ever</h4>
			                                    <p>Quisque id leo eu neque commodo luctus. Duis consequat, nunc a imperdiet</p>
											</div>
											<!-- /col -->
											<!-- col -->
											<div class="col-sm-6 feature-item-icons-wrapper">
			                                    <i class="fa fa-microphone feature-item-icon"></i>
			                                    <h4 class="feature-item-icon-title">We Can Hear You</h4>
			                                    <p>Quisque id leo eu neque commodo luctus. Duis consequat, nunc a imperdiet</p>
											</div>
											<!-- /col -->
										</div>
										<!-- /row -->				
									</div>
									<div class="col-sm-6 col-sm-pull-6">
										<!-- Mock-up Image -->
										<div class="feature-item-image">
											<img src="landing_assets/img/mobile-mockup.png" alt="">
										</div>
										<!-- /Mock-up Image -->
									</div>
								</div>
							</div>	
							<!-- /Feature Item -->
				    	</div>
				    	<!-- /Tab -->
				    	<!-- Tab -->
				    	<div class="tab" id="tab2">
				    		<!-- Feature Item -->
							<div class="feature-item">
								<div class="row">									
									<div class="col-sm-6 col-sm-push-6">	
										<h3 class="feature-item-title">Awesome on all devices<br/></h3>
										<p>Along with HTML5, CSS3, and svg icons, Startuper also ensures that things look clear in all devices.</p>	
										<!-- row -->
										<div class="row">
											<!-- col -->
											<div class="col-sm-6 feature-item-icons-wrapper">
			                                    <i class="fa fa-rocket feature-item-icon"></i>
			                                    <h4 class="feature-item-icon-title">Best Startup Ever</h4>
			                                    <p>Quisque id leo eu neque commodo luctus. Duis consequat, nunc a imperdiet</p>
											</div>
											<!-- /col -->
											<!-- col -->
											<div class="col-sm-6 feature-item-icons-wrapper">
			                                    <i class="fa fa-microphone feature-item-icon"></i>
			                                    <h4 class="feature-item-icon-title">We Can Hear You</h4>
			                                    <p>Quisque id leo eu neque commodo luctus. Duis consequat, nunc a imperdiet</p>
											</div>
											<!-- /col -->
										</div>
										<!-- /row -->				
									</div>
									<div class="col-sm-6 col-sm-pull-6">
										<!-- Mock-up Image -->
										<div class="feature-item-image">
											<img src="landing_assets/img/computer-mockup.png" alt="">
										</div>
										<!-- /Mock-up Image -->
									</div>
								</div>
							</div>	
							<!-- /Feature Item -->
				    	</div>
				    	<!-- /Tab -->
				    	<!-- Tab -->
				    	<div class="tab" id="tab3">
				    		<!-- Feature Item -->
							<div class="feature-item">
								<div class="row">									
									<div class="col-sm-6 col-sm-push-6">	
										<h3 class="feature-item-title">Awesome on all devices<br/></h3>
										<p>Along with HTML5, CSS3, and svg icons, Startuper also ensures that things look clear in all devices.</p>
										<!-- row -->
										<div class="row">
											<!-- col -->
											<div class="col-sm-6 feature-item-icons-wrapper">
			                                    <i class="fa fa-rocket feature-item-icon"></i>
			                                    <h4 class="feature-item-icon-title">Best Startup Ever</h4>
			                                    <p>Quisque id leo eu neque commodo luctus. Duis consequat, nunc a imperdiet</p>
											</div>
											<!-- /col -->
											<!-- col -->
											<div class="col-sm-6 feature-item-icons-wrapper">
			                                    <i class="fa fa-microphone feature-item-icon"></i>
			                                    <h4 class="feature-item-icon-title">We Can Hear You</h4>
			                                    <p>Quisque id leo eu neque commodo luctus. Duis consequat, nunc a imperdiet</p>
											</div>
											<!-- /col -->
										</div>
										<!-- /row -->					
									</div>
									<div class="col-sm-6 col-sm-pull-6">
										<!-- Mock-up Image -->
										<div class="feature-item-image">
											<img src="landing_assets/img/tablet-mockup.png" alt="">
										</div>
										<!-- /Mock-up Image -->
									</div>
								</div>
							</div>	
							<!-- /Feature Item -->
				    	</div>
				    	<!-- /Tab -->
				    </div>
					<!-- / Tabs Content -->
				</div>
				<!-- Tabs -->
			</div>
		</div>
		<!-- /SECTION: Features
		================================================== -->

		<!-- SECTION: Show Me Numbers
		================================================== -->
		<div class="section-show-me-numbers inverted-section" id="section-show-me-numbers">
			<div class="container-fluid">
				<div class="show-me-numbers row">
					<!-- Counter -->
					<div class="show-numbers-col">
						<div class="show-numbers-ico">
							<i class="fa fa-check"></i>
						</div>
						<h3 class="main-title3" id="counter-item-title1"><?php echo e(number_format(8000)); ?></h3>
						<p>Generated Payslips</p>
					</div>
					<!-- /Counter -->
					<!-- Counter -->
					<div class="show-numbers-col">	
						<div class="show-numbers-ico">
							<i class="fa fa-users"></i>
						</div>					
						<h3 class="main-title3" id="counter-item-title2">50</h3>
						<p>Companies</p>
					</div>
					<!-- /Counter -->
					<!-- Counter -->
					<div class="show-numbers-col">
						<div class="show-numbers-ico">
							<i class="fa fa-thumbs-up"></i>
						</div>
						<h3 class="main-title3" id="counter-item-title3">40</h3>
						<p>Happy Clients</p>
					</div>
					<!-- /Counter -->
					<!-- Counter -->
					<div class="show-numbers-col">
						<div class="show-numbers-ico">
							<i class="fa fa-trophy"></i>
						</div>
						<h3 class="main-title3" id="counter-item-title4"><?php echo e(number_format(4000)); ?></h3>
						<p>Employees</p>
					</div>
					<!-- /Counter -->
				</div>
			</div>
		</div>			
		<!-- SECTION: /Show Me Numbers
		================================================== -->	

		<!-- SECTION: Testimonials
		================================================== -->
		<div class="section-testimonials section-padding section-bg" id="section-testimonials">
			<div class="container">		
				<!-- Section title -->
				<div class="section-title-wrapper">
					<h2 class="title-section">Our <strong>Reviews</strong></h2>
					<p class="title-section2 title-section-border">Quality proven by the most important people for us: <strong>our customers</strong></p>
				</div>
				<!-- /Section title -->

				<!-- Testimonial Slides -->
				<div class="testimonial-slides" id="testimonial-carousel">
					<!-- item -->
					<div class="testimonial-item">
						<!-- Testimonial Content -->
						<div class="testimonial-content">
							<p>"Efficient and reliable payroll system. Simplified our payroll process and reduced errors."</p>
						</div>						
						<!-- /Testimonial Content -->	
						<!-- Testimonial Author -->
						<div class="testimonial-credits">
							<!-- picture -->
							<div class="testimonial-picture">
								<img src="<?php echo e(asset('landing_assets/img/testimonials/team2.jpg')); ?>" alt=""/>
							</div>							
							<!-- /picture -->
							<p class="testimonial-author">Melissa Alvarez</p>
							<p class="testimonial-firm">Trexus Co.</p>
						</div>
						<!-- /Testimonial Author -->								
					</div>
					<!-- /item -->
					<!-- item -->
					<div class="testimonial-item">
						<!-- Testimonial Content -->
						<div class="testimonial-content">
							<p>"User-friendly interface and accurate calculations. A game-changer for our company's payroll management."</p>
						</div>						
						<!-- /Testimonial Content -->	
						<!-- Testimonial Author -->
						<div class="testimonial-credits">
							<!-- picture -->
							<div class="testimonial-picture">
								<img src="<?php echo e(asset('landing_assets/img/testimonials/team1.jpg')); ?>" alt=""/>
							</div>							
							<!-- /picture -->
							<p class="testimonial-author">John Rex</p>
							<p class="testimonial-firm">Brainet Co.</p>
						</div>
						<!-- /Testimonial Author -->								
					</div>
					<!-- /item -->
					<!-- item -->
					<div class="testimonial-item">
						<!-- Testimonial Content -->
						<div class="testimonial-content">
							<p>"Streamlined payroll with great features. Saves time and ensures compliance effortlessly."</p>
						</div>						
						<!-- /Testimonial Content -->	
						<!-- Testimonial Author -->
						<div class="testimonial-credits">
							<!-- picture -->
							<div class="testimonial-picture">
								<img src="<?php echo e(asset('landing_assets/img/testimonials/team3.jpg')); ?>" alt=""/>
							</div>							
							<!-- /picture -->
							<p class="testimonial-author">Jhonathan Smith</p>
							<p class="testimonial-firm">RedWings Co.</p>
						</div>
						<!-- /Testimonial Author -->								
					</div>
					<!-- /item -->
				</div>
				<!-- Testimonial Slides -->

			</div>
		</div>
		<!-- /SECTION: Testimonials
		================================================== -->	


		<!-- SECTION: Clients
		================================================== -->
		<div class="section-clients inverted-section-neutral" id="section-clients" hidden>
			<div class="container">
				
				<!-- Clients Carousel List -->
				<div class="clients-carousel owl-carousel" id="clients-carousel">
					<!-- item -->
					<div class="clients-carousel-item">
						<img src="<?php echo e(asset('landing_assets/img/clients/1.png')); ?>" alt="">
					</div>
					<!-- /item -->
					<!-- item -->
					<div class="clients-carousel-item">
						<img src="<?php echo e(asset('landing_assets/img/clients/2.png')); ?>" alt="">
					</div>
					<!-- /item -->
					<!-- item -->
					<div class="clients-carousel-item">
						<img src="<?php echo e(asset('landing_assets/img/clients/3.png')); ?>" alt="">
					</div>
					<!-- /item -->
					<!-- item -->
					<div class="clients-carousel-item">
						<img src="<?php echo e(asset('landing_assets/img/clients/4.png')); ?>" alt="">
					</div>
					<!-- /item -->
					<!-- item -->
					<div class="clients-carousel-item">
						<img src="<?php echo e(asset('landing_assets/img/clients/5.png')); ?>" alt="">
					</div>
					<!-- /item -->
					<!-- item -->
					<div class="clients-carousel-item">
						<img src="<?php echo e(asset('landing_assets/img/clients/6.png')); ?>" alt="">
					</div>
					<!-- /item -->
					<!-- item -->
					<div class="clients-carousel-item">
						<img src="<?php echo e(asset('landing_assets/img/clients/7.png')); ?>" alt="">
					</div>
					<!-- /item -->
					<!-- item -->
					<div class="clients-carousel-item">
						<img src="<?php echo e(asset('landing_assets/img/clients/8.png')); ?>" alt="">
					</div>
					<!-- /item -->
				</div>
				<!-- / Clients Carousel List -->
			</div>				
		</div>
		<!-- /SECTION: Clients
		================================================== -->

		<!-- Section: Image background-->
		<div class="section section-padding contrast-with-image text-center" style="background-image: url('landing_assets/img/bg3.jpg')">
			<div class="container">
				<img src="<?php echo e(asset('landing_assets/img/ico-stars.png')); ?>" alt="">
				<h2 class="title1">Try Simplified Payroll Today!</h2>
				<p>Automate your payroll and ditch your spreadsheets!</p><br/><br/>
				<a href="<?php echo e(url('auth/signup')); ?>" class="btn btn-default"><i class="fa fa-paper-plane"></i> Get Started</a>
			</div>
		</div>
		<!-- / Section: Image Background-->

		<!-- SECTION: Prices
		================================================== -->
		<div class="section-prices section-padding section-bg" id="section-prices">
			<div class="container">

				<!-- Section title -->
				<div class="section-title-wrapper">
					<h2 class="title-section">Awesome <strong>Plans</strong></h2>
					<p class="title-section2 title-section-border">Free signup. 14 days free trial. <strong>No credit card required.</strong></p>
				</div>
				<!-- /Section title -->

				<!-- Row -->
			<div class="row">

				<!-- col -->
                <?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<div class="col-sm-3">
					<!-- Plan Item-->
					<div class="plan-item">
						<!-- Plan Name -->
		            	<div class="plan-item-head">
		                	<h2 class="plan-item-title"><?php echo e($key->name); ?></h2>			              
		            	</div>  
						<!-- Plan Name -->

						<!-- Plan Features List -->
			            <ul class="plan-item-list">
							<?php
							$moduleString = $key->module;
							$modules = explode(',', $moduleString);

							// Array of items that you want to check against
							$desiredModules = array("hr","payroll","attendance","contracts","leaves","projects","tasks","bulky_sms","bulky_email","expenses","trainings");
							?>

							
							<?php $__currentLoopData = $desiredModules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $desiredModule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<?php
								$formattedModule = str_replace('_', ' ', $desiredModule);
								$formattedModule = ucfirst($formattedModule);
								
								// Check if $desiredModule exists in the $modules array
								$isExistingModule = in_array($desiredModule, $modules);
								?>
								
									<?php if($isExistingModule): ?>
									<li>
										<i class="fa fa-check"></i> <?php echo e($formattedModule); ?>

									</li>
									<?php else: ?>
									<li class="disabled">
										<i class="fa fa-times"></i> <?php echo e($formattedModule); ?>

									</li>
									<?php endif; ?>
								</li>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						
							
			            </ul>
						<!-- Plan Features List -->

						<!-- Plan Item Price -->
			            <div class="plan-item-price">
			            	<h3 class="plan-item-price-title"><span class="plan-item-price-symbol">GHS </span><?php echo e(number_format($key->price)); ?></h3>
			                <h4 class="plan-item-price-title2">No. of Staff - <?php echo e($key->staff_no); ?></h4>
			            </div>
			            <!-- /Plan Item Price -->
                        <a href="<?php echo e(url('auth/signup')); ?>" class="btn btn-default plan-item-btn">Sign Up</a>
			        </div>
					<!-- /Plan Item -->
				</div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				<!-- /col -->

			</div>
			<!-- /Row -->

				
			</div>				
		</div>
		<!-- /SECTION: Prices
		================================================== -->

		<!-- SECTION: Team
		================================================== -->
		<div class="section-team inverted-section2 section-padding" id="section-team" hidden>
			<div class="container">
				<!-- Section title -->
				<div class="section-title-wrapper">
					<h2 class="title-section">Our <strong>Team</strong></h2>
					<p class="title-section2 title-section-border">The people who created this <strong>awesome product</strong></p>
				</div>
				<!-- /Section title -->
				<div class="owl-carousel" id="about-team">
					<!-- item -->
					<div class="team-item">
						<!-- team-member wrapper-->
						<div class="team-item-wrapper">
							<!-- team-member pic -->
							<div class="team-member-picture-wrapper">
								<div class="team-item-picture">
									<img src="landing_assets/img/team1.jpg" alt=""/>
								</div>
								<div class="team-member-find">
									<div class="team-member-find-overlay">
										<!-- overlay content -->
										<div class="team-member-find-content">
											<a href="#" class="block-link"><span class="fa fa-facebook"></span></a>
											<a href="#" class="block-link"><span class="fa fa-twitter"></span></a>
											<a href="#" class="block-link"><span class="fa fa-envelope"></span></a>
											<a href="#" class="block-link"><span class="fa fa-phone"></span></a>
										</div>									
										<!-- /overlay content -->
									</div>								
								</div>
							</div>					
							<!-- /team-member pic -->
							<!-- team-member Infos -->
							<div class="team-item-content">
								<h3 class="team-item-title">John Rex</h3>
								<p class="team-item-subtitle">Founder & CEO </p>								
							</div>
							<!-- team-member Infos -->
						</div>
						<!-- /team-member wrapper-->
					</div>
					<!-- /item -->
					<!-- item -->
					<div class="team-item">
						<!-- team-member wrapper-->
						<div class="team-item-wrapper">
							<!-- team-member pic -->
							<div class="team-member-picture-wrapper">
								<div class="team-item-picture">
									<img src="landing_assets/img/team2.jpg" alt=""/>
								</div>
								<div class="team-member-find">
									<div class="team-member-find-overlay">
										<!-- overlay content -->
										<div class="team-member-find-content">
											<a href="#" class="block-link"><span class="fa fa-facebook"></span></a>
											<a href="#" class="block-link"><span class="fa fa-twitter"></span></a>
											<a href="#" class="block-link"><span class="fa fa-envelope"></span></a>
											<a href="#" class="block-link"><span class="fa fa-phone"></span></a>
										</div>									
										<!-- /overlay content -->
									</div>								
								</div>
							</div>
							
							<!-- /team-member pic -->
							<!-- team-member Infos -->
							<div class="team-item-content">
								<h3 class="team-item-title">Jessie Rex</h3>
								<p class="team-item-subtitle">CTO</p>							
							</div>
							<!-- team-member Infos -->
						</div>
						<!-- /team-member wrapper-->
					</div>
					<!-- /item -->
					<!-- item -->
					<div class="team-item">
						<!-- team-member wrapper-->
						<div class="team-item-wrapper">
							<!-- team-member pic -->
							<div class="team-member-picture-wrapper">
								<div class="team-item-picture">
									<img src="landing_assets/img/team3.jpg" alt=""/>
								</div>
								<div class="team-member-find">
									<div class="team-member-find-overlay">
										<!-- overlay content -->
										<div class="team-member-find-content">
											<a href="#" class="block-link"><span class="fa fa-facebook"></span></a>
											<a href="#" class="block-link"><span class="fa fa-twitter"></span></a>
											<a href="#" class="block-link"><span class="fa fa-envelope"></span></a>
											<a href="#" class="block-link"><span class="fa fa-phone"></span></a>
										</div>									
										<!-- /overlay content -->
									</div>								
								</div>
							</div>
							
							<!-- /team-member pic -->
							<!-- team-member Infos -->
							<div class="team-item-content">
								<h3 class="team-item-title">James Rex</h3>
								<p class="team-item-subtitle">Lead Designer</p>								
							</div>
							<!-- team-member Infos -->
						</div>
						<!-- /team-member wrapper-->
					</div>
					<!-- /item -->
					<!-- item -->
					<div class="team-item">
						<!-- team-member wrapper-->
						<div class="team-item-wrapper">
							<!-- team-member pic -->
							<div class="team-member-picture-wrapper">
								<div class="team-item-picture">
									<img src="landing_assets/img/team4.jpg" alt=""/>
								</div>
								<div class="team-member-find">
									<div class="team-member-find-overlay">
										<!-- overlay content -->
										<div class="team-member-find-content">
											<a href="#" class="block-link"><span class="fa fa-facebook"></span></a>
											<a href="#" class="block-link"><span class="fa fa-twitter"></span></a>
											<a href="#" class="block-link"><span class="fa fa-envelope"></span></a>
											<a href="#" class="block-link"><span class="fa fa-phone"></span></a>
										</div>									
										<!-- /overlay content -->
									</div>								
								</div>
							</div>
							
							<!-- /team-member pic -->
							<!-- team-member Infos -->
							<div class="team-item-content">
								<h3 class="team-item-title">Melissa Rex</h3>
								<p class="team-item-subtitle">Developer</p>								
							</div>
							<!-- team-member Infos -->
						</div>
						<!-- /team-member wrapper-->
					</div>
					<!-- /item -->
					<!-- item -->
					<div class="team-item">
						<!-- team-member wrapper-->
						<div class="team-item-wrapper">
							<!-- team-member pic -->
							<div class="team-member-picture-wrapper">
								<div class="team-item-picture">
									<img src="landing_assets/img/team1.jpg" alt=""/>
								</div>
								<div class="team-member-find">
									<div class="team-member-find-overlay">
										<!-- overlay content -->
										<div class="team-member-find-content">
											<a href="#" class="block-link"><span class="fa fa-facebook"></span></a>
											<a href="#" class="block-link"><span class="fa fa-twitter"></span></a>
											<a href="#" class="block-link"><span class="fa fa-envelope"></span></a>
											<a href="#" class="block-link"><span class="fa fa-phone"></span></a>
										</div>									
										<!-- /overlay content -->
									</div>								
								</div>
							</div>
							
							<!-- /team-member pic -->
							<!-- team-member Infos -->
							<div class="team-item-content">
								<h3 class="team-item-title">John Rex</h3>
								<p class="team-item-subtitle">Ux Designer</p>								
							</div>
							<!-- team-member Infos -->
						</div>
						<!-- /team-member wrapper-->
					</div>
					<!-- /item -->
					<!-- item -->
					<div class="team-item">
						<!-- team-member wrapper-->
						<div class="team-item-wrapper">
							<!-- team-member pic -->
							<div class="team-member-picture-wrapper">
								<div class="team-item-picture">
									<img src="landing_assets/img/team2.jpg" alt=""/>
								</div>
								<div class="team-member-find">
									<div class="team-member-find-overlay">
										<!-- overlay content -->
										<div class="team-member-find-content">
											<a href="#" class="block-link"><span class="fa fa-facebook"></span></a>
											<a href="#" class="block-link"><span class="fa fa-twitter"></span></a>
											<a href="#" class="block-link"><span class="fa fa-envelope"></span></a>
											<a href="#" class="block-link"><span class="fa fa-phone"></span></a>
										</div>									
										<!-- /overlay content -->
									</div>								
								</div>
							</div>
							
							<!-- /team-member pic -->
							<!-- team-member Infos -->
							<div class="team-item-content">
								<h3 class="team-item-title">Jessie Rex</h3>
								<p class="team-item-subtitle">Support</p>							
							</div>
							<!-- team-member Infos -->
						</div>
						<!-- /team-member wrapper-->
					</div>
					<!-- /item -->
				</div>
			</div>
		</div>
		<!-- /SECTION: Team
		================================================== -->	

		<!-- SECTION: Testimonials
		================================================== -->
		<div class="section-subscribe section-padding section-bg" id="section-subscribe" hidden>
			<div class="container">		
				<!-- Section title -->
				<div class="section-title-wrapper">
					<h2 class="title-section">Subscribe To Our <strong>Newsletter</strong></h2>
					<p class="title-section2 title-section-border">Subscribe to get monthly products updates and <strong>exclusive offers</strong></p>
				</div>
				<!-- /Section title -->

				<div class="row">
					<div class="col-sm-6 col-sm-offset-3">
						<!-- Mailchimp Form -->
						<form id="mc-form">
					        <div class="input-group">
					            <input type="email" class="form-control" placeholder="Email Address" required="" id="mc-email" name="EMAIL">
					            <span class="input-group-btn">
					            	<button type="submit" class="btn btn-default"><i class="fa fa-envelope"></i>  Subscribe</button>
					            </span> 
					        </div>
					        <label for="mc-email" id="mc-notification"></label>
				        </form>
				        <!-- / Mailchimp Form -->
					</div>
				</div>

				
			</div>
		</div>
		<!-- /SECTION: Newletter
		================================================== -->	


		<!-- SECTION: Blog
		================================================== -->
		<div class="section-blog section-padding image-bg-section inverted-section2" id="section-blog" hidden>
			<div class="container">

				<!-- Section title -->
				<div class="section-title-wrapper">
					<h2 class="title-section">Latest <strong>News</strong></h2>
					<p class="title-section2 title-section-border">Fresh News from <strong>Startup World</strong></p>
				</div>
				<!-- /Section title -->

				<div id="blog-itens-container">
					<!-- blog-item -->
					<div class="blog-item">
						<div class="blog-item-wrapper">
							<!-- blog item thumbnail -->
							<div class="blog-item-thumb">
								<a href="single-modal.html" class=""><img src="landing_assets/img/blog1.jpg" alt=""></a>
							</div>
							<!-- /blog item thumbnail -->
							<!-- Blog item - infos -->
							<div class="blog-item-infos">
								<!-- blog-item-title -->
								<div class="blog-item-title-wrapper">
									<h2 class="blog-item-title title-border"><a href="single-modal.html" class="">How to succeed in meetings</a></h2>
								</div>
								<!-- /blog-item-title -->
								<!-- blog item - description -->
								<div class="blog-item-description">
									<p><a href="single-modal.html" class="">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus sodales varius sagittis. Proin a arcu vitae turpis congue facilisis. Quisque a lectus pretium, sagittis augue in, fringilla risus....</a></p>
								</div>
								<!-- /blog-item-description -->
								<!-- blog item - link -->
								<div class="blog-item-link">
									<a href="single-modal.html" class="btn btn-default">See More</a>
								</div>
								<!-- /blog item - link -->
							</div>
							<!-- /blog item - infos -->
						</div>
					</div>
					<!-- /blog-item -->

					<!-- blog-item -->
					<div class="blog-item">
						<div class="blog-item-wrapper">
							<!-- blog item thumbnail -->
							<div class="blog-item-thumb">
								<a href="single-modal.html" class=""><img src="landing_assets/img/blog2.jpg" alt=""></a>
							</div>
							<!-- /blog item thumbnail -->
							<!-- Blog item - infos -->
							<div class="blog-item-infos">
								<!-- blog-item-title -->
								<div class="blog-item-title-wrapper">
									<h2 class="blog-item-title title-border"><a href="single-modal.html" class="">10 tips to improve your laptop</a></h2>
								</div>
								<!-- /blog-item-title -->
								<!-- blog item - description -->
								<div class="blog-item-description">
									<p><a href="single-modal.html" class="">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus sodales varius sagittis. Proin a arcu vitae turpis congue facilisis. Quisque a lectus pretium, sagittis augue in, fringilla risus....</a></p>
								</div>
								<!-- /blog-item-description -->
								<!-- blog item - link -->
								<div class="blog-item-link">
									<a href="single-modal.html" class=" btn btn-default">See More</a>
								</div>
								<!-- /blog item - link -->
							</div>
							<!-- /blog item - infos -->
						</div>
					</div>
					<!-- /blog-item -->

					<!-- blog-item -->
					<div class="blog-item">
						<div class="blog-item-wrapper">
							<!-- blog item thumbnail -->
							<div class="blog-item-thumb">
								<a href="single-modal.html" class=""><img src="landing_assets/img/blog3.jpg" alt=""></a>
							</div>
							<!-- /blog item thumbnail -->
							<!-- Blog item - infos -->
							<div class="blog-item-infos">
								<!-- blog-item-title -->
								<div class="blog-item-title-wrapper">
									<h2 class="blog-item-title title-border"><a href="single-modal.html" class="">News of the week</a></h2>
								</div>
								<!-- /blog-item-title -->
								<!-- blog item - description -->
								<div class="blog-item-description">
									<p><a href="single-modal.html" class="">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus sodales varius sagittis. Proin a arcu vitae turpis congue facilisis. Quisque a lectus pretium, sagittis augue in, fringilla risus....</a></p>
								</div>
								<!-- /blog-item-description -->
								<!-- blog item - link -->
								<div class="blog-item-link">
									<a href="single-modal.html" class=" btn btn-default">See More</a>
								</div>
								<!-- /blog item - link -->
							</div>
							<!-- /blog item - infos -->
						</div>
					</div>
					<!-- /blog-item -->

					<!-- blog-item -->
					<div class="blog-item">
						<div class="blog-item-wrapper">
							<!-- blog item thumbnail -->
							<div class="blog-item-thumb">
								<a href="single-modal.html" class=""><img src="landing_assets/img/blog4.jpg" alt=""></a>
							</div>
							<!-- /blog item thumbnail -->
							<!-- Blog item - infos -->
							<div class="blog-item-infos">
								<!-- blog-item-title -->
								<div class="blog-item-title-wrapper">
									<h2 class="blog-item-title title-border"><a href="single-modal.html" class="">How to be a leader</a></h2>
								</div>
								<!-- /blog-item-title -->
								<!-- blog item - description -->
								<div class="blog-item-description">
									<p><a href="single-modal.html" class="">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus sodales varius sagittis. Proin a arcu vitae turpis congue facilisis. Quisque a lectus pretium, sagittis augue in, fringilla risus....</a></p>
								</div>
								<!-- /blog-item-description -->
								<!-- blog item - link -->
								<div class="blog-item-link">
									<a href="single-modal.html" class=" btn btn-default">See More</a>
								</div>
								<!-- /blog item - link -->
							</div>
							<!-- /blog item - infos -->
						</div>
					</div>
					<!-- /blog-item -->

					<!-- blog-item -->
					<div class="blog-item">
						<div class="blog-item-wrapper">
							<!-- blog item thumbnail -->
							<div class="blog-item-thumb">
								<a href="single-modal.html" class=""><img src="landing_assets/img/blog5.jpg" alt=""></a>
							</div>
							<!-- /blog item thumbnail -->
							<!-- Blog item - infos -->
							<div class="blog-item-infos">
								<!-- blog-item-title -->
								<div class="blog-item-title-wrapper">
									<h2 class="blog-item-title title-border"><a href="single-modal.html" class="">Tips to talk in public</a></h2>
								</div>
								<!-- /blog-item-title -->
								<!-- blog item - description -->
								<div class="blog-item-description">
									<p><a href="single-modal.html" class="">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus sodales varius sagittis. Proin a arcu vitae turpis congue facilisis. Quisque a lectus pretium, sagittis augue in, fringilla risus....</a></p>
								</div>
								<!-- /blog-item-description -->
								<!-- blog item - link -->
								<div class="blog-item-link">
									<a href="single-modal.html" class="btn btn-default">See More</a>
								</div>
								<!-- /blog item - link -->
							</div>
							<!-- /blog item - infos -->
						</div>
					</div>
					<!-- /blog-item -->
				</div>
			</div>
		</div>
		<!-- /SECTION: Blog
		================================================== -->		

		<!-- SECTION: Contact Infos
		================================================== -->
		<div class="section-contact-infos section-padding" id="section-contact">
			<div class="container">
				<!-- Section title -->
				<div class="section-title-wrapper">
					<h2 class="title-section">Contact <strong>Us</strong></h2>
					<p class="title-section2 title-section-border">Have any questions? Get in touch</p>
				</div>
				<!-- /Section title -->
				<!-- Contact Infos -->
				<div class="contact-infos">
					<!-- row -->
					<div class="row">
						<!-- Postal Address -->
						<div class="col-xs-6 col-sm-6 col-md-3">
							<h4>Postal Address:</h4>
							<p>P.O. Box WY 1204, Kwabenya, Accra</p>
							<p>Accra, Ghana</p>
						</div>							

						<!-- Headquarters -->
						<div class="col-xs-6 col-sm-6 col-md-3">
							<h4 class="small-title">Headquarters</h4>
							<p>No. 3 Park Avenue, Motorway Extention Dzorwulu North </p>
							<p>Accra, Ghana</p>
						</div>
							
						<!-- Phone Number -->
						<div class="col-xs-6 col-sm-6 col-md-3">
							<h4 class="small-title">Phone</h4>
							<p>Phone Number: 0241 121 861</p>
							<p>Fax Number: 0241 121 861</p>
						</div>	
							
						<!-- E-mail Address-->
						<div class="col-xs-6 col-sm-6 col-md-3 contact-data">
							<h4 class="small-title">E-mail</h4>
							<p>Support: <a href="mailto:info@jpcannassociates.com">info@jpcannassociates.com</a></p>
							<p>Sales: <a href="mailto:admin@ghpayroll.net">admin@ghpayroll.net</a></p>
						</div>
					</div>
					<!-- /row -->
				</div>
				<!-- /contact Infos -->				
			</div>
			<div class="container-fluid">
				<div class="row">
					<div class="map" id="map">			
						<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3026.6617384330816!2d-73.9992296355825!3d40.65938630000002!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c25ae9ec6e2cb3%3A0x39c56782050e447a!2s27th+St%2C+Brooklyn%2C+NY+11232%2C+USA!5e0!3m2!1spt-BR!2sbr!4v1431959746282" height="350"></iframe>
					</div>
				</div>			
			</div>
		</div>
		<!-- / SECTION: Contact Infos
		================================================== -->

		<!-- SECTION: Register
		================================================== -->
		<div class="section-register image-bg-section inverted-section2 section-padding" id="section-register" hidden>
			<div class="container">
				<!-- Section title -->
				<div class="section-title-wrapper">
					<h2 class="title-section">Register <strong>Now</strong></h2>
					<p class="title-section2 title-section-border">Limited signup only. Order today before the discount period ends.</p>
				</div>
				<!-- /Section title -->
				<div class="row row-nopr">
					<form id="register-form" method="post" class="form register-form">
						<div class="col-sm-3">
							<!-- Interactive Input -->
							<span class="input-wrapper">
								<input type="text" class="form-control input__field" name="name" id="name" required/>
								<label class="input__label" for="if-name">
									<span class="input__label-content"><i class="fa fa-user"></i> Your Name</span>
								</label>
							</span>
							<!-- /Interactive Input -->
						</div>
						<div class="col-sm-3">
							<!-- Interactive Input -->
							<span class="input-wrapper">
								<input type="email" class="form-control input__field" name="email" id="email" type="email" required/>
								<label class="input__label" for="if-name">
									<span class="input__label-content"><i class="fa fa-envelope"></i> Your Email</span>
								</label>
							</span>
							<!-- /Interactive Input -->
						</div>
						<div class="col-sm-3">
							<!-- Interactive Input -->
							<span class="input-wrapper">
								<input type="tel" class="form-control input__field" name="telephone" id="Telephone" required/>
								<label class="input__label" for="if-name">
									<span class="input__label-content"><i class="fa fa-phone"></i> Your Telephone</span>
								</label>
							</span>
							<!-- /Interactive Input -->
						</div>
						<div class="col-sm-3">
							<button type="submit" class="btn btn-register"><i class="fa fa-paper-plane"></i> Register Now</button>
						</div>
						<input type="hidden" value="New Register!" name="subject" id="subject">

					</form>
				</div>
			</div>	
		</div>
		<!-- /SECTION: Register
		================================================== -->
	</div>
</div>

<!-- Contact Form - Ajax Messages
========================================================= -->
<!-- Form Sucess -->
<div class="form-result modal-wrap" id="contactSuccess">
  <div class="modal-bg"></div>
  <div class="modal-content">
    <h4 class="modal-title"><i class="fa fa-check-circle"></i> Success!</h4>
    <p>Your message has been sent to us.</p>
  </div>
</div>
<!-- /Form Sucess -->
<!-- form-error -->
<div class="form-result modal-wrap" id="contactError">
  <div class="modal-bg"></div>
  <div class="modal-content">
    <h4 class="modal-title"><i class="fa fa-times"></i> Error</h4>
    <p>There was an error sending your message.</p>
  </div>
</div>
<!-- /form-error -->
<!-- / Contact Form - Ajax Messages
========================================================= -->


<!-- Footer
================================================== -->
<footer id="footer" class="jumb-footer">
	<div class="container">
		<!-- row -->
		<div class="row">
			<!-- col -->
			<div class="col-sm-6">
				&copy; Copyright <?php echo e(date('Y')); ?>, All Rights Reserved by <i> JPCann Associates</i>
			</div>
			<!-- /col -->
			<!-- col -->
			<div class="col-sm-6">
				<!-- Social Icons -->
				<div class="footer-social-icons">
					<a href="https://www.instagram.com/jpcannassociatesltd/" target="_blank"><i class="fa fa-instagram"></i></a>
					<a href="https://www.facebook.com/jpcannassociateslimited/" target="_blank"><i class="fa fa-facebook"></i></a>
					<a href="https://twitter.com/jpcanngroup"><i class="fa fa-twitter" target="_blank"></i></a>
					<a href="https://www.linkedin.com/company/3490626/admin/feed/posts/" target="_blank"><i class="fa fa-linkedin"></i></a>
					
				</div>
				<!-- /Social Icons -->
			</div>
			<!-- /col -->
		</div>
		<!-- /row -->
	</div>	
</footer>
<!-- /Footer
================================================== -->

<!-- >> JS
============================================================================== -->

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="<?php echo e(asset('landing_assets/vendor/jquery-1.11.3.min.js')); ?>"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="<?php echo e(asset('landing_assets/vendor/bootstrap/js/bootstrap.min.js')); ?>"></script>
<!-- Crossbrowser-->
<script src="<?php echo e(asset('landing_assets/vendor/cross-browser.js')); ?>"></script>
<!-- /Crossbrowser-->
<!-- CountDown -->
<script src="<?php echo e(asset('landing_assets/vendor/jquery.countdown.min.js')); ?>"></script>
<!-- /CountDown -->
<!-- Waypoints-->
<script src="<?php echo e(asset('landing_assets/vendor/waypoints.min.js')); ?>"></script>
<!-- /Waypoints -->
<!-- Retina ready script-->
<script src="<?php echo e(asset('landing_assets/vendor/retina.min.js')); ?>"></script>
<!-- /Retina ready script -->
<!-- Modernizr -->
<script src="<?php echo e(asset('landing_assets/vendor/modernizr.js')); ?>"></script>
<!-- /Modernizr -->
<!-- Count To (Counters) -->
<script src="<?php echo e(asset('landing_assets/vendor/count-to.js')); ?>"></script>
<!-- /Count To (Counters) -->
<!-- SkrollR-->
<script src="<?php echo e(asset('landing_assets/vendor/skrollr.min.js')); ?>"></script>
<!-- /SkrollR -->
<!-- Validate -->
<script src="<?php echo e(asset('landing_assets/vendor/validate.js')); ?>"></script>
<!-- / Validate -->
<!-- Fancybox -->
<script src="<?php echo e(asset('landing_assets/vendor/fancybox/jquery.fancybox.js')); ?>"></script>
<!-- /fancybox -->
<!-- Owl Caroulsel -->
<script src="<?php echo e(asset('landing_assets/vendor/owl.carousel/owl-carousel/owl.carousel.js')); ?>"></script>
<!-- /Owl Caroulsel -->
<!-- Classie -->
<script src="<?php echo e(asset('landing_assets/vendor/classie.js')); ?>"></script>
<!-- /Classie -->
<!-- Main JS -->
<script src="<?php echo e(asset('landing_assets/js/main.js')); ?>"></script>
<!-- /Main JS -->

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
  <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

<!-- >> /JS
============================================================================= -->

</body>
</html><?php /**PATH C:\laragon\www\comaziwa\resources\views/landing_page/index.blade.php ENDPATH**/ ?>