@extends('Website.Layout')
@section('content')

<div class="">
    <div class="fullwidth-template">
        <div class="home-slider fullwidth rows-space-60">
            <div class="slider-owl owl-slick equal-container nav-center equal-container"
                 data-slick='{"autoplay":true, "autoplaySpeed":10000, "arrows":true, "dots":true, "infinite":true, "speed":800, "rows":1}'
                 data-responsive='[{"breakpoint":"2000","settings":{"slidesToShow":1}}]'>
                @foreach ($sliders as $item)
                <div class="slider-item style6">
                    <div class="slider-inner equal-element" style="background-image: url(public/Files/Home-Slider/{{$item->home_slider_path}});background-size: cover; hieght: 100px;">
                        <div class="container">
                            <div class="slider-infor">
                                <h5 class="title-small">
                                    Make your hand!
                                </h5>
                                <h3 class="title-big">
                                    {{$item->home_slider_title}}
                                </h3>
                                <div class="price">
                                    {{$item->home_slider_description}}
                                </div>
                                <a href="#" class="button btn-lets-create bgroud-style">Shop now</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- update  --}}
       <div class="banner-video-wrapp rows-space-40 type2">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="banner" >
                            <div class="item-banner style9">
                                <div class="inner" style="background-image: url(public/assets/image/image_4.jpg); background-size: cover;">
                                    <div class="banner-content">
                                        <h4 class="stelina-subtitle">Hurry up</h4>
                                        <h3 class="title">Big Sale To <br/> 30% Off</h3>
                                        <div class="code">
                                            Use promo Code:
                                            <span class="nummer-code">STELINA</span>
                                        </div>
                                        <a href="#" class="button btn-shop-now">Shop now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="banner">
                            <div class="item-banner style9 type1">
                                <div class="inner" style="background-image: url(public/assets/image/image_6.jpg); background-size: cover;">
                                    <div class="banner-content">
                                        <h4 class="stelina-subtitle">Sale Up to 50% Off</h4>
                                        <h3 class="title"> Get daily <br/> update</h3>
                                        <div class="code">
                                            Use promo Code:
                                            <span class="nummer-code">STELINA</span>
                                        </div>
                                        <a href="#" class="button btn-shop-now">Shop now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- New Arrivals  --}}
        <div class="stelina-product produc-featured rows-space-40">
            <div class="container">
                <h3 class="custommenu-title-blog">
                    New Arrivals
                </h3>
                    {{-- @php
                        dd($NewArrivals)
                    @endphp --}}
                <ul class="row list-products auto-clear equal-container product-grid">
                    @foreach ($NewArrivals as $New)
                    <li class="product-item product-type-variable col-lg-3 col-md-4 col-sm-6 col-xs-6 col-ts-12 style-1">
                        <div class="product-inner equal-element">
                            <div class="product-top">
                                <div class="flash">
                                    <span class="onnew">
                                        <span class="text">new</span>
                                    </span>
                                </div>
                            </div>
                            <div class="product-thumb">
                                <div class="thumb-inner">

                                    <a href="{{url('product')}}/{{$New->product_slug ?? ''}}">
                                      <img src="public/Files/Products/{{$New->product_thumbnail}}" alt="img">
                                    </a>
                                    <div class="thumb-group">
                                        <div class="yith-wcwl-add-to-wishlist">
                                            <div class="yith-wcwl-add-button">
                                                <a href="{{url('product')}}/{{$New->product_slug ?? ''}}">Add to Wishlist</a>
                                            </div>
                                        </div>
                                        <a href="{{url('product')}}/{{$New->product_slug ?? ''}}" class="button quick-wiew-button">Quick View</a>
                                        <div class="loop-form-add-to-cart">
                                            <button class="single_add_to_cart_button button">Add to cart
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="product-info">
                                <h5 class="product-name product_title">
                                    <a href="#">{{$New->product_name}}</a>
                                </h5>
                                <div class="group-info">
                                    <div class="stars-rating">
                                        <div class="star-rating">
                                            <span class="star-4"></span>
                                        </div>
                                    </div>
                                        <div class="price">
                                            <del>
                                                {{$New->pricing[0]->mrp_price ?? ''}}
                                            </del>
                                            <ins>
                                                {{$New->pricing[0]->sale_price ?? ''}}
                                            </ins>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>

        {{-- Collection Sale  --}}
        <div class="banner-pinmap-wrapp rows-space-70">
            <div>
                <div class="banner">
                    <div class="item-banner style21">
                        <div class="inner" style="background-image: url(public/assets/images/banner-home-19.jpg);">
                            <div class="banner-content container">
                                <div class="banner-content-inner">
                                    <h4 class="stelina-subtitle">Style your chair</h4>
                                    <h3 class="title">
                                        Collection<br/>
                                        Sale <span>15%</span> Off
                                    </h3>
                                    <div class="start-from">
                                        start from <span>Dec 27</span> to <span>dec 29</span>
                                    </div>
                                    <a href="#" class="button btn-shop-now">Shop now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- NewLatter  --}}
        <div class="stelina-testimonials-newsletter-wrapp">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="stelina-testimonials-wrapp">
                            <div class="stelina-testimonials default">
                                <div class="owl-slick equal-container"
                                     data-slick='{"autoplay":false, "autoplaySpeed":1000, "arrows":false, "dots":true, "infinite":true, "speed":800}'
                                     data-responsive='[{"breakpoint":"2000","settings":{"slidesToShow":1}}]'>
                                    <div class="testimonial-item">
                                        <div class="image">
                                            <img src="public/assets/images/testimonial-1.png" alt="img">
                                        </div>
                                        <div class="info">
                                            <h5 class="name">
                                                Guessmyscent
                                                <span>Shop Owner</span>
                                            </h5>
                                            <div class="text">
                                                <p>
                                                    Lorem ipsum dolor sit amet consectetur adipiscing elit diam consequat est,
                                                    eleifend conubia himenaeos ac vel cursus interdum eu varius non nam, scelerisque
                                                    eros rhoncus nascetur porttitor urna nisi gravida lacinia. Quam dictumst non bibendum
                                                    venenatis malesuada nec lacinia volutpat ante
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="testimonial-item">
                                        <div class="image">
                                            <img src="public/assets/images/testimonial-2.png" alt="img">
                                        </div>
                                        <div class="info">
                                            <h5 class="name">
                                                Guessmyscent
                                                <span>Shop Owner</span>
                                            </h5>
                                            <div class="text">
                                                <p>
                                                    Lorem ipsum dolor sit amet consectetur adipiscing elit diam consequat est,
                                                    eleifend conubia himenaeos ac vel cursus interdum eu varius non nam, scelerisque
                                                    eros rhoncus nascetur porttitor urna nisi gravida lacinia. Quam dictumst non bibendum
                                                    venenatis malesuada nec lacinia volutpat ante
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="stelina-newsletter default" style="background-image: url(public/assets/image/images_3.jpg); background-size: cover;">
                            <div class="newsletter-head">
                                <h3 class="title">Newsletter</h3>
                                <div class="subtitle">Get more special Deals, Events & Promotions</div>
                            </div>
                            <div class="newsletter-form-wrap">
                                <input class="input-text email email-newsletter" type="email" name="email"
                                       placeholder="Your email here...">
                                <button class="button btn-submit submit-newsletter">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ================== --}}
        <div class="banner-wrapp rows-space-30">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <div class="banner">
                            <div class="item-banner style16">
                                <div class="inner" style="background-image: url(public/assets/image/image_7.jpg);background-size: cover;">
                                    <div class="banner-content">
                                        <h3 class="title">Products for <br/>choose</h3>
                                        <div class="description" style="color: white">
                                            Wheel Collections <br/>New Arrivals
                                        </div>
                                        <a href="#" class="button btn-view-the-look">Shop now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                        <div class="banner">
                            <div class="item-banner style15">
                                <div class="inner" style="background-image: url(public/assets/image/image_10.jpg); background-size: cover;">
                                    <div class="banner-content">
                                        <h3 class="title">Summer Super Sale</h3>
                                        <div class="description" style="color: rgb(199, 197, 197);">
                                            Stelina style, day by day <br/>functionality!
                                        </div>
                                        <a href="#" class="button btn-view-the-look">Shop now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- ================== --}}

        {{-- weekly featured  --}}
        <div class="stelina-product layout1">
            <div class="container">
                <div class="container-wapper">
                    <div class="head">
                        <h3 class="title" style="margin-bottom: 0;">Weekly Featured</h3>
                        <div class="subtitle">Let’s Shop our featured item this week</div>
                    </div>
                    <div class="product-list-owl owl-slick equal-container nav-center-left"
                         data-slick='{"autoplay":false, "autoplaySpeed":1000, "arrows":true, "dots":false, "infinite":true, "speed":800,"infinite":false}'
                         data-responsive='[{"breakpoint":"2000","settings":{"slidesToShow":3}},{"breakpoint":"1200","settings":{"slidesToShow":2}},{"breakpoint":"992","settings":{"slidesToShow":1}},{"breakpoint":"768","settings":{"slidesToShow":2}},{"breakpoint":"481","settings":{"slidesToShow":1}}]'>
                         @foreach ($Weekly as $item)
                         <div class="product-item style-1 product-type-variable">
                             <div class="product-inner equal-element">
                                 <div class="product-top">
                                     <div class="flash">
                                             <span class="onnew">
                                                 <span class="text">
                                                     new
                                                 </span>
                                             </span>
                                     </div>
                                 </div>
                                 <div class="product-thumb">
                                     <div class="thumb-inner">
                                         <a href="{{url('product')}}/{{$New->product_slug}}">
                                             <img src="public/Files/Products/{{$New->product_thumbnail}}" alt="img">
                                         </a>
                                         <div class="thumb-group">
                                             <div class="yith-wcwl-add-to-wishlist">
                                                 <div class="yith-wcwl-add-button">
                                                     <a href="#">Add to Wishlist</a>
                                                 </div>
                                             </div>
                                             <a href="{{url('productdetails')}}/{{$New->product_slug}}" class="button quick-wiew-button">Quick View</a>
                                             <div class="loop-form-add-to-cart">
                                                 <button class="single_add_to_cart_button button">Add to cart
                                                 </button>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="product-info">
                                     <h5 class="product-name product_title">
                                         <a href="#">{{$New->product_name}}</a>
                                     </h5>
                                     <div class="group-info">
                                         <div class="stars-rating">
                                             <div class="star-rating">
                                                 <span class="star-3"></span>
                                             </div>
                                             <div class="count-star">
                                                 (3)
                                             </div>
                                         </div>
                                         {{-- <div class="price">
                                             <del>
                                                {{$New->mrp_price}}
                                             </del>
                                             <ins>
                                                 {{$New->sale_price}}
                                             </ins>
                                         </div> --}}
                                     </div>
                                 </div>
                             </div>
                         </div>
                         @endforeach
                        {{-- <div class="product-item style-1">
                            <div class="product-inner equal-element">
                                <div class="product-top">
                                    <div class="flash">
												<span class="onnew">
													<span class="text">
														new
													</span>
												</span>
                                    </div>
                                </div>
                                <div class="product-thumb">
                                    <div class="thumb-inner">
                                        <a href="#">
                                            <img src="public/assets/images/product-item-black-2.jpg" alt="img">
                                        </a>
                                        <div class="thumb-group">
                                            <div class="yith-wcwl-add-to-wishlist">
                                                <div class="yith-wcwl-add-button">
                                                    <a href="#">Add to Wishlist</a>
                                                </div>
                                            </div>
                                            <a href="#" class="button quick-wiew-button">Quick View</a>
                                            <div class="loop-form-add-to-cart">
                                                <button class="single_add_to_cart_button button">Add to cart
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-info">
                                    <h5 class="product-name product_title">
                                        <a href="#">Dainty Bangle</a>
                                    </h5>
                                    <div class="group-info">
                                        <div class="stars-rating">
                                            <div class="star-rating">
                                                <span class="star-3"></span>
                                            </div>
                                            <div class="count-star">
                                                (3)
                                            </div>
                                        </div>
                                        <div class="price">
                                            <del>
                                                $65
                                            </del>
                                            <ins>
                                                $45
                                            </ins>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-item style-1">
                            <div class="product-inner equal-element">
                                <div class="product-top">
                                    <div class="flash">
												<span class="onnew">
													<span class="text">
														new
													</span>
												</span>
                                    </div>
                                </div>
                                <div class="product-thumb">
                                    <div class="thumb-inner">
                                        <a href="#">
                                            <img src="public/assets/images/product-item-black-3.jpg" alt="img">
                                        </a>
                                        <div class="thumb-group">
                                            <div class="yith-wcwl-add-to-wishlist">
                                                <div class="yith-wcwl-add-button">
                                                    <a href="#">Add to Wishlist</a>
                                                </div>
                                            </div>
                                            <a href="#" class="button quick-wiew-button">Quick View</a>
                                            <div class="loop-form-add-to-cart">
                                                <button class="single_add_to_cart_button button">Add to cart
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-info">
                                    <h5 class="product-name product_title">
                                        <a href="#">The Alchemist</a>
                                    </h5>
                                    <div class="group-info">
                                        <div class="stars-rating">
                                            <div class="star-rating">
                                                <span class="star-3"></span>
                                            </div>
                                            <div class="count-star">
                                                (3)
                                            </div>
                                        </div>
                                        <div class="price">
                                            <del>
                                                $65
                                            </del>
                                            <ins>
                                                $45
                                            </ins>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-item style-1 product-type-variable">
                            <div class="product-inner equal-element">
                                <div class="product-top">
                                    <div class="flash">
												<span class="onnew">
													<span class="text">
														new
													</span>
												</span>
                                    </div>
                                </div>
                                <div class="product-thumb">
                                    <div class="thumb-inner">
                                        <a href="#">
                                            <img src="public/assets/images/product-item-black-4.jpg" alt="img">
                                        </a>
                                        <div class="thumb-group">
                                            <div class="yith-wcwl-add-to-wishlist">
                                                <div class="yith-wcwl-add-button">
                                                    <a href="#">Add to Wishlist</a>
                                                </div>
                                            </div>
                                            <a href="#" class="button quick-wiew-button">Quick View</a>
                                            <div class="loop-form-add-to-cart">
                                                <button class="single_add_to_cart_button button">Add to cart
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-info">
                                    <h5 class="product-name product_title">
                                        <a href="#">Garden A Winter </a>
                                    </h5>
                                    <div class="group-info">
                                        <div class="stars-rating">
                                            <div class="star-rating">
                                                <span class="star-3"></span>
                                            </div>
                                            <div class="count-star">
                                                (3)
                                            </div>
                                        </div>
                                        <div class="price">
                                            <del>
                                                $65
                                            </del>
                                            <ins>
                                                $45
                                            </ins>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-item style-1 product-type-variable">
                            <div class="product-inner equal-element">
                                <div class="product-top">
                                    <div class="flash">
												<span class="onnew">
													<span class="text">
														new
													</span>
												</span>
                                    </div>
                                </div>
                                <div class="product-thumb">
                                    <div class="thumb-inner">
                                        <a href="#">
                                            <img src="public/assets/images/product-item-black-5.jpg" alt="img">
                                        </a>
                                        <div class="thumb-group">
                                            <div class="yith-wcwl-add-to-wishlist">
                                                <div class="yith-wcwl-add-button">
                                                    <a href="#">Add to Wishlist</a>
                                                </div>
                                            </div>
                                            <a href="#" class="button quick-wiew-button">Quick View</a>
                                            <div class="loop-form-add-to-cart">
                                                <button class="single_add_to_cart_button button">Add to cart
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-info">
                                    <h5 class="product-name product_title">
                                        <a href="#">Melody Eau</a>
                                    </h5>
                                    <div class="group-info">
                                        <div class="stars-rating">
                                            <div class="star-rating">
                                                <span class="star-3"></span>
                                            </div>
                                            <div class="count-star">
                                                (3)
                                            </div>
                                        </div>
                                        <div class="price">
                                            <del>
                                                $65
                                            </del>
                                            <ins>
                                                $45
                                            </ins>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-item style-1 product-type-variable">
                            <div class="product-inner equal-element">
                                <div class="product-top">
                                    <div class="flash">
												<span class="onnew">
													<span class="text">
														new
													</span>
												</span>
                                    </div>
                                </div>
                                <div class="product-thumb">
                                    <div class="thumb-inner">
                                        <a href="#">
                                            <img src="public/assets/images/product-item-black-6.jpg" alt="img">
                                        </a>
                                        <div class="thumb-group">
                                            <div class="yith-wcwl-add-to-wishlist">
                                                <div class="yith-wcwl-add-button">
                                                    <a href="#">Add to Wishlist</a>
                                                </div>
                                            </div>
                                            <a href="#" class="button quick-wiew-button">Quick View</a>
                                            <div class="loop-form-add-to-cart">
                                                <button class="single_add_to_cart_button button">Add to cart
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-info">
                                    <h5 class="product-name product_title">
                                        <a href="#">Ambre Royal</a>
                                    </h5>
                                    <div class="group-info">
                                        <div class="stars-rating">
                                            <div class="star-rating">
                                                <span class="star-3"></span>
                                            </div>
                                            <div class="count-star">
                                                (3)
                                            </div>
                                        </div>
                                        <div class="price">
                                            <del>
                                                $65
                                            </del>
                                            <ins>
                                                $45
                                            </ins>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>

        {{-- OUR LATEST NEWS  --}}
        <div class="stelina-blog-wraap default">
            <div class="container">
                <h3 class="custommenu-title-blog">
                    Our Latest News
                </h3>
                <div class="stelina-blog style2">
                    <div class="owl-slick equal-container nav-center"
                         data-slick='{"autoplay":false, "autoplaySpeed":1000, "arrows":false, "dots":true, "infinite":true, "speed":800, "rows":1}'
                         data-responsive='[{"breakpoint":"2000","settings":{"slidesToShow":2}},{"breakpoint":"1200","settings":{"slidesToShow":1}},{"breakpoint":"992","settings":{"slidesToShow":1}},{"breakpoint":"768","settings":{"slidesToShow":1}},{"breakpoint":"481","settings":{"slidesToShow":1}}]'>
                        @foreach ($blogs as $item)
                            <div class="stelina-blog-item equal-element style2">
                            <div class="stelina-blog-inner">
                                <div class="post-thumb">
                                    <a href="#">
                                        <img src="public/Files/Blog/{{$item->image}}" alt="img" style="background-size: cover;width: 230px; height: 300px;">
                                    </a>
                                </div>
                                <div class="blog-info">
                                    <div class="post-top">
                                        <a href="#">new arrivals</a>
                                        <div class="post-item-share">
                                            <a href="#" class="icon">
                                                <i class="fa fa-share-alt" aria-hidden="true"></i>
                                            </a>
                                            <div class="box-content">
                                                <a href="#">
                                                    <i class="fa fa-facebook"></i>
                                                </a>
                                                <a href="#">
                                                    <i class="fa fa-twitter"></i>
                                                </a>
                                                <a href="#">
                                                    <i class="fa fa-google-plus"></i>
                                                </a>
                                                <a href="#">
                                                    <i class="fa fa-pinterest"></i>
                                                </a>
                                                <a href="#">
                                                    <i class="fa fa-linkedin"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="post-date">
                                        Agust 17, 09:14 am
                                    </div>
                                    <h2 class="blog-title">
                                        <a href="#">{{$item->blog_title}}</a>
                                        <p>{{$item->blog_short_description}}</p>
                                    </h2>
                                    <div class="blog-meta">
                                        <div class="blog-meta-wrapp">
                                                <span class="author">
                                                    <img src="public/assets/images/avt-blog1.png" alt="img">
                                                    Guessmyscent
                                                </span>
                                            <span class="view">
                                                    <i class="icon fa fa-eye" aria-hidden="true"></i>
                                                    631
                                                </span>
                                            <span class="comment">
                                                    <i class="icon fa fa-commenting" aria-hidden="true"></i>
                                                    84
                                                </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        @endforeach
                        {{-- <div class="stelina-blog-item equal-element style2">
                            <div class="stelina-blog-inner">
                                <div class="post-thumb">
                                    <a href="#">
                                        <img src="public/assets/images/slider-blog-thumb-6.jpg" alt="img">
                                    </a>
                                </div>
                                <div class="blog-info">
                                    <div class="post-top">
                                        <a href="#">New Arrivals</a>
                                        <div class="post-item-share">
                                            <a href="#" class="icon">
                                                <i class="fa fa-share-alt" aria-hidden="true"></i>
                                            </a>
                                            <div class="box-content">
                                                <a href="#">
                                                    <i class="fa fa-facebook"></i>
                                                </a>
                                                <a href="#">
                                                    <i class="fa fa-twitter"></i>
                                                </a>
                                                <a href="#">
                                                    <i class="fa fa-google-plus"></i>
                                                </a>
                                                <a href="#">
                                                    <i class="fa fa-pinterest"></i>
                                                </a>
                                                <a href="#">
                                                    <i class="fa fa-linkedin"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="post-date">
                                        Agust 17, 09:14 am
                                    </div>
                                    <h2 class="blog-title">
                                        <a href="#">Rosa was easy to deal, arrived quickly and very happy</a>
                                    </h2>
                                    <div class="blog-meta">
                                        <div class="blog-meta-wrapp">
												<span class="author">
													<img src="public/assets/images/avt-blog1.png" alt="img">
													Guessmyscent
												</span>
                                            <span class="view">
													<i class="icon fa fa-eye" aria-hidden="true"></i>
													631
												</span>
                                            <span class="comment">
													<i class="icon fa fa-commenting" aria-hidden="true"></i>
													84
												</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="stelina-blog-item equal-element style2">
                            <div class="stelina-blog-inner">
                                <div class="post-thumb">
                                    <a href="#">
                                        <img src="public/assets/images/slider-blog-thumb-7.jpg" alt="img">
                                    </a>
                                </div>
                                <div class="blog-info">
                                    <div class="post-top">
                                        <a href="#">New Arrivals</a>
                                        <div class="post-item-share">
                                            <a href="#" class="icon">
                                                <i class="fa fa-share-alt" aria-hidden="true"></i>
                                            </a>
                                            <div class="box-content">
                                                <a href="#">
                                                    <i class="fa fa-facebook"></i>
                                                </a>
                                                <a href="#">
                                                    <i class="fa fa-twitter"></i>
                                                </a>
                                                <a href="#">
                                                    <i class="fa fa-google-plus"></i>
                                                </a>
                                                <a href="#">
                                                    <i class="fa fa-pinterest"></i>
                                                </a>
                                                <a href="#">
                                                    <i class="fa fa-linkedin"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="post-date">
                                        Agust 17, 09:14 am
                                    </div>
                                    <h2 class="blog-title">
                                        <a href="#">How to Build Your Perfect Dining</a>
                                    </h2>
                                    <div class="blog-meta">
                                        <div class="blog-meta-wrapp">
												<span class="author">
													<img src="public/assets/images/avt-blog1.png" alt="img">
													Guessmyscent
												</span>
                                            <span class="view">
													<i class="icon fa fa-eye" aria-hidden="true"></i>
													631
												</span>
                                            <span class="comment">
													<i class="icon fa fa-commenting" aria-hidden="true"></i>
													84
												</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
