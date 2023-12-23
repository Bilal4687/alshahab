<?php

namespace App\Http\Controllers\Website\Cart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Helpers\CartHelper;
use Exception;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

class CheckoutController extends Controller
{

    public function Invoice(){
        return view('Website.Invoice.Invoice');
    }
    public function OrderConfirm(){
        return view('Website.OrderConfirmation.Thanks');
    }
    public function Checkout(Request $req)
    {

        $CustomerId = Session::get('customer_id');

        if (!$CustomerId) {
            return view('Website.Cart.Checkout');
        } else {
            $id = Session::get('customer_id');
            $State = DB::table('states')->get();

            $Customer_id = DB::table('customers')->where('customer_id', $id)->first();

            $Customer = DB::table('customers')
                ->leftJoin('customers__address', 'customers__address.customer_id', '=', 'customers.customer_id')
                ->leftJoin('states', 'states.state_id', '=', 'customers__address.state_id')
                ->select('customers.*', 'states.*', 'customers__address.*')
                ->where('customers.customer_id', $id)
                ->where('customers__address.customer_default_address', 1)
                ->latest()
                ->first();


            // dd('Customer', $Customer);
            return view('Website.Cart.Checkout', ["CustomerData" => $Customer, "StateData" => $State, "Customer_id" => $Customer_id]);
        }
    }

