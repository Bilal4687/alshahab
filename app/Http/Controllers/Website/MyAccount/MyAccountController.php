<?php

namespace App\Http\Controllers\Website\MyAccount;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Helpers\CartHelper;
use Illuminate\Support\Facades\Hash;

class MyAccountController extends Controller
{
    public function Login(){
        $customer_id = Session::get('id');
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
            'customer_mobile' => 'required',
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
    public function Logout()
    {
        Session::forget(['id', 'name', 'email', 'token',]);
        return redirect('Login');
    }
}
