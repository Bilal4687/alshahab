@extends('Website.Layout')

@section('content')
    <style>
        hr {
            border-color: #000;
            /* Dark color */
            border-width: 1px;
            /* Increase border width for boldness */
        }
    </style>
    <div class="main-content main-content-checkout">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-trail breadcrumbs">
                        <ul class="trail-items breadcrumb">
                            <li class="trail-item trail-begin">
                                <a href="index.html">Home</a>
                            </li>
                            <li class="trail-item trail-end active" id="addressBar">
                                Checkout
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <h3 class="custom_blog_title">
                Checkout
            </h3>

            <div class="checkout-wrapp">
                <div class="shipping-address-form-wrapp">
                    <div class="shipping-address-form  checkout-form">
                        <div class="col-lg-8 row-col">
                            <div class="shipping-address">
                                <h3 class="title-form">
                                    Shipping Address
                                </h3>
                                <div class="new-address-card">
                                    <input type="hidden" id="customer_id" value="{{ $CustomerData->customer_id ?? '' }}">
                                    <input type="hidden" id="customer_address_id"
                                        value="{{ $CustomerData->customer_address_id ?? '' }}">

                                </div>
                                <div class="card addressCard">
                                    <input type="radio" checked>
                                    <div class="card-body">
                                        <a type="button" id="changeButton" class="button button-payment">Change</a>
                                        <input type="hidden" id="customer_id"
                                            value="{{ $CustomerData->customer_id ?? '' }}">
                                        <input type="hidden" id="customer_address_id"
                                            value="{{ $CustomerData->customer_address_id ?? '' }}">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h5 class="card-title">{{ $CustomerData->customer_name ?? '' }}
                                                {{ $CustomerData->customer_mobile ?? '' }}</h5>
                                        </div>

                                        <p class="card-text">
                                            {{ $CustomerData->customer_pincode ?? '' }}
                                            {{ $CustomerData->customer_locality ?? '' }}
                                            {{ $CustomerData->customer_city ?? '' }}
                                            {{ $CustomerData->customer_address ?? '' }}
                                        </p>

                                        <div id="Deliver_Here" style="display: none">
                                            <a type="button" onclick="DeliverHere()" class="button">Deliver Here</a>
                                            <a onclick="FormShow()" type="button" class="button">Edit</a>
                                        </div>

                                    </div>

                                </div>
                                <hr>

                                <div class="OldAddress">

                                    <form id="CheckOutDetail">
                                        @csrf
                                        <input type="radio" id="editAddressRadio" checked>
                                        <span style="padding: 5px; cursor: pointer;">Edit Address</span>
                                        <br>
                                        <br>
                                        <input type="hidden" value="{{ $Customer_id->customer_id }}" id="customer_id"
                                            name="customer_id">
                                        <input type="hidden" value="{{ $CustomerData->customer_address_id }}"
                                            id="customer_address_id" name="customer_address_id">
                                        <p class="form-row form-row-first">
                                            <label class="text">Name</label>
                                            <input type="text" name="customer_name" id="customer_name" class="input-text"
                                                value="{{ $CustomerData->customer_name ?? '' }}">
                                        </p>
                                        <p class="form-row form-row-last">
                                            <label class="text">10 Digit Mobile Number</label>
                                            <input name="customer_mobile" id="customer_mobile" type="text"
                                                class="input-text" value="{{ $CustomerData->customer_mobile ?? '' }}">
                                        </p>
                                        <p class="form-row form-row-first">
                                            <label class="text">Pincode</label>
                                            <input name="customer_pincode" id="customer_pincode" type="text"
                                                class="input-text" value="{{ $CustomerData->customer_pincode ?? '' }}">
                                        </p>
                                        <p class="form-row form-row-last ">
                                            <label class="text">Locality</label>
                                            <input name="customer_locality" id="customer_locality" type="text"
                                                class="input-text" value="{{ $CustomerData->customer_locality ?? '' }}">
                                        </p>
                                        <p class="form-row">
                                            <label class="text">Address</label>
                                            <textarea class="input-text" name="customer_address" id="customer_address" cols="2" rows="2">{{ trim($CustomerData->customer_address ?? '') }} </textarea>
                                        </p>
                                        <p class="form-row form-row-last ">
                                            <label class="text">City</label>
                                            <input name="customer_city" id="customer_city" type="text"
                                                class="input-text" value="{{ $CustomerData->customer_city ?? '' }}">
                                        </p>
                                        <p class="form-row form-row-last">
                                            <label class="text">State</label>
                                            <select title="state" name="state_id" id="state_id"
                                                data-placeholder="London" class="chosen-select" tabindex="1">
                                                <option>Select State</option>
                                                @foreach ($StateData as $state)
                                                    <option value="{{ $state->state_id }}"
                                                        {{ isset($CustomerData) && $CustomerData->state_id == $state->state_id ? 'selected' : '' }}>
                                                        {{ $state->name }}
                                                    </option>
                                                @endforeach

                                            </select>
                                        </p>
                                        <a type="button" class="button button-payment" id="oldPlaceOrderButton">Save &
                                            Next</a>
                                        <a type="button" class="button button-payment" style="display: none;">Save &
                                            Next</a>

                                        <button type="button" class="button" onclick="AddNewAddress()">Add New
                                            Address</button>
                                        <button type="button" class="button" style="display: none;"
                                            id="DeliveryAddress">Cancel</button>
                                    </form>
                                    <span id="error" style="display: none;" class="m-auto"></span>
                                </div>

                                <div class="NewAddress">

                                    <form id="CheckOutDetailNew">
                                        @csrf
                                        <input type="radio" checked><span style="padding: 5px;">Add New Address</span>
                                        <br>
                                        <br>

                                        <input type="hidden" value="{{ $Customer_id->customer_id }}" id="customer_id"
                                            name="customer_id">
                                        {{-- <input type="hidden" value="{{ $CustomerData->customer_address_id }}"
                                        id="customer_address_id" name="customer_address_id"> --}}
                                        <p class="form-row form-row-first">
                                            <label class="text">Name</label>
                                            <input type="text" name="customer_name" id="customer_name"
                                                class="input-text" value="{{ $CustomerData->customer_name ?? '' }}">
                                        </p>
                                        <p class="form-row form-row-last">
                                            <label class="text">10 Digit Mobile Number</label>
                                            <input name="customer_mobile" id="customer_mobile" type="text"
                                                class="input-text" value="">
                                        </p>
                                        <p class="form-row form-row-first">
                                            <label class="text">Pincode</label>
                                            <input name="customer_pincode" id="customer_pincode" type="text"
                                                class="input-text" value="">
                                        </p>
                                        <p class="form-row form-row-last ">
                                            <label class="text">Locality</label>
                                            <input name="customer_locality" id="customer_locality" type="text"
                                                class="input-text" value="">
                                        </p>
                                        <p class="form-row">
                                            <label class="text">Address</label>
                                            <textarea class="input-text" name="customer_address" id="customer_address" cols="2" rows="2"></textarea>
                                        </p>
                                        <p class="form-row form-row-last ">
                                            <label class="text">City</label>
                                            <input name="customer_city" id="customer_city" type="text"
                                                class="input-text" value="">
                                        </p>
                                        <p class="form-row form-row-last">
                                            <label class="text">State</label>
                                            <select title="state" name="state_id" id="state_id"
                                                data-placeholder="London" class="chosen-select" tabindex="1">
                                                <option>Select State</option>
                                                @foreach ($StateData as $state)
                                                    <option value="{{ $state->state_id }}"
                                                        {{ isset($CustomerData) && $CustomerData->state_id == $state->state_id ? 'selected' : '' }}>
                                                        {{ $state->name }}
                                                    </option>
                                                @endforeach

                                            </select>
                                        </p>
                                        <a type="button" class="button button-payment" style="display: none;">Save &
                                            Next</a>
                                        <a type="button" class="button button-payment" id="newPlaceOrderButton">Save &
                                            Next</a>
                                        <button type="button" class="button" style="display: none;"
                                            id="placeOrderButton">Add New Address</button>
                                        <button type="button" class="button" id="DeliveryAddress"
                                            onclick="OldAddress()">Cancel</button>
                                    </form>
                                    <span id="Newerror" style="display: none;" class="m-auto"></span>
                                </div>

                                <div class="NewOrderSummaryCard">

                                </div>

                                <div class="card OrderSummaryCard">
                                    <h3 class="title-form">
                                        Order Summary
                                        <a type="button" class="button button-payment" id="HideOrderConten">View Bag</a>
                                    </h3>
                                    <div class="card-body">
                                        <div class="row OrderSummary">
                                            @php
                                                $total = 0;
                                            @endphp
                                            @if (!session::get('Cart'))
                                                <div class="main-content-cart main-content col-sm-12">
                                                    <div class="page-main-content" style="text-align: center;">
                                                        <div class="shoppingcart-content">
                                                            <h1 style="">Your cart is empty!</h1>
                                                            <a href="{{ url('/') }}"
                                                                class="button btn-back-to-shipping">Back to
                                                                shipping</a>

                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="main-content-cart main-content col-sm-12">
                                                    <div class="page-main-content">
                                                        <div class="shoppingcart-content">
                                                            <form action="shoppingcart.html" class="cart-form">

                                                                <table class="shop_table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th class="product-remove"></th>
                                                                            <th class="product-thumbnail"></th>
                                                                            <th class="product-name"></th>
                                                                            <th class="product-price"></th>
                                                                            <th class="product-quantity"></th>
                                                                            <th class="product-subtotal"></th>
                                                                        </tr>
                                                                    </thead>

                                                                    <tbody>

                                                                        @if (session::get('Cart'))
                                                                            @foreach (session::get('Cart') as $id => $items)
                                                                                <tr class="cart_item"
                                                                                    data-id="{{ $id }}">
                                                                                    <td class="product-remove">
                                                                                        <a class="remove"></a>
                                                                                    </td>
                                                                                    <td class="product-thumbnail">
                                                                                        <a href="#">
                                                                                            <img src="{{ asset('public/Files/Products/' . $items['product_image' ?? '']) }}"
                                                                                                alt="img"
                                                                                                class="attachment-shop_thumbnail size-shop_thumbnail wp-post-image">
                                                                                        </a>
                                                                                    </td>
                                                                                    <td class="product-name"
                                                                                        data-title="Product">
                                                                                        <a
                                                                                            class="title">{{ $items['product_name' ?? ''] }}</a>
                                                                                        <span
                                                                                            class="attributes-select attributes-color">
                                                                                            {{ $items['product_variation' ?? ''] }}
                                                                                        </span>
                                                                                        <span
                                                                                            class="attributes-select attributes-size">
                                                                                            {{ $items['product_attribute' ?? ''] }}
                                                                                        </span>
                                                                                        <div>
                                                                                            <span
                                                                                                class="abortedwoocommerce-Price-amount amount">
                                                                                                <span
                                                                                                    class="woocommerce-Price-currencySymbol">
                                                                                                    {{ $items['product_sale_price' ?? ''] }}
                                                                                                </span>
                                                                                            </span>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td class="product-quantity"
                                                                                        data-title="Quantity">
                                                                                        <div class="quantity">
                                                                                            <div class="control">
                                                                                                <a class="btn-number qtyminus quantity-minus"
                                                                                                    data-product-id="{{ $items['product_id'] }}">-</a>
                                                                                                <input type="number"
                                                                                                    value="{{ $items['quantity'] }}"
                                                                                                    class="input-qty qty quantity cart_update"
                                                                                                    id="quantityInput_{{ $items['product_id'] }}"
                                                                                                    title="Qty">
                                                                                                <a class="btn-number qtyplus quantity-plus"
                                                                                                    data-product-id="{{ $items['product_id'] }}">+</a>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>


                                                                                </tr>
                                                                            @endforeach
                                                                        @endif

                                                                        <tr>
                                                                            <td class="actions">

                                                                                <div class="coupon">
                                                                                    <label class="coupon_code">Coupon
                                                                                        Code:</label>
                                                                                    <input type="text"
                                                                                        class="input-text"
                                                                                        placeholder="Promotion code here">
                                                                                    <a href="#" class="button"></a>
                                                                                </div>
                                                                                <div class="order-total">
                                                                                    <span class="title">
                                                                                        Total Price:
                                                                                    </span>
                                                                                    @php
                                                                                        $total = 0;
                                                                                    @endphp
                                                                                    @foreach ((array) session::get('Cart') as $id => $details)
                                                                                        @php
                                                                                            $total += $details['product_sale_price'] * $details['quantity'];
                                                                                        @endphp
                                                                                    @endforeach
                                                                                    {{ $total }}
                                                                                </div>
                                                                                <a type="button"
                                                                                    class="button button-payment"
                                                                                    id="Continue">Continue</a>

                                                                            <td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>

                                                            </form>

                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                        </div>

                                    </div>
                                </div>

                                <div class="card">

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12 main-content-cart main-content col-sm-12">
                                                <div class="page-main-content">
                                                    <div class="shoppingcart-content">
                                                        <h3 class="title-form">
                                                            Payment Method
                                                            <a type="button" class="button button-payment"
                                                                id="PaymentOptionBtn">Payment Option</a>
                                                        </h3>
                                                        <div class="payment-method PaymentOption">
                                                            <div class="group-button-payment">
                                                                <a href="#" class="button btn-credit-card">Credit
                                                                    Card</a>
                                                                <a href="#" class="button btn-paypal">paypal</a>
                                                            </div>
                                                            <p class="form-row form-row-card-number">
                                                                <label class="text">Card number</label>
                                                                <input type="text" class="input-text"
                                                                    placeholder="xxx - xxx - xxx - xxx">
                                                            </p>
                                                            <p class="form-row forn-row-col forn-row-col-1">
                                                                <label class="text">Month</label>
                                                                <select title="month" data-placeholder="01"
                                                                    class="chosen-select" tabindex="1">
                                                                    <option value="thang01">01</option>
                                                                    <option value="thang02">02</option>
                                                                    <option value="thang03">03</option>
                                                                    <option value="thang04">04</option>
                                                                    <option value="thang05">05</option>
                                                                    <option value="thang06">06</option>
                                                                    <option value="thang07">07</option>
                                                                    <option value="thang08">08</option>
                                                                    <option value="thang09">09</option>
                                                                    <option value="thang10">10</option>
                                                                    <option value="thang11">11</option>
                                                                    <option value="thang12">12</option>
                                                                </select>
                                                            </p>
                                                            <p class="form-row forn-row-col forn-row-col-2">
                                                                <label class="text">Year</label>
                                                                <select title="Year" data-placeholder="2017"
                                                                    class="chosen-select" tabindex="1">
                                                                    <option value="nam2010">2010</option>
                                                                    <option value="nam2011">2011</option>
                                                                    <option value="nam2012">2012</option>
                                                                    <option value="nam2013">2013</option>
                                                                    <option value="nam2014">2014</option>
                                                                    <option value="nam2015">2015</option>
                                                                    <option value="nam2016">2016</option>
                                                                    <option value="nam2017">2017</option>
                                                                    <option value="nam2018">2018</option>
                                                                    <option value="nam2020">2020</option>
                                                                </select>
                                                            </p>
                                                            <p class="form-row forn-row-col forn-row-col-3">
                                                                <label class="text">CVV</label>
                                                                <select title="CVV" data-placeholder="238"
                                                                    class="chosen-select" tabindex="1">
                                                                    <option value="cvv1">238</option>
                                                                    <option value="cvv2">354</option>
                                                                    <option value="cvv3">681</option>
                                                                    <option value="cvv4">254</option>
                                                                    <option value="cvv5">687</option>
                                                                    <option value="cvv6">123</option>
                                                                    <option value="cvv7">951</option>
                                                                    <option value="cvv8">852</option>
                                                                    <option value="cvv9">753</option>
                                                                    <option value="vcc10">963</option>
                                                                </select>
                                                            </p>

                                                            <div class="button-control">
                                                                <a href="{{ url('/') }}"
                                                                    class="button btn-back-to-shipping">Back to
                                                                    shipping</a>
                                                                <a class="razorpay_btn button button-payment btn-pay-now">Pay
                                                                    now</a>
                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="NewYourOrderCard">

                        </div>

                        <div class="col-lg-4 row-col YourOrderCard">
                            <div class="your-order">
                                <h3 class="title-form">
                                    Your Order
                                </h3>
                                <ul class="list-product-order">
                                    @if (Session()->get('Cart'))
                                        @foreach (Session()->get('Cart') as $id => $items)
                                            <li class="product-item-order">
                                                <div class="product-thumb">
                                                    <a href="#">
                                                        <img style="width:100px; height:100px"
                                                            src="{{ asset('public/Files/Products/' . $items['product_image' ?? '']) }}"
                                                            alt="img">
                                                    </a>
                                                </div>
                                                <div class="product-order-inner">
                                                    <h5 class="product-name">
                                                        <a href="#">{{ $items['product_name' ?? ''] }}</a>
                                                    </h5>
                                                    <span
                                                        class="attributes-select attributes-color">{{ $items['product_attribute' ?? ''] }}</span>
                                                    <span
                                                        class="attributes-select attributes-size">{{ $items['product_variation' ?? ''] }}</span>
                                                    <div class="price">
                                                        {{ $items['product_sale_price'] }}
                                                        <span class="count">(x {{ $items['quantity' ?? ''] }})</span>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                        @else
                                        <div class="main-content-cart main-content col-sm-12">
                                            <div class="page-main-content" style="text-align: center;">
                                                <div class="shoppingcart-content">
                                                    <h1 style="">Your cart is empty!</h1>
                                                    <a href="{{ url('/') }}"
                                                        class="button btn-back-to-shipping">Back to
                                                        shipping</a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </ul>

                                @if (Session()->get('Cart'))
                                    <div class="order-total">
                                        <span class="title">
                                            Total Price:
                                            @php
                                                $total = 0;
                                            @endphp
                                            @foreach (Session()->get('Cart') as $id => $details)
                                                @php
                                                    $total += $details['product_sale_price'] * $details['quantity'];
                                                @endphp
                                            @endforeach
                                            {{ $total }}
                                        </span>

                                    </div>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('.razorpay_btn').click(function(e) {
            var Amount = {{ $total }};
            e.preventDefault();
            var Cid = $('#customer_id').val();
            var Caid = $('#customer_address_id').val();

            $.get("{{ route('RazorPayPayment') }}", {
                _token: '{{ csrf_token() }}',
                GrandTotal: Amount,
                Customer_id: Cid,
                Customer_address_id: Caid
            }, function(res) {
                if (res['success']) {

                } else {
                    alertmsg(res['message'], "warning");
                    return false;
                }
            });
        });


        $('#oldPlaceOrderButton').click(function() {

            var customerId = $('.new-address-card #customer_id').val();
            var customerAddressId = $('.new-address-card #customer_address_id').val();

            $.post("{{ route('CheckOutDetailUpdate') }}", $("#CheckOutDetail").serialize())
                .done((res) => {
                    if (res.success) {
                        $('.OldAddress').slideToggle(800);

                        setTimeout(() => {
                            $('.OrderSummary').show();
                        }, 1500);

                        $.get("{{ route('AddressCardContent') }}?_=" + new Date().getTime(), function(data) {

                            $('.new-address-card').html(data.data);


                            $('.new-address-card #customer_id').val(customerId);
                            $('.new-address-card #customer_address_id').val(customerAddressId);
                        });

                        $('.addressCard').html('');
                        $('html, body').animate({
                            scrollTop: $('#addressBar').offset().top
                        }, 1000);
                    } else if (res.validate) {
                        alertmsg(res.message, "warning")
                    } else {
                        alertmsg(res.message, "danger")
                    }
                })
        });

        $('#newPlaceOrderButton').click(function() {

            var customerId = $('.new-address-card #customer_id').val();
            var customerAddressId = $('.new-address-card #customer_address_id').val();

            $.post("{{ route('CheckOutDetail') }}", $("#CheckOutDetailNew").serialize())
                .done((res) => {
                    if (res.success) {
                        $('.NewAddress').slideToggle(800);

                        setTimeout(() => {
                            $('.OrderSummary').show();
                        }, 1500);

                        $.get("{{ route('AddressCardContent') }}?_=" + new Date().getTime(), function(data) {

                            $('.new-address-card').html(data.data);
                            $('.new-address-card #customer_id').val(customerId);
                            $('.new-address-card #customer_address_id').val(customerAddressId);
                        });

                        $('.addressCard').html('');
                        $('html, body').animate({
                            scrollTop: $('#addressBar').offset().top
                        }, 1000);
                    } else if (res.validate) {
                        alertmsg(res.message, "warning")
                    } else {
                        alertmsg(res.message, "danger")
                    }
                })
        });
