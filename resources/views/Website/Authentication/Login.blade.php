@extends('website.layout')
@section('content')
	<div class="header-device-mobile">
		<div class="wapper">
			<div class="item mobile-logo">
				<div class="logo">
					<a href="#">
						<img src="public/assets/images/logo.png" alt="img">
					</a>
				</div>
			</div>
			<div class="item item mobile-search-box has-sub">
				<a href="#">
						<span class="icon">
							<i class="fa fa-search" aria-hidden="true"></i>
						</span>
				</a>
				<div class="block-sub">
					<a href="#" class="close">
						<i class="fa fa-times" aria-hidden="true"></i>
					</a>
					<div class="header-searchform-box">
						<form class="header-searchform">
							<div class="searchform-wrap">
								<input type="text" class="search-input" placeholder="Enter keywords to search...">
								<input type="submit" class="submit button" value="Search">
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="item mobile-settings-box has-sub">
				<a href="#">
						<span class="icon">
							<i class="fa fa-cog" aria-hidden="true"></i>
						</span>
				</a>
				<div class="block-sub">
					<a href="#" class="close">
						<i class="fa fa-times" aria-hidden="true"></i>
					</a>
					<div class="block-sub-item">
						<h5 class="block-item-title">Currency</h5>
						<form class="currency-form stelina-language">
							<ul class="stelina-language-wrap">
								<li class="active">
									<a href="#">
											<span>
												English (USD)
											</span>
									</a>
								</li>
								<li>
									<a href="#">
											<span>
												French (EUR)
											</span>
									</a>
								</li>
								<li>
									<a href="#">
											<span>
												Japanese (JPY)
											</span>
									</a>
								</li>
							</ul>
						</form>
					</div>
				</div>
			</div>
			<div class="item menu-bar">
				<a class=" mobile-navigation  menu-toggle" href="#">
					<span></span>
					<span></span>
					<span></span>
				</a>
			</div>
		</div>
	</div>
	<div class="main-content main-content-login">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="breadcrumb-trail breadcrumbs">
						<ul class="trail-items breadcrumb">
							<li class="trail-item trail-begin">
								<a href="index.html">Home</a>
							</li>
							<li class="trail-item trail-end active">
								Authentication
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="content-area col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="site-main">
						<h3 class="custom_blog_title">
							Authentication
						</h3>
						<div class="customer_login">
							<div class="row">
								<div class="col-lg-6 col-md-6 col-sm-12">
									<div class="login-item">
										<h5 class="title-login">Login your Account</h5>
										<form class="login">
											<p class="form-row form-row-wide">
												<label class="text">Username</label>
												<input title="username" type="text" class="input-text">
											</p>
											<p class="form-row form-row-wide">
												<label class="text">Password</label>
												<input title="password" type="password" class="input-text">
											</p>
											<p class="lost_password">
												<span class="inline">
													<input type="checkbox" id="cb1">
													<label for="cb1" class="label-text">Remember me</label>
												</span>
												<a href="#" class="forgot-pw">Forgot password?</a>
											</p>
											<p class="form-row">
												<input type="submit" class="button-submit" value="login">
											</p>
										</form>
									</div>
								</div>
								<div class="col-lg-6 col-md-6 col-sm-12">
									<div class="login-item">
										<h5 class="title-login">Register now</h5>
										<form class="register">
											<p class="form-row form-row-wide">
												<label class="text">Your email</label>
												<input title="email" type="email" class="input-text">
											</p>
                                            <p class="form-row form-row-wide">
												<label class="text">Your Contact No</label>
												<input title="contact" type="email" class="input-text">
											</p>
											<p class="form-row form-row-wide">
												<label class="text">Username</label>
												<input title="name" type="text" class="input-text">
											</p>
											<p class="form-row form-row-wide">
												<label class="text">Password</label>
												<input title="pass" type="password" class="input-text">
											</p>
											<p class="form-row">
												<span class="inline">
													<input type="checkbox" id="cb2">
													<label for="cb2" class="label-text">I agree to <span>Terms & Conditions</span></label>
												</span>
											</p>
											<p class="">
												<input type="submit" class="button-submit" value="Register Now">
											</p>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="footer-device-mobile">
		<div class="wapper">
			<div class="footer-device-mobile-item device-home">
				<a href="index.html">
					<span class="icon">
						<i class="fa fa-home" aria-hidden="true"></i>
					</span>
					Home
				</a>
			</div>
			<div class="footer-device-mobile-item device-home device-wishlist">
				<a href="#">
					<span class="icon">
						<i class="fa fa-heart" aria-hidden="true"></i>
					</span>
					Wishlist
				</a>
			</div>
			<div class="footer-device-mobile-item device-home device-cart">
				<a href="#">
					<span class="icon">
						<i class="fa fa-shopping-basket" aria-hidden="true"></i>
						<span class="count-icon">
							0
						</span>
					</span>
					<span class="text">Cart</span>
				</a>
			</div>
			<div class="footer-device-mobile-item device-home device-user">
				<a href="#">
					<span class="icon">
						<i class="fa fa-user" aria-hidden="true"></i>
					</span>
					Account
				</a>
			</div>
		</div>
	</div>
	<a href="#" class="backtotop">
		<i class="fa fa-angle-double-up"></i>
	</a>


@endsection

