<!DOCTYPE html>
<html lang="en">
<head>
    <title>Guessmyscent - Home</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="{{url('public/assets/images/favicon.png/')}}">
    <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{url('public/assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{url('public/assets/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{url('public/assets/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{url('public/assets/css/animate.min.css')}}">
    <link rel="stylesheet" href="{{url('public/assets/css/jquery-ui.css')}}">
    <link rel="stylesheet" href="{{url('public/assets/css/slick.css')}}">
    <link rel="stylesheet" href="{{url('public/assets/css/chosen.min.css')}}">
    <link rel="stylesheet" href="{{url('public/assets/css/pe-icon-7-stroke.css')}}">
    <link rel="stylesheet" href="{{url('public/assets/css/magnific-popup.min.css')}}">
    <link rel="stylesheet" href="{{url('public/assets/css/lightbox.min.css')}}">
    <link rel="stylesheet" href="{{url('public/assets/js/fancybox/source/jquery.fancybox.css')}}">
    <link rel="stylesheet" href="{{url('public/assets/css/jquery.scrollbar.min.css')}}">
    <link rel="stylesheet" href="{{url('public/assets/css/mobile-menu.css')}}">
    <link rel="stylesheet" href="{{url('public/assets/fonts/flaticon/flaticon.css')}}">
    <link rel="stylesheet" href="{{url('public/assets/css/style.css')}}">
</head>
<body class="home">
<header class="header style2">
    <div class="top-bar">
        <div class="container">
            <div class="top-bar-left">
                <div class="header-message">
                    Welcome to our online store!
                </div>
            </div>
            <div class="top-bar-right">
                <div class="header-language">
                    <div class="stelina-language stelina-dropdown">
                        <a href="#" class="active language-toggle" data-stelina="stelina-dropdown">
								<span>
									English (USD)
								</span>
                        </a>
                        <ul class="stelina-submenu">
                            <li class="switcher-option">
                                <a href="#">
										<span>
											French (EUR)
										</span>
                                </a>
                            </li>
                            <li class="switcher-option">
                                <a href="#">
										<span>
											Japanese (JPY)
										</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <ul class="header-user-links">
                    <li>
                        <a href="{{ url('Login') }}">Login or Register</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="main-header">
            <div class="row">
                <div class="col-lg-4 col-sm-6 col-md-4 col-xs-7 col-ts-12 header-element">
                    <div class="block-search-block">
                        <form class="form-search">
                            <div class="form-content">
                                <div class="inner">
                                    <input type="text" class="input" name="s" value="" placeholder="Search here">
                                    <button class="btn-search" type="submit">
                                        <span class="icon-search"></span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 col-md-4 col-xs-5 col-ts-12">
                    <div class="logo">
                        <a href="{{ route('Home') }}">
                            <img width="150px" src="{{url('public/assets/images/Guessmyscent.png')}}" alt="logo">
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-12 col-md-4 col-xs-12 col-ts-12">
                    <div class="header-control">
                        <div class="block-minicart stelina-mini-cart block-header stelina-dropdown">
                            <a href="javascript:void(0);" class="shopcart-icon" data-stelina="stelina-dropdown">
                                Cart
                                <span class="count">
									0
									</span>
                            </a>
                            <div class="no-product stelina-submenu">
                                <p class="text">
                                    You have
                                    <span>
											 0 item(s)
										</span>
                                    in your bag
                                </p>
                            </div>
                        </div>
                        <a class="menu-bar mobile-navigation menu-toggle" href="#">
                            <span></span>
                            <span></span>
                            <span></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- navbar  --}}
    <div class="header-nav-container">
        <div class="container">
            <div class="header-nav-wapper main-menu-wapper">
                <div class="header-nav">
                    <div class="container-wapper">
                        <ul class="stelina-clone-mobile-menu stelina-nav main-menu " id="menu-main-menu">
                            <li class="menu-item">
                                <a href="{{url('/')}}" class="stelina-menu-item-title" title="Home">Home</a>
                            </li>
                            @foreach ($categories as $category)
                            @if ($category->parent_id == 0)
                                <li class="menu-item menu-item-has-children">
                                    <a href="{{ url('result') }}/{{ $category->slug }}" class="stelina-menu-item-title" title="Home">{{ $category->category_name }}</a>
                                    <span class="toggle-submenu"></span>
                                    <ul>
                                        @foreach ($categoryTree as $category)
                                            <li>
                                                {{ $category->category_name }}
                                                @if (isset($category->children))
                                                    @include('partials.subcategories', ['subcategories' => $category->children])
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>

                                </li>
                            @endif
                        @endforeach

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- navbar --}}
</header>
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

@yield('content')

