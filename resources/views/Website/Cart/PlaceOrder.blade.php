@extends('Website.Layout')

@section('content')

<div class="main-content main-content-checkout">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-trail breadcrumbs">
                    <ul class="trail-items breadcrumb">
                        <li class="trail-item trail-begin">
                            <a href="index.html">Home</a>
                        </li>
                        <li class="trail-item trail-end active">
                            Checkout
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <h3 class="custom_blog_title">
            Payment Option
        </h3>
        <div class="checkout-wrapp">
            <div class="payment-method-wrapp">
                <div class="payment-method-form checkout-form">
                    <div class="row-col-1 row-col">
                        <div class="payment-method">
                            <h3 class="title-form">
                                Payment Method
                            </h3>
                            <div class="group-button-payment">
                                <a href="#" class="button btn-credit-card">Credit Card</a>
                                <a href="#" class="button btn-paypal">paypal</a>
                            </div>
                            <p class="form-row form-row-card-number">
                                <label class="text">Card number</label>
                                <input type="text" class="input-text" placeholder="xxx - xxx - xxx - xxx">
                            </p>
                            <p class="form-row forn-row-col forn-row-col-1">
                                <label class="text">Month</label>
                                <select title="month" data-placeholder="01" class="chosen-select" tabindex="1">
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
                                <select title="Year" data-placeholder="2017" class="chosen-select" tabindex="1">
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
                                <select title="CVV" data-placeholder="238" class="chosen-select" tabindex="1">
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
                        </div>
                    </div>
                    <div class="row-col-2 row-col">
                        <div class="your-order">
                            <h3 class="title-form">
                                Your Order
                            </h3>
                            <ul class="list-product-order">
                                @if(Session()->get('Cart'))
                                @foreach(Session()->get('Cart')  as $id => $items)
                                <li class="product-item-order">
                                    <div class="product-thumb">
                                        <a href="#">
                                            <img style="width:100px; height:100px" src="{{ asset('public/Files/Products/' . $items['product_image' ?? '']) }}" alt="img">
                                        </a>
                                    </div>
                                    <div class="product-order-inner">
                                        <h5 class="product-name">
                                            <a href="#">{{ $items['product_name' ?? ''] }}</a>
                                        </h5>
                                        <span class="attributes-select attributes-color">{{ $items['product_attribute' ?? ''] }}</span>
                                        <span class="attributes-select attributes-size">{{ $items['product_variation' ?? ''] }}</span>
                                        <div class="price">
                                            {{ $items['product_sale_price'] }}
                                            <span class="count">(x {{ $items['quantity' ?? ''] }})</span>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                                @endif

                            </ul>

                            @if(Session()->get('Cart'))
                            <div class="order-total">
									<span class="title">
										Total Price:
                                         @php
                                            $total = 0;
                                         @endphp
                                           @foreach(Session()->get('Cart') as $id => $details)
                                           @php
                                              $total += $details['product_sale_price'] * $details['quantity']
                                           @endphp
                                          @endforeach
                                          {{ $total }}
									</span>

                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="button-control">
                    <a href="#" class="button btn-back-to-shipping">Back to shipping</a>
                    <a  class="razorpay_btn button btn-pay-now">Pay now</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('.razorpay_btn').click(function (e) {
        var Amount = {{ $total }};
        e.preventDefault();

        $.get("{{ route('RazorPayPayment') }}", {
            _token : '{{ csrf_token() }}',
            GrandTotal : Amount
        }, function(res) {
            if (res['success']) {
                window.location.href = "/CartDetail";
                // location.reload();
                }
                else{
                console.log(res.GrandTotal);
                        return false;
                }
            });
        });
</script>
@endsection