    // Check Customer LOgin Flow And Transfer Session Data to cart
    public function CheckoutLoginFlow(Request $req)
    {

        $validator = Validator::make($req->all(), [
            'customer_email' => 'required|email',
            'customer_password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(["validate" => true, "message" => $validator->errors()->all()[0]]);
        }

        $Customer = DB::table('customers')->where(["customer_email" => $req->input('customer_email')])->first();

        if (!$Customer) {
            return response()->json(["success" => false, "message" => "Invalid Credential"]);
        }
        if (Hash::check($req->input('customer_password'), $Customer->customer_password)) {
            Session::put('id', $Customer->customer_id);
            Session::put('name', $Customer->customer_name);
            Session::put('email', $Customer->customer_email);
            Session::put('token', Hash::make(env('TOKEN_SECRET', false)));
            Session::save();

            CartHelper::transferSessionToCartTable($Customer->customer_id);

            return response()->json(["success" => true, "message" => "Login Successfull...Redirecting"]);
        } else {
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
        $customer_default_address = $req->has('customer_default_address_checkbox') ? 1 : 0;
        try {
            $Customer_data = DB::table('customers__address')->insert([
                'customer_id' => $req->input('customer_id'),
                'customer_mobile' => $req->input('customer_mobile'),
                'customer_name' => $req->input('customer_name'),
                'customer_pincode' => $req->input('customer_pincode'),
                'customer_locality' => $req->input('customer_locality'),
                'customer_address' => $req->input('customer_address'),
                'customer_city' => $req->input('customer_city'),
                'state_id' => $req->input('state_id'),
                'customer_default_address' => $customer_default_address
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
            'customer_mobile' => 'required|regex:/^[0-9]{10}$/',
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
        $customer_default_address = $req->has('customer_default_address') ? 1 : 0;


        try {
            $Customer_data = DB::table('customers__address')
                ->updateOrInsert(
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
                        'customer_default_address' => $customer_default_address
                    ]
                );

            return response()->json(["success" => true]);
        } catch (\Throwable $th) {
            return response()->json(["success" => false, "message" => "Opps an Error Occured", "err" => $th->getMessage()]);
        }
    }
    public function PlaceOrder(Request $req)
    {

            $api = new Api(config('services.razorpay.key_id'), config('services.razorpay.key_secret'));

            $order_id = $req->input('razorpay_order_id');

            $order = $api->order->fetch($order_id);

            if ($order->status === 'paid') {


                    $customerId  = $req->input('customerId');

                    $Payment_id = $req->input('payment_id');


                    $Customer_address = DB::table('customers__address')
                                        ->where('customer_id', $customerId)
                                        ->where('customer_default_address', 1)
                                        ->first();
                    
                    
                    $cart = CartHelper::getCart();

                    // dd('data', compact('customerId', 'Payment_id', 'Customer_address', 'cart'));
                    // return false;

                    // $cart = DB::table('cart')
                    //     ->join('products__pricing', 'products__pricing.product_price_id', '=', 'cart.product_price_id')
                    //     ->where('cart.customer_id', $customerId)
                    //     ->get();

                    if (empty($cart)) {
                        // dd('yes session is empty');
                        return response()->json(['success' => false, 'message' => 'Sorry Your Cart Is Empty...!']);
                    } else {
                        // dd('yes session has data');
                        $order = DB::table('orders')->insert([
                            'customer_id' => $customerId,
                            'order_status' => 0,
                            'total_amount' => $req->input('GrandTotal'),
                            'payment_method' => 'Online',
                            'payment_no' => $Payment_id,
                            'voucher_id' => 1,
                            'order_date' => now(),
                        ]);

                        $order_id = DB::getPdo()->lastInsertId();


                        if ($order) {
                       
                            $cart = CartHelper::getCart();
                            
                            foreach ($cart as $item) {
                                $cart_items = DB::table('orders__items')->insert([
                                    'order_id' => $order_id,
                                    'customer_id' => $customerId,
                                    'product_id' => $item['product_id'],
                                    'product_price' => $item['products__pricing']['sale_price'],
                                    'item_qty' => $item['quantity'],
                                    'order_item_status' => 0
                                ]);
                            }
                            $orders__address = DB::table('orders__address')->insert([
                                'customer_id' => $customerId,
                                'customer_name' => $Customer_address->customer_name,
                                'customer_mobile' => $Customer_address->customer_mobile,
                                'customer_pincode' => $Customer_address->customer_pincode,
                                'customer_locality' => $Customer_address->customer_locality,
                                'customer_address' => $Customer_address->customer_address,
                                'customer_city' => $Customer_address->customer_city,
                                'state_id' => $Customer_address->state_id
                            ]); 

                            $cart = Session::forget('cart');
                            // dd($cart);   
                            // session()->forget('my_name');
                            // $cart = DB::table('cart')->where('customer_id', $customerId)->delete();

                            return response()->json(['success' => true, 'order_detail' => $order,'message' => 'Order Placed Successfully...']);

                        } else {
                            return response()->json(['success' => false, 'message' => 'Your Cart is Empty...!']);
                        }
                    }

                return redirect('/success');
            } else {



                return redirect('/failure');
            }
    }

    public function CodPlaceOrder(Request $req)
    {

        $paymentMethod = $req->input('payment_method');

        $result = CartHelper::ProcessPayment($paymentMethod,$req);

        return response()->json(['message' => $result]);
    }
// public function RazorPayPayment(Request $req)
// {

//     $input = $req->all();

//     $validator = Validator::make($input, [
//         'razorpay_payment_id' => 'required',
//     ]);

//     if ($validator->fails()) {
//         return redirect()->back()->withErrors($validator);
//     }

//     $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

//     try {
//         $payment = $api->payment->fetch($input['razorpay_payment_id']);

//         $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(['amount' => $payment['amount']]);

//          Session::put('success', 'Payment successful');

//          return redirect()->back();

//     } catch (Exception $e) {

//          Session::put('error', $e->getMessage());
//          return redirect()->back();

//     }
// }

public function ProcessRazorPayPayment(Request $req)
{


    $api = new Api(config('services.razorpay.key_id'), config('services.razorpay.key_secret'));


    $order = $api->order->create([
        'amount' => $req->input('GrandTotal'), // The order amount
        'currency' => 'INR',
        'payment_capture' => 1, // Auto capture payment
    ]);



    $customerId = $req->input('customerId');

    // $cart = DB::table('cart')
    // ->join('products__pricing', 'products__pricing.product_price_id', '=', 'cart.product_price_id')
    // ->join('customers', 'customers.customer_id', '=', 'cart.customer_id')
    // ->join('customers__address', 'customers__address.customer_id', '=', 'cart.customer_id')
    // ->where('cart.customer_id', $customerId)
    // ->where('customers__address.customer_default_address', 1)
    // ->get();

    $cart = CartHelper::getCart();
    
    $customerInfo = DB::table('customers')->
                        join('customers__address','customers__address.customer_id', '=' , 'customers.customer_id')
                        ->where('customers.customer_id', $customerId)
                        ->get();

    // dd($customerInfo);
    $total_price = 0;

    foreach($cart as $item){

        $total_price += $item['products__pricing']['sale_price'] * $item['quantity'];

    }
    // dd($total_price);



    return response()->json(['success' => true, 'data' => $cart, 'customerInfo' => $customerInfo,'GrandTotal' => $total_price, 'order_id' => $order->id]);

}
}
