<?php

namespace App\Http\Controllers\Website\Cart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use Illuminate\Support\Facades\Validator;
class CheckoutController extends Controller
{
    public function AddressCardContent(){
        $customerData = DB::table('customers__address')->orderBy('created_at', 'desc')
        ->latest() 
        ->first();
    

         $view = view('Website.Cart.Partials.address_card', ['customerData' => $customerData])->render();
        return response()->json(['data' => $view]);
    
    }
    public function ViewBagContent(){
    
        // $data = Session::get('Cart');

         $view = view('Website.Cart.Partials.OrderSummaryCard')->render();
     
        return response()->json(['data' => $view]);
    
    }
    public function YourOrderContent(){
    

         $view = view('Website.Cart.Partials.YourOrderCard')->render();
     
        return response()->json(['data' => $view]);
    
    }
    public function Checkout(){

        if(Session::get('id') == null){
            return view('Website.Authentication.Login');
        }
        else
        {
            $id = Session::get('id');
            $State = DB::table('states')->get();

            $Customer_id = DB::table('customers')->where('customer_id', $id)->first();

            $Customer = DB::table('customers')
            ->leftJoin('customers__address', 'customers__address.customer_id', '=', 'customers.customer_id')
            ->leftJoin('states', 'states.state_id', '=', 'customers__address.state_id')
            ->select('customers.*', 'states.*', 'customers__address.*') // Select the specific columns you need
            ->where('customers.customer_id', $id)
            ->orderBy('customers__address.created_at', 'desc') // Order addresses by created_at in descending order
            ->latest() // Retrieve the latest (most recent) address
            ->first();

            return view('Website.Cart.Checkout',["CustomerData" => $Customer, "StateData" => $State, "Customer_id" => $Customer_id]);
        }
    }
    public function RazorPayPayment(Request $req){

        // $data = $req->all();
        // dd($data);
        // return false;
        if(Session::get('Cart')){
            $total = 0;
            foreach(Session::get('Cart') as $itemdata){
                $product = DB::table('products')
                ->join('products__pricing', 'products__pricing.product_id', '=', 'products.product_id')
                ->join('products__attributes', 'products__attributes.product_id', '=', 'products.product_id')
                ->join('products__variations', 'products__variations.product_id', '=', 'products.product_id')
                ->select('products__pricing.*', 'products.*', 'products__attributes.*', 'products__variations.*')
                ->where('products.product_id', $itemdata['product_id'])
                ->first();
                $price_value = $product->sale_price;

                $total = $total + ($itemdata['quantity'] * $price_value);
                $cartProducts[] = $product;
                // $product = DB::table('products')->where('product_id', $itemdata['product_id'])->get();
            }

            return response()->json(['success' => true,'data' => $cartProducts, 'GrandTotal' =>  $total]);
        }
        else{
                return response()->json(['success' => false, 'message' => 'Your Cart Is Empty']);
        }
    }
    public function CheckOutDetail(Request $req)
    {
        $sessionData = $req->session()->get('Cart');
        $productIds = array_column($sessionData, 'product_id');
        $customerId = $req->input('customer_id');

        foreach ($productIds as $productId) {
            DB::table('cart')->insert([
                'customer_id' => $customerId,
                'product_id' => $productId,
            ]);
        }

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
                'customer_id' => $customerId,
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
    public function CheckOutDetailUpdate(Request $req)
    {
          $sessionData = $req->session()->get('Cart');
        $productIds = array_column($sessionData, 'product_id');
        $customerId = $req->input('customer_id');

        foreach ($productIds as $productId) {
            DB::table('cart')->insert([
                'customer_id' => $customerId,
                'product_id' => $productId,
            ]);
        }

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
    public function PlaceOrder(){
        return view('Website.Cart.PlaceOrder');
    }
}