<footer class="footer style7">
    <div class="container">
        <div class="container-wapper">
            <div class="row">
                <div class="box-footer col-xs-12 col-sm-4 col-md-4 col-lg-4 hidden-sm hidden-md hidden-lg">
                    <div class="stelina-newsletter style1">
                        <div class="newsletter-head">
                            <h3 class="title">Newsletter</h3>
                        </div>
                        <div class="newsletter-form-wrap">
                            <div class="list">
                                Sign up for our free video course and <br/> urban garden inspiration
                            </div>
                            <input type="email" class="input-text email email-newsletter"
                                   placeholder="Your email letter">
                            <button class="button btn-submit submit-newsletter">SUBSCRIBE</button>
                        </div>
                    </div>
                </div>
                <div class="box-footer col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    <div class="stelina-custommenu default">
                        <h2 class="widgettitle">Quick Menu</h2>
                        <ul class="menu">
                            <li class="menu-item">
                                <a href="#">New arrivals</a>
                            </li>
                            <li class="menu-item">
                                <a href="#">Life style</a>
                            </li>
                            <li class="menu-item">
                                <a href="#">Accents</a>
                            </li>
                            <li class="menu-item">
                                <a href="#">Tables</a>
                            </li>
                            <li class="menu-item">
                                <a href="#">Dining</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="box-footer col-xs-12 col-sm-4 col-md-4 col-lg-4 hidden-xs">
                    <div class="stelina-newsletter style1">
                        <div class="newsletter-head">
                            <h3 class="title">Newsletter</h3>
                        </div>
                        <div class="newsletter-form-wrap">
                            <div class="list">
                                Sign up for our free video course and <br/> urban garden inspiration
                            </div>
                            <input type="email" class="input-text email email-newsletter"
                                   placeholder="Your email letter">
                            <button class="button btn-submit submit-newsletter">SUBSCRIBE</button>
                        </div>
                    </div>
                </div>
                <div class="box-footer col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    <div class="stelina-custommenu default">
                        <h2 class="widgettitle">Information</h2>
                        <ul class="menu">
                            <li class="menu-item">
                                <a href="#">FAQs</a>
                            </li>
                            <li class="menu-item">
                                <a href="#">Track Order</a>
                            </li>
                            <li class="menu-item">
                                <a href="#">Delivery</a>
                            </li>
                            <li class="menu-item">
                                <a href="#">Contact Us</a>
                            </li>
                            <li class="menu-item">
                                <a href="#">Return</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="footer-end">
                <div class="row">
                    <div class="col-sm-12 col-xs-12">
                        <div class="stelina-socials">
                            <ul class="socials">
                                <li>
                                    <a href="#" class="social-item" target="_blank">
                                        <i class="icon fa fa-facebook"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="social-item" target="_blank">
                                        <i class="icon fa fa-twitter"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="social-item" target="_blank">
                                        <i class="icon fa fa-instagram"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="coppyright">
                            Copyright © 2020
                            <a href="#">Stelina</a>
                            . All rights reserved
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
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
            <a href="login.html">
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
<script src="{{url('public/assets/js/jquery-1.12.4.min.js')}}"></script>
<script src="{{url('public/assets/js/jquery.plugin-countdown.min.js')}}"></script>
<script src="{{url('public/assets/js/jquery-countdown.min.js')}}"></script>
<script src="{{url('public/assets/js/bootstrap.min.js')}}"></script>
<script src="{{url('public/assets/js/owl.carousel.min.js')}}"></script>
<script src="{{url('public/assets/js/magnific-popup.min.js')}}"></script>
<script src="{{url('public/assets/js/isotope.min.js')}}"></script>
<script src="{{url('public/assets/js/jquery.scrollbar.min.js')}}"></script>
<script src="{{url('public/assets/js/jquery-ui.min.js')}}"></script>
<script src="{{url('public/assets/js/mobile-menu.js')}}"></script>
<script src="{{url('public/assets/js/chosen.min.js')}}"></script>
<script src="{{url('public/assets/js/slick.js')}}"></script>
<script src="{{url('public/assets/js/jquery.elevateZoom.min.js')}}"></script>
<script src="{{url('public/assets/js/jquery.actual.min.js')}}"></script>
<script src="{{url('public/assets/js/fancybox/source/jquery.fancybox.js')}}"></script>
<script src="{{url('public/assets/js/lightbox.min.js')}}"></script>
<script src="{{url('public/assets/js/owl.thumbs.min.js')}}"></script>
<script src="{{url('public/assets/js/jquery.scrollbar.min.js')}}"></script>
{{-- <script src="{{url('public/assets/js/frontend-plugin.js')}}"></script> --}}
</body>
</html>
