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
                          @if(empty($Customer_address))
                            <div class="col-md-9">
                                <div class="col-sm-12">
                                    <div class="page-main-content" style="text-align: center;">
                                        <div class="shoppingcart-content" id="NoAddressSection">
                                            <h1 style="margin-top:50px;">No Addresses found in your account!!</h1>
                                            <a class="button" id="AddAddress" style="background-color: #ab8e66; color:#ffffff">Add Addresses</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="FirstNewAddressForm" style="display: none;">
                                    <div style="border: 1px solid rgba(240, 236, 236, 0.986); padding: 10px;">

                                        <div class="FirstNewAddress">
                                            <div class="FirstAddNewAddress">
                                                <div>
                                                    <span style="margin-left: 5px; font-size:20px;">+</span>
                                                    <span>Add New Address</span>
                                                </div>
                                            </div>
                                            <form id="FirstCustomerAddressForm">
                                                @csrf
                                                <br>

                                                <input type="text" value="{{ Session::get('customer_id') }}" id="customer_id"
                                                    name="customer_id">
                                                <input type="hidden" value="" id="customer_address_id"
                                                    name="customer_address_id">
                                                <p class="form-row form-row-first">
                                                    <label class="text">Name</label>
                                                    <input type="text" name="customer_name" id="customer_name" class="input-text"
                                                        value="">
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
                                                    <textarea class="input-text" name="customer_address" id="customer_address"
                                                        cols="2" rows="2"></textarea>
                                                </p>
                                                <p class="form-row form-row-last ">
                                                    <label class="text">City</label>
                                                    <input name="customer_city" id="customer_city" type="text" class="input-text"
                                                        value="">
                                                </p>
                                                <p class="form-row form-row-last">
                                                    <label class="text">State</label>
                                                    <select title="state" name="state_id" id="state_id"
                                                    class="chosen-select">
                                                        <option>Select State</option>
                                                        @foreach ($StateData as $state)
                                                        <option value="{{ $state->state_id }}" {{ isset($data) &&
                                                            $data->state_id == $state->state_id ? 'selected' : '' }}>
                                                            {{ $state->name }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </p>
                                                <button type="button" class="button" id="CancelFirstAddressForm" style="border: 1px solid #ab8e66">Cancel</button>
                                                <a type="button" class="button button-payment" id="FirstCustomerAddress" style="border: 1px solid #ab8e66">Save Address</a>
                                                <span id="error" style="display: none;" class="m-auto"></span>
                                            </form>
                                        </div>

                                    </div>
                                </div>

                            </div>
                            @else

                            <div class="col-md-9 col-sm-6">
                                <div class="card" id="ManageAddresses" style="margin-top: 50px;">
                                    <div class="col-lg-12 col-sm-6">
                                        <div class="AddNewAddress">
                                            <div style="border: 1px solid rgba(240, 236, 236, 0.986); padding: 10px;">
                                                <span style="margin-left: 5px; font-size:20px;">+</span>
                                                <span>Add New Address</span>
                                            </div>
                                        </div>
                                        <div class="NewAddressForm" style="display: none;">
                                            <div style="border: 1px solid rgba(240, 236, 236, 0.986); padding: 10px;">

                                                <div class="NewAddress">

                                                    <form id="AddNewAddressForm">
                                                        @csrf
                                                        <br>

                                                        <input type="hidden" value="{{ Session::get('customer_id') }}" id="customer_id"
                                                            name="customer_id">
                                                        <input type="hidden" value=""
                                                            id="customer_address_id" name="customer_address_id">
                                                        <p class="form-row form-row-first">
                                                            <label class="text">Name</label>
                                                            <input type="text" name="customer_name" id="customer_name" class="input-text"
                                                                value="">
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
                                                            <textarea class="input-text" name="customer_address" id="customer_address"
                                                                cols="2" rows="2"></textarea>
                                                        </p>
                                                        <p class="form-row form-row-last ">
                                                            <label class="text">City</label>
                                                            <input name="customer_city" id="customer_city" type="text" class="input-text"
                                                                value="">
                                                        </p>
                                                        <p class="form-row form-row-last">
                                                            <label class="text">State</label>
                                                            <select title="state" name="state_id" id="state_id"
                                                            class="chosen-select">
                                                                <option>Select State</option>
                                                                @foreach ($StateData as $state)
                                                                <option value="{{ $state->state_id }}" {{ isset($data) &&
                                                                    $data->state_id == $state->state_id ? 'selected' : '' }}>
                                                                    {{ $state->name }}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </p>
                                                        <p class="form-row form-row-last ">
                                                            <label class="text">
                                                                <input name="customer_default_address" id="customer_default_address" type="checkbox" class="input-checkbox">
                                                                Make this my default address</label>
                                                         </p>
                                                        <a type="button" class="button button-payment" id="AddNewAddressBtn" style="border: 1px solid #ab8e66">SAVE ADDRESS</a>
                                                        <button type="button" class="button" id="DeliveryAddress" style="border: 1px solid #ab8e66">Cancel</button>
                                                    </form>
                                                    <span id="error" style="display: none;" class="m-auto"></span>
                                                </div>

                                            </div>
                                        </div>
                                        <br>
                                        @foreach($Customer_info as $data)
                                        <div class="DefaultAddress col-md-6">
                                            <div style="border: 2px solid rgba(240, 236, 236, 0.986); border-radius: 5%; background-color: #fff">
                                                <!-- Buttons at the top-right of the card -->
                                                <div id="SEDbtns" style="float: right; padding:10px;">
                                                    <button class="btn btn-sm"  title="Set As Default" onclick="SetAsDefault({{ $data->customer_address_id }})">
                                                        <i class="fa fa-check"></i>
                                                    </button>
                                                    <a  href="{{url('EditAddress')}}/{{$data->customer_address_id ?? ''}}">
                                                        <button class="btn btn-sm" id="EditAddressBtn" title="Edit">
                                                            <i class="fa fa-edit"></i>
                                                        </button>
                                                    </a>
                                                    <button class="btn btn-sm" title="Remove" onclick="RemoveAddress({{ $data->customer_address_id }})">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </div>


                                                @if($data->customer_default_address == 1)
                                                <div id="EditAddressBtn" style="border: 1px solid rgba(240, 236, 236, 0.986); padding: 10px;">
                                                    <span class="badge badge-secondary" style="padding: 8px;"> Default</span>
                                                    <span  style="margin-left: 5px; font-size: 20px;"></span>
                                                    <span></span>
                                                    <span></span>
                                                </div>
                                                @else
                                                <div id="EditAddressBtn" style="border: 1px solid rgba(240, 236, 236, 0.986); padding: 10px;">
                                                    <span style="margin-left: 5px; font-size: 20px;"></span>
                                                    <span></span>
                                                    <span></span>
                                                </div>
                                                @endif
                                                    <div style="width: auto; height: auto">
                                                        <p style="margin-left: 30px; margin-top: 30px;">
                                                            <span>
                                                                <strong>{{ $data->customer_name ?? ''}}</strong>
                                                            </span>
                                                            <br>
                                                            <span>{{ $data->customer_locality ?? ''}}</span>
                                                            <span>{{ $data->customer_address ?? ''}}</span>
                                                            <span>{{ $data->customer_city ?? ''}}</span>
                                                            <span>
                                                                <br>
                                                                Phone number : {{ $data->customer_mobile ?? ''}}
                                                            </span>
                                                            <br>
                                                        </p>
                                                    </div>
                                            </div>
                                            <br>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        {{-- Address container Ended --}}
        </div>
</div>

<script>

function SetAsDefault(customer_address_id){
    $.get("{{ url('SetAsDefault') }}",{"customer_address_id":customer_address_id}, function(data){
        window.location.reload();
    });
}
function RemoveAddress(customer_address_id){
    $.get("{{ url('RemoveAddress') }}",{"customer_address_id":customer_address_id}, function(data){

                window.location.reload();
    });
}

$('#FirstCustomerAddress').click(function() {

    $('#FirstCustomerAddress').attr('disabled', true);

    $.post("{{ route('PrimaryAddressStore') }}", $("#FirstCustomerAddressForm").serialize())
    .done((res) => {
        if (res.success) {
            setTimeout(() => {
                $('.FirstCustomerAddressForm').hide();
            }, 1500);
            location.reload();
        } else if (res.validate) {
            alertmsg(res.message, "warning")
        } else {
            alertmsg(res.message, "danger")
        }
        $('#FirstCustomerAddress').attr('disabled', false);
    })
});

$('#AddNewAddressBtn').click(function() {
        $('#AddNewAddressBtn').attr('disabled', true);
        $.post("{{ route('PrimaryAddressStore') }}", $("#AddNewAddressForm").serialize())
        .done((res) => {
            if (res.success) {
                setTimeout(() => {
                    $('.NewAddressForm').hide();
                }, 1000);
                location.reload();

            } else if (res.validate) {
                alertmsg(res.message, "warning")
            } else {
                alertmsg(res.message, "danger")
            }
            $('#AddNewAddressBtn').attr('disabled', false);
        })
});









$('#AddAddress').click(function (e) {

       $('#NoAddressSection').css('display', 'none');

       $('.FirstNewAddressForm').slideToggle(500);
    });


$('.AddNewAddress').click(function () {

    $('.NewAddressForm').slideToggle(500);

});

$('#CancelFirstAddressForm').click(function () {

    $('.FirstNewAddressForm').slideToggle(500);
    $('#NoAddressSection').show();

        $('.NewAddressForm').slideToggle(500);

    });

    $('#CloseEditForm').click(function () {
        $('#SEDbtns').show();

});

</script>

@endsection
