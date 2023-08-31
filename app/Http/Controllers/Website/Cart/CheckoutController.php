<?php

namespace App\Http\Controllers\Website\Cart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Helpers\CartHelper;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

class CheckoutController extends Controller
{

    public function Checkout(Request $req)
    {
        $CustomerId = Session::get('id');

         if(!$CustomerId){
            return view('Website.Cart.Checkout');
        }
        else
        {
            $id = Session::get('id');
            $State = DB::table('states')->get();

            $Customer_id = DB::table('customers')->where('customer_id', $id)->first();

            $Customer = DB::table('customers')
            ->leftJoin('customers__address', 'customers__address.customer_id', '=', 'customers.customer_id')
            ->leftJoin('states', 'states.state_id', '=', 'customers__address.state_id')
            ->select('customers.*', 'states.*', 'customers__address.*')
            ->where('customers.customer_id', $id)
            ->orderBy('customers__address.created_at', 'desc')
            ->latest()
            ->first();

            return view('Website.Cart.Checkout',["CustomerData" => $Customer, "StateData" => $State, "Customer_id" => $Customer_id]);
        }
    }

    // Check Customer LOgin Flow And Transfer Session Data to cart
    public function CheckoutLoginFlow(Request $req)
    {

        $validator = Validator::make($req->all(), [
            'customer_email' => 'required|email',
            'customer_password' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json(["validate" => true, "message" =>$validator->errors()->all()[0]]);
        }

        $Customer = DB::table('customers')->where(["customer_email" => $req->input('customer_email')])->first();

        if(!$Customer){
        return response()->json(["success" => false, "message" => "Invalid Credential"]);
        }

        if(Hash::check($req->input('customer_password'), $Customer->customer_password)){
            Session::put('id', $Customer->customer_id);
            Session::put('name', $Customer->customer_name);
            Session::put('email', $Customer->customer_email);
            Session::put('token', Hash::make( env('TOKEN_SECRET', false)));
            Session::save();

            CartHelper::transferSessionToCartTable($Customer->customer_id);

            return response()->json(["success" => true, "message" => "Login Successfull...Redirecting"]);
        }
        else{
            return response()->json(["success" => false, "message" => "Invalid Credential"]);
        }

    }
    // Insert Customer New Address Or Primary Address

    public function CheckOutDetail(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'customer_name' => 'required',
            'customer_mobile' => 'required',
            'customer_pincode' => 'required',
            'customer_locality' => 'required',
            'customer_address' => 'required',
            'customer_city' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(["validate" => true, "message" => $validator->errors()->all()[0]]);
        }

        try {
            $Customer_data = DB::table('customers__address')->insert([
                'customer_id' => $req->input('customer_id'),
                'customer_mobile' => $req->input('customer_mobile'),
                'customer_name' => $req->input('customer_name'),
                'customer_pincode' => $req->input('customer_pincode'),
                'customer_locality' => $req->input('customer_locality'),
                'customer_address' => $req->input('customer_address'),
                'customer_city' => $req->input('customer_city'),
                'state_id' => $req->input('state_id')
            ]);

            return response()->json(["success" => true]);
        } catch (\Throwable $th) {
            return response()->json(["success" => false, "message" => "Opps an Error Occured", "err" => $th->getMessage()]);
        }

    }

    // Update Customer Existing Address

    public function CheckOutDetailUpdate(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'customer_name' => 'required',
            'customer_mobile' => 'required',
            'customer_pincode' => 'required',
            'customer_locality' => 'required',
            'customer_address' => 'required',
            'customer_city' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(["validate" => true, "message" => $validator->errors()->all()[0]]);
        }

        $customer_address_id = $req->input('customer_address_id');
        $customer_id = $req->input('customer_id');
        $customer_name = $req->input('customer_name');
        $customer_mobile = $req->input('customer_mobile');
        $customer_pincode = $req->input('customer_pincode');
        $customer_locality = $req->input('customer_locality');
        $customer_address = $req->input('customer_address');
        $customer_city = $req->input('customer_city');
        $state_id = $req->input('state_id');

        try {
            $Customer_data = DB::table('customers__address')
            ->updateOrInsert(
                ['customer_address_id' => $customer_address_id],
                [
                    'customer_mobile' => $customer_mobile,
                    'customer_name' => $customer_name,
                    'customer_pincode' => $customer_pincode,
                    'customer_locality' => $customer_locality,
                    'customer_address' => $customer_address,
                    'customer_city' => $customer_city,
                    'state_id' => $state_id
                ]
            );

            return response()->json(["success" => true]);
        } catch (\Throwable $th) {
            return response()->json(["success" => false, "message" => "Opps an Error Occured", "err" => $th->getMessage()]);
        }
    }
    public function RazorPayPayment(Request $req)
    {

    }

    public function PlaceOrder(Request $req){

        $order = DB::table('orders')->insert([
            'customer_id' => $req->input('customerId'),
            'order_status' => 0,
            'total_amount' => $req->input('GrandTotal'),
            'payment_method' => 'Cash On Deliver',
            'order_date' => now(),
        ]);



        if($order){


            return response()->json(['success' => true, 'message' => 'Order Placed Successfully...']);
        }else{


            return response()->json(['success' => false, 'message' => 'Opps Something Went Wrong...!']);
        }
    }
}
