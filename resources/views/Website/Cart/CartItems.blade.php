@extends('Website.Layout')

@section('content')
<style>
    /* Custom Swal modal styles */
    .swal-large {
    width: 500px; /* Adjust the width as needed */
    max-width: 90%;
}

.swal-large .swal-title {
    font-size: 20px; /* Adjust the title font size */
}

.swal-large .swal-text {
    font-size: 18px; /* Adjust the text font size */
}

</style>
<div class="site-content">
    <main class="site-main  main-container no-sidebar">
        <div class="container">
            <div class="breadcrumb-trail breadcrumbs">
                <ul class="trail-items breadcrumb">
                    <li class="trail-item trail-begin">
                        <a href="">
								<span>
									Home
								</span>
                        </a>
                    </li>
                    <li class="trail-item trail-end active">
							<span>
								Shopping Cart
							</span>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="main-content-cart main-content col-sm-12">
                    <h3 class="custom_blog_title">
                        Shopping Cart
                    </h3>
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
                                        @php
                                            $cartItems = \App\Helpers\CartHelper::getCart();

                                        @endphp

                                        @if(!empty($cartItems) && is_array($cartItems))
                                            {{-- <p>{{ $cartItems }}</p> --}}
                                            @foreach($cartItems as $items)

                                                <tr class="cart_item" data-id="{{ $items['product_id'] }}" data-price-id="{{ $items['products__pricing']['product_price_id'] }}">
                                                    <td class="product-remove">
                                                        <a class="remove"></a>
                                                    </td>
                                                    <td class="product-thumbnail">
                                                        <a href="#">
                                                            <img src="{{ asset('public/Files/Products/' . ($items['product_thumbnail'] ?? '')) }}" alt="img" class="attachment-shop_thumbnail size-shop_thumbnail wp-post-image">
                                                        </a>
                                                    </td>
                                                    <td class="product-name" data-title="Product">
                                                        <a href="#" class="title">{{ $items['product_name'] ?? '' }}</a>
                                                        <span class="attributes-select attributes-color" data-variation-id="{{ $items['products__variations']['product_variation_id'] ?? '' }}">{{ $items['products__variations']['variation_value'] ?? '' }}</span>
                                                        <span class="attributes-select attributes-size" data-attribute-id="{{ $items['products__attributes']['product_attribute_id'] ?? '' }}">{{ $items['products__attributes']['attribute_value'] ?? '' }}</span>
                                                    </td>
                                                    <td class="product-quantity" data-title="Quantity">
                                                        <div class="quantity">
                                                            <div class="control" style="border: 1px solid #ebe6e6;">
                                                                <a class="btn-number qtyminus quantity-minus" data-product-id="{{ $items['product_id'] }}" style="border: 1px solid #ebe6e6;"><i class="fa fa-minus" style="font-size: 15px; margin-bottom: 10px"></i></a>
                                                                 <input type="number" value="{{ $items['quantity'] }}" min="1" class="input-qty qty quantity cart_update" id="quantityInput_{{ $items['product_id'] }}_{{ $items['products__pricing']['product_price_id'] }}"  title="Qty">

                                                                <a class="btn-number qtyplus quantity-plus" data-product-id="{{ $items['product_id'] }}" style="border: 1px solid #ebe6e6;"><i class="fa fa-plus" style="font-size: 15px; margin-bottom: 10px"></i></a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="product-price" data-title="Price">
                                                        <span class="woocommerce-Price-amount amount">
                                                            <span class="woocommerce-Price-currencySymbol" data-price-id="{{ $items['products__pricing']['product_price_id'] ?? '' }}">
                                                                {{ $items['products__pricing']['sale_price'] ?? '' }}
                                                            </span>
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="6">
                                                    <div class="main-content-cart main-content col-sm-12">
                                                        <div class="page-main-content" style="text-align: center;">
                                                            <div class="shoppingcart-content">
                                                                <h1>Your cart is empty!</h1>
                                                                <a href="{{ url('/') }}" style="color:white;" class="button btn-back-to-shipping">Back to shipping</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif

                                        <tr>
                                            <td class="actions">
                                                <div class="coupon">
                                                    <label class="coupon_code">Coupon Code:</label>
                                                    <input type="text" class="input-text" placeholder="Promotion code here">
                                                    <a href="#" class="button"></a>
                                                </div>
                                                <div class="order-total">
                                                    <span class="title">
                                                        Total Price:
                                                    </span>
                                                    @php
                                                        $total = 0;
                                                    @endphp
                                                    @foreach($cartItems as $id => $details)
                                                        @php
                                                            $total += $details['products__pricing']['sale_price'] * $details['quantity'];
                                                        @endphp
                                                    @endforeach
                                                    {{ $total }}
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </form>
                            <div class="control-cart">
                                <button onclick="window.location.href = '{{ url('/') }}';" class="button btn-continue-shopping">
                                    Continue Shopping
                                </button>
                                <button onclick="window.location.href = '{{ url('/Checkout') }}';" class="button btn-cart-to-checkout">
                                    Checkout
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>
</div>
<script>

