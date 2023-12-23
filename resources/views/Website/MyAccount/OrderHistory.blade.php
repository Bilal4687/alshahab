@extends('Website.Layout')

@section('content')

<style>
    #orders_history a:hover{
        color:white;
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
                            My Account
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <h3 class="custom_blog_title">
            My Profile
        </h3>

        {{-- Address container Started --}}

        <div class="checkout-wrapp">
            <div class="shipping-address-form-wrapp">
                <div class="shipping-address-form  checkout-form">
                    <div class="col-lg-12 col-md-12 row-col">
                        <div class="card">
                            <div class="col-md-3">
                                <table style="background-color :rgba(240, 236, 236, 0.007); height:250px">
                                    <h3 style="text-align: center; background-color :rgba(240, 236, 236, 0.007); border:1px solid rgba(240, 236, 236, 0.007)">My Profile</h3>
                                    <tr>
                                        <th id="personal_detail" style="text-align: center;">
                                            <a href="{{ url('/MyAccount') }}"  active>Personal Information</a>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th id="my_address" style="text-align: center">
                                            <a href="{{ url('/ManageAddresses') }}" >Manage Addresses</a>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th id="orders_history" style="text-align: center; background-color :#ab8e66; color:white">
                                            <a href="{{ url('/OrderHistory') }}" >
                                                Orders History
                                            </a>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th id="logout" style="text-align: center">
                                            <a href="{{ url('Logout') }}" >
                                                Logout
                                            </a>
                                        </th>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-lg-9">
                                <table class="shop_table">
                                    <thead>
                                        <tr>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($data->isEmpty())

                                        <tr>
                                            <td colspan="6">
                                                <div class="main-content-cart main-content col-sm-12">
                                                    <div class="page-main-content" style="text-align: center; margin-top:150px;">
                                                        <div class="shoppingcart-content">
                                                            <h1 style="">Your cart is empty!</h1>
                                                            <a href="{{ url('/') }}"
                                                                class="button" style="background-color: #ab8e66; color:#ffffff">Back to
                                                                shipping</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>


                                        @else
                                        @foreach($data as $items)
                                        <tr class="cart_item row-col col-sm-12" data-id="{{ $items->product_id }}">

                                            <td class="product-thumbnail">
                                                <a href="#">
                                                    <img src="{{ asset('public/Files/Products/' . ($items->product_thumbnail ?? '')) }}" alt="img" style="width: 100px; height:100px;">
                                                </a>
                                            </td>
                                            <td class="product-name" data-title="Product">
                                                <a href="#" class="title">{{ $items->product_name ?? '' }}</a>

                                            </td>
                                            <td class="product-price" data-title="Price">
                                                <span class="woocommerce-Price-amount amount">
                                                    <span class="woocommerce-Price-currencySymbol">
                                                        {{ $items->product_price * $items->item_qty }}
                                                    </span>
                                                </span>
                                            </td>
                                            <td class="product-price" data-title="Price">
                                                <span class="woocommerce-Price-amount amount">
                                                    <span class="woocommerce-Price-currencySymbol">
                                                        <?php
                                                        if ($items->order_item_status == 0) {
                                                            echo "<span style='color: #777777' class='badge'>.</span>
                                                                    <span>Order Placed Successfully</span>";
                                                        } elseif ($items->order_item_status == 1) {
                                                            echo "<span><i class='fa fa-star' aria-hidden='true' style='color:green';></i>Order Delivered Successfully</span>";
                                                        } else {
                                                        }
                                                        ?>
                                                    </span>
                                                </span>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @endif

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        {{-- Address container Ended --}}
        </div>
</div>


@endsection
