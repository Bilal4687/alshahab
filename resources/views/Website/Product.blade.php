@extends('website.layout')
@section('content')

<style>
    .label-container {
        display: flex;
        justify-content: space-between;
        align-items: center;

    }

    .arrow {
        border: solid grey;
        border-width: 0 2px 2px 0;
        display: inline-block;
        padding: 3px;
        margin-top: 0px;
        transform: rotate(-45deg);
        -webkit-transform: rotate(-45deg);
    }

    .right {
        transform: rotate(-45deg);
        -webkit-transform: rotate(-45deg);

    }

    .down {
        transform: rotate(45deg);
        -webkit-transform: rotate(45deg);
    }

    .demo a:hover {
        color: #2c2c2c;
    }


</style>


<div class="main-content main-content-product left-sidebar" style="margin-top: 50px">
    <div class="container">
        <div class="row ProductDetail">
            <div class="content-area shop-grid-content full-width col-lg-9 col-md-9 col-sm-9 col-xs-9">
                <div class="site-main">

                    <div class="shop-top-control" style="background: white;border: none;margin-top: 10px;margin-bottom: auto;">
                        <div class="row">
                            {{-- <div class="col-md-12">
                                <div style="border: 1px solid black; width: 100%; height: 20px">
                                    brand name
                                </div>
                            </div> --}}
                                <div class="col-md-8">
                                    <div>
                                        <h2>
                                            @if(request()->has('brand'))
                                                {{ $firstProductBrand }}
                                            @elseif($firstProductCategory)
                                                {{ $firstProductCategory }}
                                            @else
                                                Default Category Name
                                            @endif
                                        </h2>
                                    </div>
                                </div>


                                                        <div class="col-md-4">
                                <div style="margin-top: 8px">
                                    <form class="filter-choice select-form">
                                        <span class="title">Sort by</span>
                                        <select title="sort-by" data-placeholder="Price: Low to High"
                                            class="chosen-select">
                                            <option value="1">Price: Low to High</option>
                                            <option value="2">Sort by popularity</option>
                                            <option value="3">Sort by average rating</option>
                                            <option value="4">Sort by newness</option>
                                            <option value="5">Sort by price: low to high</option>
                                        </select>
                                    </form>
                                </div>
                            </div>
                        </div>


                    </div>
                    <ul class="row list-products auto-clear equal-container product-grid" id="GridView">
                        @foreach ($products as $product)
                        <li
                            class="product-item product-type-variable col-lg-4 col-md-4 col-sm-6 col-xs-6 col-ts-12 style-1">
                            <div class="product-inner equal-element">


                                <div class="product-top">
                                </div>
                                <div class="product-thumb">
                                    <div class="thumb-inner">
                                        <a href="{{ url('product') }}/{{ $product->product_slug }}">
                                            <img src="{{config('global.main_url')}}/public/Files/Products/{{$product->product_thumbnail}}"
                                                alt="img" style="width: 250px; height: 250px; align-items: center">

                                        </a>
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
                                                {{$product->mrp_price ?? ''}}
                                            </del>
                                            <ins class="h5" style="color: #ab8e66;">
                                                <strong>₹{{$product->sale_price ?? ''}}</strong>
                                            </ins>


                                        </div>
                                        <div style="margin-top: 10px">
                                            <form id="addToCart">
                                                @csrf
                                                <input type="hidden" id="product_id" , name="product_id"
                                                    value="{{ $product->product_id }}">
                                                <button class="btn-custom btn"><i class="fa fa-heart"></i></button>
                                                <button type="button" class="btn-custom btn" id="btnAddToCart"
                                                    class="single_add_to_cart_button button" onclick="AddToCart()">Add
                                                    to cart</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>

            </div>



            <div class="sidebar col-lg-3 col-md-3 col-sm-12 col-xs-12">

                <div class="breadcrumb-trail breadcrumbs">
                    <ul class="trail-items breadcrumb">
                        <li class="trail-item trail-begin">
                            <a href="index.html">Home</a>
                        </li>
                        <li class="trail-item trail-end active">
                            Grid Products
                        </li>
                    </ul>
                </div>
                <div class="wrapper-sidebar shop-sidebar">
                    <div class="widget woof_Widget">
                        <div class="widget widget-categories">
                            <h3 class="widgettitle">Categories</h3>
                            @foreach($categoriesData as $category)
                                @if($category->parent_id === 0)
                                    @php
                                        $childCount = collect($categories)->where('parent_id', $category->category_id)->count();
                                    @endphp

                                    <ul class="list-categories">
                                        <li>
                                            <span class="maintainListState label-container">
                                                <a>{{ $category->category_name }} ({{  $childCount }})</a>
                                                <i class="arrow right"></i>
                                            </span>

                                            <ul class="submenu childList" style="margin-left: 10px; display: none">
                                                @foreach ($categories as $subcategory)
                                                    @if($subcategory->parent_id == $category->category_id)
                                                        @php
                                                            $hasGrandchildren = collect($categories)->where('parent_id', $subcategory->category_id)->isNotEmpty();
                                                        @endphp

                                                        @if ($hasGrandchildren)
                                                            @php
                                                                $SubCount = collect($categories)->where('parent_id', $subcategory->category_id)->count();
                                                             @endphp

                                                            <li>
                                                                <span class="maintainListState label-container">
                                                                    <a href="{{ url('result', [$subcategory->slug]) }}">
                                                                        {{ $subcategory->category_name }} ({{$SubCount }})
                                                                    </a><i class="arrow right"></i>
                                                                </span>
                                                                <ul class="submenu childList" style="margin-left: 10px; display: none">
                                                                    @foreach ($categories as $grandchild)
                                                                        @if($grandchild->parent_id == $subcategory->category_id)
                                                                            <li class="menu-item">
                                                                                <a href="{{ url('result', [$grandchild->slug]) }}">
                                                                                    {{ $grandchild->category_name }}
                                                                                </a>
                                                                            </li>
                                                                        @endif
                                                                    @endforeach
                                                                </ul>
                                                            </li>
                                                        @else
                                                            <li class="menu-item">
                                                                <a href="{{ url('result', [$subcategory->slug]) }}" >
                                                                    {{ $subcategory->category_name }}
                                                                </a>
                                                            </li>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </ul>

                                        </li>
                                    </ul>
                                @endif
                            @endforeach
                        </div>
                            <div class="widget widget-brand">
                                <h3 class="widgettitle">Brand</h3>
                                <ul class="list-brand">
                                    @foreach($brands as $item)
                                        <li class="label-container">
                                            <a href="{{ url('result/' . $item->brand_id . '?brand=' . str_replace(' ', '-', $item->brand_name)) }}">
                                                {{ $item->brand_name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>




                            </div>
                        {{-- <div class="widget widget_filter_price">
                            <h4 class="widgettitle">
                                Price
                            </h4>
                            <div class="price-slider-wrapper">
                                <div data-label-reasult="Range:" data-min="0" data-max="3000" data-unit="$"
                                    class="slider-range-price " data-value-min="0" data-value-max="1000">
                                </div>
                                <div class="price-slider-amount">
                                    <span class="from">$45</span>
                                    <span class="to">$215</span>
                                </div>
                            </div>
                        </div> --}}

                        {{-- <div class="widget widget_filter_size">
                            <h4 class="widgettitle">Size</h4>
                            <ul class="list-brand">
                                <li>
                                    <input id="cb13" type="checkbox">
                                    <label for="cb13" class="label-text">14.0 mm</label>
                                </li>
                                <li>
                                    <input id="cb14" type="checkbox">
                                    <label for="cb14" class="label-text">14.4 mm</label>
                                </li>
                                <li>
                                    <input id="cb15" type="checkbox">
                                    <label for="cb15" class="label-text">14.8 mm</label>
                                </li>
                                <li>
                                    <input id="cb16" type="checkbox">
                                    <label for="cb16" class="label-text">15.2 mm</label>
                                </li>
                                <li>
                                    <input id="cb17" type="checkbox">
                                    <label for="cb17" class="label-text">15.6 mm</label>
                                </li>
                                <li>
                                    <input id="cb18" type="checkbox">
                                    <label for="cb18" class="label-text">16.0 mm</label>
                                </li>
                            </ul>
                        </div>
                        <div class="widget widget-color">
                            <h4 class="widgettitle">
                                Color
                            </h4>
                            <div class="list-color">
                                <a href="#" class="color1"></a>
                                <a href="#" class="color2 "></a>
                                <a href="#" class="color3 active"></a>
                                <a href="#" class="color4"></a>
                                <a href="#" class="color5"></a>
                                <a href="#" class="color6"></a>
                                <a href="#" class="color7"></a>
                            </div>
                        </div>
                        <div class="widget widget-tags">
                            <h3 class="widgettitle">
                                Popular Tags
                            </h3>
                            <ul class="tagcloud">
                                <li class="tag-cloud-link">
                                    <a href="#">Office</a>
                                </li>
                                <li class="tag-cloud-link">
                                    <a href="#">Accents</a>
                                </li>
                                <li class="tag-cloud-link">
                                    <a href="#">Flowering</a>
                                </li>
                                <li class="tag-cloud-link active">
                                    <a href="#">Accessories</a>
                                </li>
                                <li class="tag-cloud-link">
                                    <a href="#">Hot</a>
                                </li>
                                <li class="tag-cloud-link">
                                    <a href="#">Tables</a>
                                </li>
                                <li class="tag-cloud-link">
                                    <a href="#">Dining</a>
                                </li>
                            </ul>
                        </div> --}}
                    </div>
                    <div class="widget newsletter-widget">
                        <div class="newsletter-form-wrap ">
                            <h3 class="title">Subscribe to Our Newsletter</h3>
                            <div class="subtitle">
                                More special Deals, Events & Promotions
                            </div>
                            <input type="email" class="email" placeholder="Your email letter">
                            <button type="submit" class="button submit-newsletter">Subscribe</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    //       $('#maintainListState').click(function (e) {
//         alert('hello');
//     console.log('Clicked!');
//     $('.arrow').toggleClass('right down');
//     e.preventDefault();
//     $('#childList').slideToggle();
// });
//     $('li a').click(function(e) {
//   e.preventDefault();
//   alert('Test');
// });


// $('.down').click(function (e) {
//     $(this).removeClass('down').addClass('right');
//     e.preventDefault();
//     $('#childList').css('display', 'none').slideDown();
// });

    $(document).ready(function() {
        $('.maintainListState').click(function (e) {
            console.log('Clicked!');
            $(this).find('.arrow').toggleClass('right down');
            e.preventDefault();
            $(this).siblings('.childList').slideToggle();
        });

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
