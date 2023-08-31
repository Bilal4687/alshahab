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
                                            $cartItems = App\Helpers\CartHelper::getCart();
                                        @endphp

                                        @if(!empty($cartItems) && is_array($cartItems))
                                            @foreach($cartItems as $items)
                                                <tr class="cart_item" data-id="{{ $items['product_id'] }}">
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
                                                        <span class="attributes-select attributes-color">{{ $items['products__variations']['variation_value'] ?? '' }}</span>
                                                        <span class="attributes-select attributes-size">{{ $items['products__attributes']['attribute_value'] ?? '' }}</span>
                                                    </td>
                                                    <td class="product-quantity" data-title="Quantity">
                                                        <div class="quantity">
                                                            <div class="control">
                                                                <a class="btn-number qtyminus quantity-minus" data-product-id="{{ $items['product_id'] }}">-</a>
                                                                <input type="number" value="{{ $items['quantity'] }}" min="1" class="input-qty qty quantity cart_update" id="quantityInput_{{ $items['product_id'] }}" title="Qty">
                                                                <a class="btn-number qtyplus quantity-plus" data-product-id="{{ $items['product_id'] }}">+</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="product-price" data-title="Price">
                                                        <span class="woocommerce-Price-amount amount">
                                                            <span class="woocommerce-Price-currencySymbol">
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

        var productID = $(this).data("product-id");
        // console.log(productID);
        // return false;
        var quantityInput = $("#quantityInput_" + productID);
        var currentQuantity = parseInt(quantityInput.val());

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


    $(".product-remove").click(function (e) {
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
                popup: 'swal-large',
                title: 'swal-large swal-title',
                content: 'swal-large swal-text',
            }
            })
            .then((willDelete) => {
                        if (willDelete) {
                            $.get("{{ route('RemoveFromCart') }}", {
                                _token : '{{ csrf_token() }}',
                                id : ele.parents("tr").attr("data-id")
                            }, function(res) {
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
                            });
                        }
                    });
    });

</script>
 @endsection
