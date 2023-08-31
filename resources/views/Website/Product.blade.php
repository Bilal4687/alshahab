@extends('website.layout')
@section('content')
	<div class="main-content main-content-product no-sidebar">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="breadcrumb-trail breadcrumbs">
						<ul class="trail-items breadcrumb">
							<li class="trail-item trail-begin">
								<a href="{{ url('/') }}">Home</a>
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
                                @csrf
								<span class="title">Sort</span>
                                    <select title="sort" id="SortProducts" data-placeholder="9 Products/Page" class="chosen-select">
                                        {{-- <option disabled selected>9 Products/Page</option> --}}
                                        <option value="3">3 Products/Page</option>
                                        <option value="5">5 Products/Page</option>
                                        <option value="16">16 Products/Page</option>
                                        <option value="20">20 Products/Page</option>
                                        <option value="24">24Products/Page</option>
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

                                    <a class="modes-mode mode-list">
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

						<ul class="row list-products auto-clear equal-container product-grid" id="GridView">
                            @foreach ($products as $product)
							 <li class="product-item product-type-variable col-lg-3 col-md-4 col-sm-6 col-xs-6 col-ts-12 style-1">
								<div class="product-inner equal-element">
									<div class="product-top">
									</div>
									<div class="product-thumb">
										<div class="thumb-inner">
											<a href="#">
                                                <img src="{{config('global.main_url')}}/public/Files/Products/{{$product->product_thumbnail}}" alt="img">
											</a>
											<div class="thumb-group">
												<div class="yith-wcwl-add-to-wishlist">
													<div class="yith-wcwl-add-button">
														<a href="#">Add to Wishlist</a>
													</div>
												</div>
												<a href="{{ url('product') }}/{{ $product->product_slug }}" class="button quick-wiew-button">Quick View</a>
												<div class="loop-form-add-to-cart">
													<button class="single_add_to_cart_button button">Add to cart
													</button>
												</div>
											</div>
										</div>
									</div>
									<div class="product-info">
										<h5 class="product-name product_title">
											<a href="#">{{$product->product_name ?? ""}}</a>
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
                                                    {{$product->pricing[0]->mrp_price ?? ''}}
                                                </del>
                                                <ins>
                                                    {{$product->pricing[0]->sale_price ?? ''}}
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
				</div>

			</div>
		</div>
	</div>

    <script>
        $(document).ready(function() {
            $('#SortProducts').change(function() {
                var productsPerPage = $(this).val();
                var sortBy = 'product_id';
                var sortDirection = 'asc';

                $.ajax({
                    url: '{{ url('SortProductByNumber') }}',
                    data: {
                        productsPerPage: productsPerPage,
                        sortBy: sortBy,
                        sortDirection: sortDirection
                    },
                    success: function(response) {
                        $('#GridView').empty();
                        $.each(response.product, function(index, product) {

                            var productHtml = ''

                                var productHtml = `
                            <li class="product-item product-type-variable col-lg-3 col-md-4 col-sm-6 col-xs-6 col-ts-12 style-1">
                            <div class="product-inner equal-element">
                                <div class="product-top">
                                </div>
                                <div class="product-thumb">
                                    <div class="thumb-inner">
                                        <a href="#">
                                            <img src="{{config('global.main_url')}}/public/Files/Products/${product.product_thumbnail}" alt="img">
                                        </a>
                                        <div class="thumb-group">
                                            <div class="yith-wcwl-add-to-wishlist">
                                                <div class="yith-wcwl-add-button">
                                                    <a href="#">Add to Wishlist</a>
                                                </div>
                                            </div>
                                            <a href="{{ url('product') }}/${product.product_slug}" class="button quick-wiew-button">Quick View</a>
                                            <div class="loop-form-add-to-cart">
                                                <button class="single_add_to_cart_button button">Add to cart</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-info">
                                    <h5 class="product-name product_title">
                                        <a href="#">${product.product_name ?? ""}</a>
                                    </h5>
                                    <div class="group-info">
                                        <div class="stars-rating">
                                            <div class="star-rating">
                                                <span class="star-3"></span>
                                            </div>
                                            <div class="count-star">(3)</div>
                                        </div>
                                        <div class="price">
                                            <del>${product.mrp_price ?? ''}</del>
                                            <ins>${product.sale_price ?? ''}</ins>
                                        </div>
                                        </div>
                                </div>
                                </div>
                                </li>`;
                            $('#GridView').append(productHtml);
                        });
                    }
                });
            });
        });
    </script>
@endsection
