<!-- resources/views/Partials/address_card.blade.php -->
<div class="card addressCard">
    <input type="radio" checked>
    <div class="card-body">
        <a type="button" id="changeButton" class="button button-payment">Change</a>
        <input type="hidden" id="customer_id" value="{{ $CustomerData->customer_id ?? '' }}">
        <input type="hidden" id="customer_address_id" value="{{ $CustomerData->customer_address_id ?? '' }}">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title">{{ $customerData->customer_name ?? '' }}
                {{ $customerData->customer_mobile ?? '' }}</h5>
        </div>

        <p class="card-text">
            {{ $customerData->customer_pincode ?? '' }}
            {{ $customerData->customer_locality ?? '' }}
            {{ $customerData->customer_city ?? '' }}
            {{ $customerData->customer_address ?? '' }}
        </p>

        <div id="Deliver_Here" style="display: none">
            <a type="button" onclick="DeliverHere()" class="button">Deliver Here</a>
            <a onclick="FormShow()" type="button" class="button">Edit</a>
        </div>
    </div>
</div>