$(document).ready(function() {
    $(".qtyplus").click(function(e) {
        $(".qtyplus").prop("disabled", true);
        e.preventDefault();

        var parentTr = $(this).closest('tr.cart_item');
        var productID = $(this).data("product-id");
        var product_price_Id = parentTr.find('.woocommerce-Price-currencySymbol').data('price-id');
        var quantityInput = $("#quantityInput_" + productID + "_" + product_price_Id);
        var currentQuantity = parseInt(quantityInput.val());
        var cond = false;

        if (isNaN(currentQuantity)) {
            currentQuantity = 0;
        }
        updateCart(productID, product_price_Id, quantityInput.val(), cond);
    });

    $(".qtyminus").click(function(e) {
        $(".qtyminus").prop("disabled", true);
        e.preventDefault();

        var parentTr = $(this).closest('tr.cart_item');
        var productID = $(this).data("product-id");
        var product_price_Id = parentTr.find('.woocommerce-Price-currencySymbol').data('price-id');
        var quantityInput = $("#quantityInput_" + productID + "_" + product_price_Id);
        var currentQuantity = parseInt(quantityInput.val());
        var cond = false;
        if (currentQuantity > 1) {
            quantityInput.val(currentQuantity - 1);
            updateCart(productID, product_price_Id, quantityInput.val(), cond);
        }
    });

    $(".quantity").on("change", ".qty", function() {
        $(".quantity").prop("disabled", true);
        var parentTr = $(this).closest('tr.cart_item');
        var productID = $(this).attr("id").split("_")[1];
        var quantity = $(this).val();
        var product_price_Id = parentTr.find('.woocommerce-Price-currencySymbol').data('price-id');
        var cond = false;
        updateCart(productID, product_price_Id, quantity, cond);
    });

    function updateCart(productID, product_price_Id, quantityValue,  cond) {
        $.ajax({
            url: "{{ route('UpdateCart') }}",
            data: {
                _token: '{{ csrf_token() }}',
                id: productID,
                PriceId: product_price_Id,
                quantity: quantityValue,
                cond : cond
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


$(".product-remove").click(function (e) {
    e.preventDefault();
    var ele = $(this);
    var productId = ele.closest("tr").data("id");
    var productPriceId = ele.closest("tr").data("price-id");

    Swal.fire({
        title: "Remove Item",
        text: "Are you sure you want to remove this item?",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Remove",
        cancelButtonText: "Cancel",
        customClass: {
            popup: 'swal-large',
            title: 'swal-large swal-title',
            content: 'swal-large swal-text',
        }
        })
        .then((willDelete) => {
        if (willDelete) {
            $.get("{{ url('RemoveFromCart') }}", {
                pid : productId,
                productPriceId : productPriceId,
                _token : '{{ csrf_token() }}'
            })
            .done(function(res) {
                if (res['success']) {
                                    Swal.fire({
                                        title: "Successful...",
                                        text: res.message,
                                        icon: "success",
                                        customClass: {
                                            popup: 'swal-large', // Apply the custom class to the modal
                                            title: 'swal-large swal-title', // Apply the custom class to the title
                                            content: 'swal-large swal-text', // Apply the custom class to the text content
                                        }
                                    })
                                    location.reload();
                                }
            })
            .fail(function(error) {
                console.error("Error:", error);
            });
        }
    });
});

</script>
 @endsection
