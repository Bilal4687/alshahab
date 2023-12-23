@extends('Website.Layout')

@section('content')

<style>
    #my_address a:hover {
        color: white !important;
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
                                        <th id="my_address" style="text-align: center; background-color :#ab8e66; color:white;">
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
                                <div class="EditAddressForm">
                                    <div style="border: 1px solid rgba(240, 236, 236, 0.986); padding: 10px;">
                                        <div class="EditAddress">
                                            <form id="EditAddressDetail">
                                                @csrf
                                                <br>
                                                <input type="hidden" value="{{ $Customer_address_info->customer_id }}" id="customer_id"
                                                    name="customer_id">
                                                <input type="hidden" value="{{ $Customer_address_info->customer_address_id ?? ''}}"
                                                    id="customer_address_id" name="customer_address_id">
                                                <p class="form-row form-row-first">
                                                    <label class="text">Name</label>
                                                    <input type="text" name="customer_name" id="customer_name" class="input-text"
                                                        value="{{ $Customer_address_info->customer_name ?? ''}}">
                                                </p>
                                                <p class="form-row form-row-last">
                                                    <label class="text">10 Digit Mobile Number</label>
                                                    <input name="customer_mobile" id="customer_mobile" type="text"
                                                        class="input-text" value="{{ $Customer_address_info->customer_mobile ?? ''}}">
                                                </p>
                                                <p class="form-row form-row-first">
                                                    <label class="text">Pincode</label>
                                                    <input name="customer_pincode" id="customer_pincode" type="text"
                                                        class="input-text" value="{{ $Customer_address_info->customer_pincode ?? ''}}">
                                                </p>
                                                <p class="form-row form-row-last ">
                                                    <label class="text">Locality</label>
                                                    <input name="customer_locality" id="customer_locality" type="text"
                                                        class="input-text" value="{{ $Customer_address_info->customer_locality ?? ''}}">
                                                </p>
                                                <p class="form-row">
                                                    <label class="text">Address</label>
                                                    <textarea class="input-text" name="customer_address" id="customer_address"
                                                        cols="2" rows="2">{{ $Customer_address_info->customer_address ?? ''}}</textarea>
                                                </p>
                                                <p class="form-row form-row-last ">
                                                    <label class="text">City</label>
                                                    <input name="customer_city" id="customer_city" type="text" class="input-text"
                                                        value="{{ $Customer_address_info->customer_city ?? ''}}">
                                                </p>
                                                <p class="form-row form-row-last">
                                                    <label class="text">State</label>
                                                    <select title="state" name="state_id" id="state_id"
                                                    class="chosen-select">
                                                        <option>Select State</option>
                                                        @foreach ($StateData as $state)
                                                        <option value="{{ $state->state_id }}" {{ isset($Customer_address_info) &&
                                                            $Customer_address_info->state_id == $state->state_id ? 'selected' : '' }}>
                                                            {{ $state->name }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </p>
                                                <p class="form-row form-row-last ">
                                                    <label class="text">
                                                      <input name="customer_default_address" id="customer_default_address" type="checkbox" class="input-checkbox"
                                                        {{($Customer_address_info->customer_default_address ?? 0 ) == 1 ? "checked" : ""}}>
                                                        Make this my default address
                                                    </label>
                                                </p>
                                                <a type="button" class="button button-payment" id="SaveEditedAddress" style="border: 1px solid #ab8e66">Save</a>
                                                <button type="button" class="button" id="CloseEditForm"style="border: 1px solid #ab8e66">Cancel</button>

                                                </form>
                                                <span id="error" style="display: none;" class="m-auto"></span>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        {{-- Address container Ended --}}
        </div>
</div>

<script>


$('#SaveEditedAddress').click(function() {
    $.post("{{ route('PrimaryAddressStore') }}", $("#EditAddressDetail").serialize())
        .done((res) => {
            if (res.success) {
                window.location.href='{{ url("ManageAddresses") }}'
            } else if (res.validate) {
                alertmsg(res.message, "warning")
            } else {
                alertmsg(res.message, "danger")
            }
        });
});



</script>


@endsection