$(document).on("click", ".product-remove", function(e) {
    e.preventDefault();
    var ele = $(this);
    Swal.fire({
        title: "Remove Item",
        text: "Are you sure you want to remove this item?",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Remove",
        cancelButtonText: "Cancel",
        customClass: {
            popup: "swal-large",
            title: "swal-large swal-title",
            content: "swal-large swal-text",
        },
    }).then((willDelete) => {
        if (willDelete.isConfirmed) {
            $.get(
                "{{ route('RemoveFromCart') }}",
                {
                    _token: "{{ csrf_token() }}",
                    id: ele.parents("tr").attr("data-id"),
                },
                function(res) {
                    if (res["success"]) {
                        $.get(
                            "{{ route('ViewBagContent') }}?_=" +
                                new Date().getTime(),
                            function(data) {
                                $(".NewOrderSummaryCard").html(data.data);
                            }
                        );

                        $.get(
                            "{{ route('YourOrderContent') }}?_=" +
                                new Date().getTime(),
                            function(data) {
                                $(".NewYourOrderCard").html(data.data);
                            }
                        );

                        $(".OrderSummaryCard").html("");
                        $(".YourOrderCard").html("");

                        Swal.fire({
                            title: "Successful...",
                            text: res.message,
                            icon: "success",
                            customClass: {
                                popup: "swal-large",
                                title: "swal-large swal-title",
                                content: "swal-large swal-text",
                            },
                        });
                    }
                }
            );
        }
    });
});
        $(document).ready(function() {

            $('.NewAddress').hide();
            $('.OldAddress').hide();
            $('.OrderSummary').hide();
            $('.PaymentOption').hide();

            $(".qtyplus").click(function(e) {
                $(".qtyplus").prop("disabled", true);
                e.preventDefault();

                var productID = $(this).data("product-id");
                var quantityInput = $("#quantityInput_" + productID);
                var currentQuantity = parseInt(quantityInput.val());

                // Increment the current quantity
                quantityInput.val(currentQuantity + 1);

                updateCart(productID, quantityInput.val());
            });

            $(".qtyminus").click(function(e) {
                $(".qtyminus").prop("disabled", true);
                e.preventDefault();

                var productID = $(this).data("product-id");
                var quantityInput = $("#quantityInput_" + productID);
                var currentQuantity = parseInt(quantityInput.val());

                if (currentQuantity > 1) {
                    // Decrement the current quantity
                    quantityInput.val(currentQuantity - 1);
                    updateCart(productID, quantityInput.val());
                }
            });

            $(".quantity").on("change", ".qty", function() {
                $(".quantity").prop("disabled", true);
                var productID = $(this).attr("id").split("_")[1];
                updateCart(productID, $(this).val());
            });

            function updateCart(productID, quantityValue) {
                $.ajax({
                    url: "{{ route('UpdateCart') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: productID,
                        quantity: quantityValue
                    },
                    success: function(response) {
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.log("Error updating cart:", error);
                    }
                });
            }
        });




        function alertmsg4New(msg, type) {

            $("#Newerror").removeClass().html('').show();
            $("#Newerror").addClass(`alert alert-${type} text-center`).html(msg);
            $("#Newerror").fadeOut(3000);

        }

        $("#changeButton").click(function() {
            $("#Deliver_Here").slideToggle();
            $("#EditBtn").slideToggle();
        });
        $("#Continue").click(function() {
            $('.OrderSummary').slideToggle(400);
        });

        $("#HideOrderConten").click(function() {
            $('.OrderSummary').slideToggle(400);
        });

        function FormShow() {
            $('#addAddressRadio').prop('checked', false)
            // Uncheck the input field in the current card
            $('.addressCard input[type="radio"]').prop('checked', false);

            // Check the input field in the OldAddress form
            $('.OldAddress input[type="radio"]').prop('checked', true);


            // Show the OldAddress form
            $('.OldAddress').show();

            $('#Deliver_Here').hide();


        }

        function AddNewAddress() {
            $('#CheckOutDetail')[0].reset();
            $('.OldAddress').hide();
            $('.NewAddress').show();

            // Hide old "Place Order" button, show new one
            $("#oldPlaceOrderButton").hide();
            $("#newPlaceOrderButton").show();
            $("#DeliveryAddress").show();
        }

        $('#PaymentOptionBtn').click(function(e) {

            $('.PaymentOption').slideToggle(400);

        });

        function OldAddress() {
            $('.OldAddress').show();
            $("#oldPlaceOrderButton").show();
            $('.NewAddress').hide();
            $("#DeliveryAddress").hide();
            $("#newPlaceOrderButton").hide();
        }

        function DeliverHere() {
            $.post("{{ route('CheckOutDetailUpdate') }}", $("#CheckOutDetail").serialize())
                .done((res) => {
                    if (res.success) {
                        window.location.href = '{{ url('/PlaceOrder') }}';
                    } else if (res.validate) {
                        alertmsg(res.message, "warning")
                    } else {
                        alertmsg(res.message, "danger")
                    }
                })
        }

        function toggleAddress(option) {
            if (option === 'edit') {
                $('#editAddressRadio').prop('checked', true)
                $('#addAddressRadio').prop('checked', false)
            } else if (option === 'add') {

                $('#editAddressRadio').prop('checked', false)
                $('#addAddressRadio').prop('checked', true)
            }
        }
    </script>
@endsection
