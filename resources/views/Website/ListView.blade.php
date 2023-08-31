@extends('website.layout')
@section('content')
	<div class="main-content main-content-product no-sidebar">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="breadcrumb-trail breadcrumbs">
						<ul class="trail-items breadcrumb">
							<li class="trail-item trail-begin">
								<a href="index.html">Home</a>
							</li>
							<li class="trail-item trail-end active">
								Products
							</li>
						</ul>
					</div>
				</div>
			</div>


			<div class="row ProductDetail">
				<div class="content-area shop-grid-content full-width col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="site-main">
						<h3 class="custom_blog_title">
							Products
						</h3>
						<div class="shop-top-control">
							<form class="select-item select-form">
								<span class="title">Sort</span>
                                    <select title="sort" data-placeholder="9 Products/Page" class="chosen-select">
                                        {{-- <option disabled selected>9 Products/Page</option> --}}
                                        <option value="3">3 Products/Page</option>
                                        <option value="6">6 Products/Page</option>
                                        <option value="18">18 Products/Page</option>
                                        <option value="24">24 Products/Page</option>
                                        <option value="30">30Products/Page</option>
                                    </select>
							</form>
							<form class="filter-choice select-form">
								<span class="title">Sort by</span>
								<select title="sort-by" data-placeholder="Price: Low to High" class="chosen-select">
									<option value="1">Price: Low to High</option>
									<option value="2">Sort by popularity</option>
									<option value="3">Sort by average rating</option>
									<option value="4">Sort by newness</option>
									<option value="5">Sort by price: low to high</option>
								</select>
							</form>
							<div class="grid-view-mode">
								<div class="inner">
									<a href="{{ url('ListView') }}" class="modes-mode mode-list">
										<span></span>
										<span></span>
									</a>
									<a location.reload class="modes-mode mode-grid  active">
										<span></span>
										<span></span>
										<span></span>
										<span></span>
									</a>
								</div>
							</div>
						</div>

                        <ul class="row list-products auto-clear equal-container product-list" id="ListView">
                            @foreach ($products as $product)
                            <li class="product-item style-list col-lg-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-ts-12">
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
                                <div class="products-bottom-content">
                                    <div class="product-thumb">
                                        <div class="thumb-inner">
                                            <a href="#">
                                                <img src="{{config('global.main_url')}}/public/Files/Products/{{$product->product_thumbnail}}" alt="img">
                                            </a>
                                            <a href="{{ url('product') }}/{{ $product->product_slug }}" class="button quick-wiew-button">Quick View</a>
                                        </div>
                                    </div>
                                    <div class="product-info-left">
                                        <div class="yith-wcwl-add-to-wishlist">
                                            <div class="yith-wcwl-add-button">
                                                <a href="#">Add to Wishlist</a>
                                            </div>
                                        </div>
                                        <h5 class="product-name product_title">
                                            <a href="#">{{$product->product_name ?? ""}}</a>
                                        </h5>
                                        <div class="stars-rating">
                                            <div class="star-rating">
                                                <span class="star-3"></span>
                                            </div>
                                            <div class="count-star">
                                                (3)
                                            </div>
                                        </div>
                                        <ul class="product-attributes">
                                            <li>
                                                Material:
                                            </li>
                                            <li>
                                                <a href="#">Plastic</a>
                                            </li>
                                            <li>
                                                <a href="#"> Woody</a>
                                            </li>
                                        </ul>
                                        <ul class="attributes-display">
                                            <li class="swatch-color">
                                                Color:
                                            </li>
                                            <li class="swatch-color">
                                                <a href="#">Black</a>
                                            </li>
                                            <li class="swatch-color">
                                                <a href="#">White</a>
                                            </li>
                                            <li class="swatch-color">
                                                <a href="#">Brown</a>
                                            </li>
                                        </ul>
                                        <ul class="attributes-display">
                                            <li class="swatch-text-label">
                                                Pots Size:
                                            </li>
                                            <li class="swatch-text-label">
                                                <a href="#">XS</a>
                                            </li>
                                            <li class="swatch-text-label">
                                                <a href="#">S</a>
                                            </li>
                                            <li class="swatch-text-label">
                                                <a href="#">M</a>
                                            </li>
                                            <li class="swatch-text-label">
                                                <a href="#">L</a>
                                            </li>
                                            <li class="swatch-text-label">
                                                <a href="#">XL</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="product-info-right">
                                        <div class="price">
                                            <del>
                                                {{$product->pricing[0]->mrp_price ?? ''}}
                                            </del>
                                            <ins>
                                                {{$product->pricing[0]->sale_price ?? ''}}
                                            </ins>
                                        </div>
                                        <div class="product-list-message">
                                            <i class="icon fa fa-truck" aria-hidden="true"></i>
                                            UK Free Delivery
                                        </div>
                                        <form class="cart">
                                            <div class="single_variation_wrap">
                                                <div class="quantity">
                                                    <div class="control">
                                                        <a class="btn-number qtyminus quantity-minus" href="#">-</a>
                                                        <input type="text" data-step="1" data-min="0" value="1"
                                                               title="Qty" class="input-qty qty" size="4">
                                                        <a href="#" class="btn-number qtyplus quantity-plus">+</a>
                                                    </div>
                                                </div>
                                                <button class="single_add_to_cart_button button">Add to cart</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>

                    </div>

					</div>
				</div>

			</div>
		</div>
	</div>

    <script>


</script>

@endsection
