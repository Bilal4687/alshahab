<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
class AddressHelper
{
    public static function storePrimaryAddress($data)
    {
        $validator = Validator::make($data, [
            'customer_name' => 'required',
            'customer_mobile' => 'required|regex:/^[0-9]{10}$/',
            'customer_pincode' => 'required',
            'customer_locality' => 'required',
            'customer_address' => 'required',
            'customer_city' => 'required',
            'state_id' => 'required',
        ]);

        if ($validator->fails()) {
            return ["success" => false, "message" => $validator->errors()->first()];
        }

        $customer_id = $data['customer_id'];
        $customer_name = $data['customer_name'];
        $customer_mobile = $data['customer_mobile'];
        $customer_pincode = $data['customer_pincode'];
        $customer_locality = $data['customer_locality'];
        $customer_address = $data['customer_address'];
        $customer_city = $data['customer_city'];
        $state_id = $data['state_id'];
        $customer_default_address = isset($data['customer_default_address']) ? 1 : 0;
        $customer_address_id = $data['customer_address_id'];

        try {

            if($customer_default_address == 1){

                $customerId = Session::get('customer_id');
                // dd($customerId);
                $hasDefaultAddress = DB::table('customers__address')
                ->where('customer_id', $customerId)
                ->where('customer_default_address', 1)
                ->first();

                if ($hasDefaultAddress) {
                    DB::table('customers__address')
                    ->where('customer_id', $hasDefaultAddress->customer_id)
                    ->update(['customer_default_address'=> 0]);
                }
                // dd($hasDefaultAddress);

            }
            DB::table('customers__address')->updateOrInsert(
                ['customer_address_id' => $customer_address_id],
                [
                    'customer_id' => $customer_id,
                    'customer_mobile' => $customer_mobile,
                    'customer_name' => $customer_name,
                    'customer_pincode' => $customer_pincode,
                    'customer_locality' => $customer_locality,
                    'customer_address' => $customer_address,
                    'customer_city' => $customer_city,
                    'state_id' => $state_id,
                    'customer_default_address' => $customer_default_address,
                ]
            );

            return ["success" => true];
        } catch (\Throwable $th) {
            return ["success" => false, "message" => "Oops, an error occurred", "err" => $th->getMessage()];
        }
    }
}


