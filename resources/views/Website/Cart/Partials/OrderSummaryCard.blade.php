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
            @if (!Session::get('Cart'))
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

                                        @if (Session::get('Cart'))
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