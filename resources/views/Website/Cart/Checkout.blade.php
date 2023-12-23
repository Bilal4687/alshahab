@extends('Website.Layout')

@section('content')
<style>
    hr {
        border-color: #000;
        /* Dark color */
        border-width: 1px;
        /* Increase border width for boldness */
    }
    #tableSummary {
        border: 1px solid white;
        border-collapse: collapse;
        border-spacing: 0;
        table-layout: auto;
        width: 100%;
        margin-bottom: 5px;
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

                        <h3 class="title-form">
                            Shipping Address
                        </h3>
                        @if(!$CustomerData)
                        <div class="your-order-section" style="border: 1px solid #f3f3f3; text-align:center; width: 100%; padding: 20px">
                            <a href="{{ url('/ManageAddresses') }}" style="background-color:#ab8e66; color:white"
                                class="btn">
                                <i class="fa fa-map-marker" aria-hidden="true" style="margin-right:5px "></i> Select
                                Addresss</a>
                        </div>
                        @else

                        <div class="card addressCard your-order-section">
                            <div class="card-body">
                                <a type="button" class="button btn-credit-card"  href="{{ url('/ManageAddresses') }}" class=" " id="ChooseAddress"
                                    style="float: right; background: #ab8e66; color: #ffffff;  cursor: pointer; margin-top: 5px">
                                    Change Address
                                </a>
                                <input type="hidden" id="customer_id" value="{{ $CustomerData->customer_id ?? '' }}">
                                <input type="hidden" id="customer_address_id"
                                    value="{{ $CustomerData->customer_address_id ?? '' }}">
                                <div class="d-flex justify-content-between align-items-center" style="padding: 10px;">
                                    <i class="fa fa-user" style="color: #ab8e66"></i>
                                    <strong>{{ $CustomerData->customer_name ?? '' }}</strong><br>
                                    <i class="fa fa-phone" style="color: #ab8e66;  margin-top: 10px"></i>

                                    {{ $CustomerData->customer_mobile ?? '' }}
                                    <p class="card-text" style="margin-top: 10px">
                                        <i class="fa fa-map-pin" style="color: #ab8e66"></i>

                                        {{ $CustomerData->customer_locality ?? '' }}
                                        {{ $CustomerData->customer_address ?? '' }}
                                        {{ $CustomerData->customer_city ?? '' }}
                                        {{ $CustomerData->customer_pincode ?? '' }}
                                    </p>

                                </div>


                            </div>
                        </div>

                        @endif







                        <h3 class="title-form">
                            Your Order
                        </h3>
                       <div class="your-order-section">
                        <div class="your-order" style="margin-top: 20px">
                            <ul class="list-product-order">
                                @php
                                $cartItems = App\Helpers\CartHelper::getCart();
                                @endphp

                                @if(!empty($cartItems) && is_array($cartItems))
                                @foreach($cartItems as $items)
                                <div class="col-md-6">
                                    <li class="product-item-order">
                                        <div class="product-thumb">
                                            <a href="#">
                                                <img style="width:100px; height:100px"
                                                    src="{{ asset('public/Files/Products/' . $items['product_thumbnail' ?? '']) }}"
                                                    alt="img">
                                            </a>
                                        </div>
                                        <div class="product-order-inner">
                                            <h5 class="product-name">
                                                <a href="#">{{ $items['product_name' ?? ''] }}</a>
                                            </h5>
                                            <span class="attributes-select attributes-color">{{
                                                $items['products__attributes']['attribute_value'] }}</span>
                                            <span class="attributes-select attributes-size">{{
                                                $items['products__variations']['variation_value'] }}</span>
                                            <div class="price">
                                                {{ $items['products__pricing']['sale_price'] }}
                                                <span class="count">(x {{ $items['quantity' ?? ''] }})</span>
                                            </div>
                                        </div>
                                    </li>
                                </div>
                                @endforeach

                                @endif
                            </ul>
                        </div>
                       </div>

                    </div>
                    <div class="col-lg-4 row-col YourOrderCard">
                        <h3 class="title-form" >
                            Order Summary
                        </h3>
                        <div class="your-order your-order-section">
                            @php
                            $cartItems = App\Helpers\CartHelper::getCart();
                            @endphp
                                <span style="display: none">
                                    @php
                                    $total = 0;
                                    @endphp.
                                    @foreach ($cartItems as $item)
                                    @php
                                    $total +=
                                    $item['products__pricing']['sale_price'] *
                                    $item['quantity'];
                                    @endphp
                                    @endforeach
                                </span>
                                <table id="tableSummary">
                                    {{-- @foreach($cartItems as $item) --}}
                                    <tr>
                                        <td style="border: none !important">Sub total</td>
                                        <td style="border: none !important;float: right ">
                                            ₹{{ $total }}
                                        </td>
                                    </tr>
                                    <tr style="border-bottom: 1px solid #c7c7c7;">
                                        <td style="border: none !important">Shipping</td>
                                        <td style="border: none !important; color: darkgreen; float: right ">To be
                                            calculated</td>
                                    </tr>
                                    <tr>
                                        <td style="border: none !important">Grand Total</td>
                                        <td style="border: none !important;float: right ">
                                            ₹{{ $total }}
                                        </td>
                                    </tr>

                                    {{-- @endforeach --}}
                                </table>
                        </div>
                    </div>
                    <div class="col-lg-4 row-col YourOrderCard">
                        <h3 class="title-form" style="margin-top: 5px">
                            Payment
                        </h3>
                        <div class="your-order your-order-section">
                            <strong>All transactions are secure and encrypted</strong>
                            <div style="margin-top: 10px">
                                <img src="{{ url('public/Files/Icons/Gpay.png') }}"
                                    style="width: 30px; height: auto">
                                <img src="{{ url('public/Files/Icons/Paytm.png') }}"
                                    style="width: 50px; height: auto">
                                <img src="{{ url('public/Files/Icons/phonepe.png') }}"
                                    style="width: 30px; height: auto">
                                <img src="{{ url('public/Files/Icons/amazon.png') }}"
                                    style="width: 30px; height: auto">
                                <button class="button btn-credit-card " id="RazorPayPayment"
                                    style="float: right; background: #ab8e66; color: #ffffff; margin-bottom: 0px; cursor: pointer; margin-top: -6px">
                                    Pay Now
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>
    $(document).ready(function () {
    $('#RazorPayPayment').click(function (e) {

        e.preventDefault();

        $('#RazorPayPayment').prop('disabled', true);

        var ele = $(this);
        var id = $('#product_id').val();
        var Amount = {{ $total }};
        var Cid  = $('#customer_id').val();

        $.ajax({
            url: '{{ url('ProcessRazorPayPayment') }}',
            type: 'POST',
            data: {
                _token : '{{ csrf_token() }}',
                GrandTotal : Amount,
                customerId : Cid,
                product_id : id
            },
            success: function(response){
                var options = {
                    "key" : "rzp_test_I48iHI71fszyAg",
                    "amount" :  response.GrandTotal,
                    "currency" : "INR",
                    "name" : response.customerInfo[0]['customer_name'],
                    "description" : "Razorpay payment",
                    "image" : "{{ asset('public/assets/images/Guessmyscent.png') }}",
                    "order_id": response.order_id,
                    "handler" : function(res){
                        $.ajax({
                            type: "post",
                            url: "{{ url('PlaceOrder') }}",
                            data: {
                                _token : '{{ csrf_token() }}',
                                GrandTotal : Amount,
                                customerId : Cid,
                                razorpay_order_id : response.order_id,
                                payment_id : res.razorpay_payment_id
                            },
                            success: function (response) {
                                if(response){
                                    window.location.href = "{{ url('/OrderConfirm') }}"
                                }else{
                                    alert('failed');
                                }
                            }
                            
                        });
                    },
                    "prefill" :{
                        "name" : response.customerInfo[0]['customer_name'],
                        "email" : response.customerInfo[0]['customer_email'],
                        "contact" : response.customerInfo[0]['customer_mobile']
                    },
                    "theme" : {
                        "color" : "#ab8e66"
                    }
                };
                $('#RazorPayPayment').prop('disabled', false);
                var rpz1 = new Razorpay(options);

                rpz1.open();
            }
        });

    });
});

    $(document).ready(function()
{
    $('.OrderSummary').hide();
    $('.PaymentOption').hide();
    $('#Cod_Info').hide();
    $('#Cod_Btn').hide();

    $('#PrimaryAddress').click(function(){
        $('#editAddressRadio').prop('checked', false);
        $('#NewAddressRadio').prop('checked', false);
    });
    $('#editAddressRadio, #NewAddressRadio').click(function(){
        $('#PrimaryAddress').prop('checked', false);
    })

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




$("#ConfirmBtn").click(function (e)
    {
        e.preventDefault();
        var ele = $(this);
        var id = $('#product_id').val();
        var Amount = {{ $total }};
        var Cid  = $('#customer_id').val();

        $.ajax({
            url: '{{ url('CodPlaceOrder') }}',
            type: 'POST',
            data: {
                _token : '{{ csrf_token() }}',
                GrandTotal : Amount,
                customerId : Cid,
                product_id : id
            }, function(res) {
            if (res['success']) {

                setTimeout(() => {

                    Swal.fire({
                            title: "Successful...",
                            text: res.message,
                            icon: "success",
                            customClass: {
                                popup: 'swal-large',
                                title: 'swal-large swal-title',
                                content: 'swal-large swal-text',
                            }
                        })
                }, 1500);

            }
            else{
                    Swal.fire({
                        icon: 'error',
                            title: 'Oops...',
                            text: res.message,
                            customClass: {
                                popup: 'swal-large',
                                title: 'swal-large swal-title',
                                content: 'swal-large swal-text',
                            }
                        })
            }
            }
        });
    });




$('#CashOnDeliver').click(function (e) {
    $('#Card_Info').hide();
    $('#CreditCard').removeClass('btn-credit-card');
    $('#Cod_Info').show();
    $('#Cod_Btn').show();
    $('#CashOnDeliver').addClass('btn-credit-card');
});

$('#CreditCard').click(function (e) {
    $('#Card_Info').show();
    $('#CashOnDeliver').removeClass('btn-credit-card');
    $('#Cod_Info').hide();
    $('#Cod_Btn').hide();
    $('#CreditCard').addClass('btn-credit-card');
});


$('#PaymentOptionBtn').click(function(e) {
    $('.PaymentOption').slideToggle(400);
});
$("#HideOrderConten").click(function() {
    $('.OrderSummary').slideToggle(400);
});


$(".product-remove").click(function (e)
{
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


function CustomerLogin()
{
        $('#LoginBtn').prop("disabled", true);

        $.post("{{ route('CheckoutLoginFlow') }}", $('#CustomerLogin').serialize())
            .done((res) => {
                if (res.success) {
                    alertmsg(res.message, "success");
                    location.reload();
                } else if (res.validate) {
                    alertmsg(res.message, "warning")
                } else {
                    alertmsg(res.message, "danger")
                }
            })
            .fail((err) => {
                alertmsg("Opps Something Went Wrong", "danger")
            });
        $('#LoginBtn').prop("disabled", false);

}


</script>




@endsection
