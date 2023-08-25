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
                            <h5>Add items to it now.</h5>
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