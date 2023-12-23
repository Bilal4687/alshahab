<?php

namespace App\Http\Controllers\Website\MyAccount;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Helpers\AddressHelper;
use App\Helpers\CartHelper;
use Illuminate\Support\Facades\Hash;

class MyAccountController extends Controller
{
    public function Login(){
        $customer_id = Session::get('customer_id');
        $CartItem = DB::table('cart')->where('customer_id', $customer_id)->get();

        return view('Website.Authentication.Login', ["CartItem" => $CartItem]);
    }
    public function NewRegistration(){
        return view('Website.Authentication.Register');
    }
    public function RegisterCustomer(Request $req){

        $validator = Validator::make($req->all(), [
            'customer_name' => 'required',
            'customer_email' => 'required|email',
            'customer_password' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json(["validate" => true, "message" =>$validator->errors()->all()[0]]);
        }

        $passHash = Hash::make($req->input('customer_password'));

        $data = DB::table('customers')->where('customer_email',$req->input('customer_email'))->first();

        if($data)
        {
            return response()->json(['success' => false, 'message' => 'Email must Be Unique']);
        }
        else
        {
            $RegisterCustomer = DB::table('customers')->insert(
                ['customer_name' => $req->input('customer_name'),
                 'customer_email' => $req->input('customer_email'),
                 'customer_password' => $passHash
                ]
            );
            if($RegisterCustomer)
            {
                return response()->json(['success' => true, 'message' => 'Redirecting to Login Page...!']);
            }
            else
            {
                return response()->json(['success' => false, 'message' => 'Something Went Wrong']);
            }
        }
    }
    public function CustomerLogin(Request $req){

        $validator = Validator::make($req->all(), [
            'customer_email' => 'required|email',
            'customer_password' => 'required'
        ]);

        if($validator->fails()) {

            return response()->json(["validate" => true, "message" => $validator->errors()->all()[0]]);
        }

        $Customer = DB::table('customers')->where(["customer_email" => $req->input('customer_email')])->first();

        if(!$Customer){
        return response()->json(["success" => false, "message" => "UserName Or Password is Invalid"]);
        }

        if(Hash::check($req->input('customer_password'), $Customer->customer_password)){
            Session::put('customer_id', $Customer->customer_id);
            Session::put('customer_name', $Customer->customer_name);
            Session::put('customer_email', $Customer->customer_email);
            Session::put('customer_token', Hash::make( env('TOKEN_SECRET', false)));
            Session::save();
            // CartHelper::transferSessionToCartTable($Customer->customer_id);
            return response()->json(["success" => true, "message" => "Login Successfull...Redirecting"]);
        }
        else{
            return response()->json(["success" => false, "message" => "UserName Or Password is Invalid"]);
        }
    }
    public function Logout()
    {
        Session::forget(['customer_id', 'customer_name', 'customer_email', 'customer_token',]);
        return redirect('Login');
    }
    public function MyAccount()
    {
        $customer_id = Session::get('customer_id');

        $Customer_info = DB::table('customers')->where('customer_id',$customer_id)->get();
        $Customer_address_info = DB::table('customers__address')
                                    ->where('customer_id', $customer_id)
                                    ->where('customer_default_address', 1)
                                    ->first();

        return view('Website.MyAccount.MyProfile', ['data' => $Customer_info, 'Customer_address_info' => $Customer_address_info]);
    }
    public function ManageAddresses(){

        $customer_id = Session::get('customer_id');

        $Customer_address = DB::table('customers__address')->where('customer_id', $customer_id)->get();

        $State = DB::table('states')->get();

        $Customer_info = DB::table('customers')
                            ->join('customers__address','customers__address.customer_id','=','customers.customer_id')
                            ->where('customers.customer_id', $customer_id)
                            ->get();



        return view('Website.MyAccount.ManageAddresses',["Customer_info" => $Customer_info, "StateData" => $State, "Customer_address" => $Customer_address]);
    }
    public function OrderHistory(){

        $order_items = DB::table('orders__items')
                          ->join('customers','customers.customer_id','=','orders__items.customer_id')
                          ->join('products','products.product_id','=','orders__items.product_id')
                          ->select('orders__items.*','customers.*','products.*')
                          ->where('orders__items.customer_id', Session::get('id'))
                          ->get();



        return view('Website.MyAccount.OrderHistory', ['data' => $order_items]);
    }
    public function PrimaryAddressStore(Request $req)
    {
        $data = $req->all();
        // dd($data);
        $result = AddressHelper::storePrimaryAddress($data);

        if ($result["success"]) {
            return response()->json(["success" => true]);
        } else {
            return response()->json(["success" => false, "message" => $result["message"]]);
        }
    }
    public function EditAddress($customer_address_id){

        $State = DB::table('states')->get();

        $Customer_address_info = DB::table('customers__address')->where('customer_address_id', $customer_address_id)->first();

        return view('Website.MyAccount.EditAddress', ['Customer_address_info' => $Customer_address_info, 'StateData' => $State]);

    }
    public function SetAsDefault(Request $req){

        $customer_address_id = $req->input('customer_address_id');

        $customer_id = Session::get('customer_id');

        $hasDefaultAddress = DB::table('customers__address')
            ->where('customer_id', $customer_id)
            ->where('customer_default_address', 1)->first();

        if ($hasDefaultAddress) {

            DB::table('customers__address')
            ->where('customer_id',$hasDefaultAddress->customer_id)
            ->update(['customer_default_address' => 0]);
        }

        DB::table('customers__address')
            ->where('customer_address_id', $customer_address_id)
            ->update(['customer_default_address' => 1]);

        return response()->json(['success' => true]);
    }
    public function RemoveAddress(Request $req)
    {
        $customer_address_id =   $req->input('customer_address_id');

        $data = DB::table('customers__address')->where('customer_address_id', $customer_address_id)->delete();

        return response()->json(['success' => true, 'message' => 'Address Removed Successfully']);
    }

}
