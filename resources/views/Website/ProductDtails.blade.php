@extends('Website.Layout')
@section('content')

<style>
    /* Customize Toastr alert colors */
    .larger-toast {
        background-color: #ab8e66; /* Replace with your desired background color */
        color: #ffffff;/* Replace with your desired text color */
    }

    .larger-toast .toast-close-button {
        color: #ffffff; /* Replace with your desired close button color */
    }

</style>

{{-- <div class="header-device-mobile">
    <div class="wapper">
        <div class="item mobile-logo">
            <div class="logo">
                <a href="#">
                    <img src="assets/images/logo.png" alt="img">
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
</div> --}}
<div class="main-content main-content-details single no-sidebar">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-trail breadcrumbs">
                    <ul class="trail-items breadcrumb">
                        <li class="trail-item trail-begin">
                            <a href="index.html">Home</a>
                        </li>
                        <li class="trail-item">
                            <a href="#">Accents</a>
                        </li>
                        <li class="trail-item trail-end active">
                            Glorious Eau
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="content-area content-details full-width col-lg-9 col-md-8 col-sm-12 col-xs-12">
                <div class="site-main">

                    {{-- Main Product Details  --}}

                    <div class="details-product">
                        <div class="details-thumd">
                            <div class="image-preview-container image-thick-box image_preview_container">
                                <img id="img_zoom" data-zoom-image="{{config('global.main_url')}}/public/Files/Products/{{$productdetail->product_thumbnail}}"
                                     src="{{config('global.main_url')}}/public/Files/Products/{{$productdetail->product_thumbnail}}" alt="img">
                                <a href="#" class="btn-zoom open_qv"><i class="fa fa-search" aria-hidden="true"></i></a>
                            </div>
                            <div class="product-preview image-small product_preview">
                                <div id="thumbnails" class="thumbnails_carousel owl-carousel" data-nav="true"
                                     data-autoplay="false" data-dots="false" data-loop="false" data-margin="10"
                                     data-responsive='{"0":{"items":3},"480":{"items":3},"600":{"items":3},"1000":{"items":3}}'>
                                     @foreach ($productdetail->images as $image)
                                        <a href="#" data-image="{{config('global.main_url')}}public/Files/Products-Images/{{$image->product_image_path}}"
                                       data-zoom-image="{{config('global.main_url')}}public/Files/Products-Images/{{$image->product_image_path}}" class="active">
                                        <img src="{{config('global.main_url')}}public/Files/Products-Images/{{$image->product_image_path}}"
                                             data-large-image="{{config('global.main_url')}}public/Files/Products-Images/{{$image->product_image_path}}" alt="img">
                                        </a>

                                     @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="details-infor">
                            <h1 class="product-title">
                                {{$productdetail->product_name}}
                            </h1>
                            <div class="stars-rating">
                                <div class="star-rating">
                                    <span class="star-5"></span>
                                </div>
                                <div class="count-star">
                                    (7)
                                </div>
                            </div>
                            <div class="availability">
                                availability:
                                <a href="#">in Stock</a>
                            </div>
                            <div class="price">
                                <span>{{$productdetail->pricing[0]->sale_price ?? 'Rate : ?'}}</span>
                            </div>
                            <div class="product-details-description">
                            {!! $productdetail->product_description !!}
                            </div>
                            <div class="variations">
                                <div class="attribute attribute_size">
                                    <div class="color-text text-attribute">
                                        Color:
                                    </div>
                                    <div class="list-size list-item">
                                    @foreach ($productdetail->attributes as $attribute)
                                            <a href="#" class="">{{$attribute->attribute_value}}</a>
                                    @endforeach
                                    </div>
                                </div>
                                <div class="attribute attribute_size">
                                    <div class="size-text text-attribute">
                                        Size:
                                    </div>
                                    <div class="list-size list-item">
                                        @foreach ($productdetail->variation as $variation)
                                            <a href="#" class="">{{$variation->variation_value}}</a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="group-button">
                                <div class="yith-wcwl-add-to-wishlist">
                                    <div class="yith-wcwl-add-button">
                                        <a href="#">Add to Wishlist</a>
                                    </div>
                                </div>
                                <div class="size-chart-wrapp">
                                    <div class="btn-size-chart">
                                        <a id="size_chart" href="assets/images/size-chart.jpg" class="fancybox">View
                                            Size Chart</a>
                                    </div>
                                </div>
                                <div class="quantity-add-to-cart">
                                    <form id="addToCart">
                                        @csrf
                                        <input type="hidden" id="product_id", name="product_id" value="{{ $productdetail->product_id }}">
                                        <button type="button" id="btnAddToCart" class="single_add_to_cart_button button" onclick="AddToCart()">Add to cart</button>
                                        <button type="button" class="single_add_to_cart_button button">Buy Now</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Product Details  --}}

                    <div class="tab-details-product">
                        <ul class="tab-link">
                            <li class="active">
                                <a data-toggle="tab" aria-expanded="true" href="#product-descriptions">Descriptions </a>
                            </li>
                            <li class="">
                                <a data-toggle="tab" aria-expanded="true" href="#information">Information </a>
                            </li>
                            <li class="">
                                <a data-toggle="tab" aria-expanded="true" href="#reviews">Reviews</a>
                            </li>
                        </ul>
                        <div class="tab-container">
                            <div id="product-descriptions" class="tab-panel active">
                                {!! $productdetail->product_description !!}
                            </div>
                            <div id="information" class="tab-panel">
                                <table class="table table-bordered">
                                    <tr>
                                        <td>Size</td>
                                        <td>
                                         @foreach ($productdetail->variation as $variation)
                                            {{$variation->variation_value}} /
                                        @endforeach
                                         </td>
                                    </tr>
                                    <tr>
                                        <td>Color</td>
                                        <td> @foreach ($productdetail->attributes as $attribute)
                                            {{$attribute->attribute_value}} /
                                    @endforeach</td>
                                    </tr>

                                </table>
                            </div>
                            <div id="reviews" class="tab-panel">
                                <div class="reviews-tab">
                                    <div class="comments">
                                        <h2 class="reviews-title">
                                            1 review for
                                            <span>Glorious Eau</span>
                                        </h2>
                                        <ol class="commentlist">
                                            <li class="conment">
                                                <div class="conment-container">
                                                    <a href="#" class="avatar">
                                                        <img src="assets/images/avartar.png" alt="img">
                                                    </a>
                                                    <div class="comment-text">
                                                        <div class="stars-rating">
                                                            <div class="star-rating">
                                                                <span class="star-5"></span>
                                                            </div>
                                                            <div class="count-star">
                                                                (1)
                                                            </div>
                                                        </div>
                                                        <p class="meta">
                                                            <strong class="author">Cobus Bester</strong>
                                                            <span>-</span>
                                                            <span class="time">June 7, 2013</span>
                                                        </p>
                                                        <div class="description">
                                                            <p>Simple and effective design. One of my favorites.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ol>
                                    </div>
                                    <div class="review_form_wrapper">
                                        <div class="review_form">
                                            <div class="comment-respond">
                                                <span class="comment-reply-title">Add a review </span>
                                                <form class="comment-form-review">
                                                    <p class="comment-notes">
                                                        <span class="email-notes">Your email address will not be published.</span>
                                                        Required fields are marked
                                                        <span class="required">*</span>
                                                    </p>
                                                    <div class="comment-form-rating">
                                                        <label>Your rating</label>
                                                        <p class="stars">
                                        						<span>
                                        							<a class="star-1" href="#"></a>
                                        							<a class="star-2" href="#"></a>
                                        							<a class="star-3" href="#"></a>
                                        							<a class="star-4" href="#"></a>
                                        							<a class="star-5" href="#"></a>
                                        						</span>
                                                        </p>
                                                    </div>
                                                    <p class="comment-form-comment">
                                                        <label>
                                                            Your review
                                                            <span class="required">*</span>
                                                        </label>
                                                        <textarea title="review" id="comment" name="comment" cols="45"
                                                                  rows="8"></textarea>
                                                    </p>
                                                    <p class="comment-form-author">
                                                        <label>
                                                            Name
                                                            <span class="">*</span>
                                                        </label>
                                                        <input title="author" id="author" name="author" type="text"
                                                               value="">
                                                    </p>
                                                    <p class="comment-form-email">
                                                        <label>
                                                            Email
                                                            <span class="">*</span>
                                                        </label>
                                                        <input title="email" id="email" name="email" type="email"
                                                               value="">
                                                    </p>
                                                    <p class="form-submit">
                                                        <input name="submit" type="submit" id="submit" class="submit"
                                                               value="Submit">
                                                    </p>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- You May also Like --}}
                    <div style="clear: left;"></div>
                    <h2 class="product-grid-title">You may also like</h2>
                    <ul class="row list-products auto-clear equal-container product-grid">
                        @foreach ($relatedproduct as $related)
                         <li class="product-item product-type-variable col-lg-3 col-md-4 col-sm-6 col-xs-6 col-ts-12 style-1">
                            <div class="product-inner equal-element">
                                <div class="product-top">
                                </div>
                                <div class="product-thumb">
                                    <div class="thumb-inner">
                                        <a href="{{url('ProductDtails')}}/{{$related->product_slug ?? ''}}">
                                            <img src="{{config('global.main_url')}}/public/Files/Products/{{$related->product_thumbnail}}" alt="img">
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
                                        <a href="#">{{$related->product_name}}</a>
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
                                                {{$related->pricing[0]->mrp_price ?? ''}}
                                            </del>
                                            <ins>
                                                {{$related->pricing[0]->sale_price ?? ''}}
                                            </ins>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                    {{-- You May also Like --}}


                </div>
            </div>
        </div>
    </div>
</div>
<script>
            function AddToCart() {

            $("#btnAddToCart").prop("disabled", true);
            $.post("{{ route('AddToCart') }}", $('#addToCart').serialize())
                .done((res) => {
                    $("#btnAddToCart").prop("disabled", false);
                    if (res.success) {

                      // Add the highlighted effect to the cart option
                           $('#cart-link').addClass('highlighted-cart');
                            $('html, body').animate({
                                scrollTop: $('#cart-count').offset().top
                            }, 500);

                            var cartCountElement = document.getElementById('cart-count');
                            var currentCartCount = parseInt(cartCountElement.innerText);
                            var newCartCount = currentCartCount + 1;
                            cartCountElement.innerText = newCartCount;
                      // Add flash effect to the cart icon
                      $('.flash-cart').addClass('flash-animation');
                      setTimeout(() => {
                              $('.flash-cart').removeClass('flash-animation');
                        }, 100);
                      setTimeout(() => {
                        location.reload();
                        }, 1000);

                    }else {
                        window.location.href = "{{ url('/Login') }}";
                    }
                    
                })
}



</script>
@endsection
