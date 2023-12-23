@extends('Website.Layout')

@section('content')

<style>
    #personal_detail a:hover{
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
                                        <th id="personal_detail" style="text-align: center; background-color :#ab8e66; color:white;">
                                            <a href="{{ url('/MyAccount') }}"  active>Personal Information</a>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th id="my_address" style="text-align: center">
                                            <a href="{{ url('/ManageAddresses') }}" >Manage Addresses</a>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th id="orders_history" style="text-align: center">
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
                            <div class="col-md-9">
                                  <div class="DefaultAddress col-md-6">
                                    <div style="border: 2px solid rgba(240, 236, 236, 0.986); border-radius: 5%; background-color: #fff">
                                             <!-- Buttons at the top-right of the card -->
                                             <div id="SEDbtns" style="float: right; padding:10px;">
                                                <a  href="">
                                                    <button class="btn btn-sm" id="EditAddressBtn" title="Edit">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                </a>
                                            </div>
                                    <div>

                                        <div id="EditAddressBtn" style="border: 1px solid rgba(240, 236, 236, 0.986); padding: 10px;">
                                            <span class="badge badge-secondary" style="padding: 8px;">Profile</span>
                                            <span  style="margin-left: 5px; font-size: 20px;"></span>
                                            <span></span>
                                            <span></span>
                                        </div>
                                            <div style="width: 250px; height: auto">
                                                @foreach($data as $items)

                                                <p style="margin-left: 30px; margin-top: 30px;">
                                                    <span>
                                                        <strong>{{ $items->customer_name }}</strong>
                                                    </span><br>
                                                    <span>{{ $items->customer_email }}</span>
                                                    <br>
                                                    {{-- <span>{{ $items->customer_email }}</span> --}}
                                                </p>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                </div>



                                <div class="DefaultAddress col-md-6">
                                    <div style="border: 2px solid rgba(240, 236, 236, 0.986); border-radius: 5%; background-color: #fff">
                                        <!-- Buttons at the top-right of the card -->
                                        <div id="SEDbtns" style="float: right; padding:10px;">
                                            <button class="btn btn-sm"  title="Set As Default">
                                                <i class="fa fa-check"></i>
                                            </button>
                                            <a  href="{{url('EditAddress')}}/{{$Customer_address_info->customer_address_id ?? ''}}">
                                                <button class="btn btn-sm" id="EditAddressBtn" title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                            </a>
                                            <button class="btn btn-sm" title="Remove" >
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>

                                    <div>

                                        @if(!empty($Customer_address_info))
                                        <div id="EditAddressBtn" style="border: 1px solid rgba(240, 236, 236, 0.986); padding: 10px;">
                                            <span class="badge badge-secondary" style="padding: 8px;"> Default</span>
                                            <span  style="margin-left: 5px; font-size: 20px;"></span>
                                            <span></span>
                                            <span></span>
                                        </div>
                                        <div style="width: 250px; height: auto">
                                            <p style="margin-left: 30px; margin-top: 30px;">
                                                <span>
                                                    <strong>{{ $Customer_address_info->customer_name ?? ''}}</strong>
                                                </span>
                                                <br>
                                                <span>{{ $Customer_address_info->customer_locality ?? ''}}</span>
                                                <span>{{ $Customer_address_info->customer_address ?? ''}}</span>
                                                <span>{{ $Customer_address_info->customer_city ?? ''}}</span>
                                                <span>
                                                    <br>
                                                    Phone number : {{ $Customer_address_info->customer_mobile ?? ''}}
                                                </span>
                                                <br>
                                            </p>
                                        </div>
                                        @else
                                        <div id="EditAddressBtn" style="border: 1px solid rgba(240, 236, 236, 0.986); padding: 10px;">
                                            <span style="margin-left: 5px; font-size: 20px;"></span>
                                            <span></span>
                                            <span></span>
                                        </div>

                                        <div style="width: 250px; height: 100px; ; margin-top:50px;margin-left:50px; text-align: center">
                                            <a href="{{ url('/ManageAddresses') }}" style="background-color:#ab8e66; color:white" class="btn">Select Addresss</a>
                                        </div>
                                        @endif
                                        </div>
                                    </div>
                                    <br>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        {{-- Address container Ended --}}
        </div>
</div>

@endsection
