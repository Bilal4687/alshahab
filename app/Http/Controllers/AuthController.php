<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    function AdminLogin()
    {
        //      $admin_id = Session::get('admin_id');
        // $admin_name = Session::get('admin_name');
        // $admin_email = Session::get('admin_email');
        // $admin_token = Session::get('admin_token');

        // dd('data', compact('admin_id', 'admin_name', 'admin_email', 'admin_token'));

        return view('Admin.AdminLogin');
    }
    function AdminLoginStore(Request $req)
    {
        // dd(Hash::make($req->input('password')));

        $validator = Validator::make($req->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json(["validate" => true, "message" =>$validator->errors()->all()[0]]);
        }

        $user = DB::table('users')->where(["email" => $req->input('email')])->first();
        // dd($user);
        if(!$user){
        return response()->json(["success" => false, "message" => "Invalid Credential"]);
        }

        if(Hash::check($req->input('password'), $user->password)){
            Session::put('admin_id', $user->id);
            Session::put('admin_name', $user->name);
            Session::put('admin_email', $user->email);
            Session::put('admin_token', Hash::make(env('TOKEN_SECRET', false)));
            Session::save();
            return response()->json(["success" => true, "message" => "Login Successfull...Redirecting"]);
        }
        else{
            return response()->json(["success" => false, "message" => "Invalid Credential"]);
        }
    }


    function Dashboard()
    {
        // $admin_id = Session::get('admin_id');
        // $admin_name = Session::get('admin_name');
        // $admin_email = Session::get('admin_email');
        // $admin_token = Session::get('admin_token');

        // dd('data', compact('admin_id', 'admin_name', 'admin_email', 'admin_token'));


        $category = DB::table('categories')->count();
        $slider = DB::table('home__sliders')->count();
        $attribute = DB::table('attributes')->count();
        $brands = DB::table('brands')->count();
        $discount = DB::table('discounts')->count();
        $products = DB::table('products')->count();
        $variations = DB::table('variations')->count();

        return view('Admin.Dashboard', [
            'category' => $category, 'slider' => $slider,
            'attribute' => $attribute, 'brands' => $brands,
            'discount' => $discount, 'products' =>  $products,
            'variationss' => $variations
        ]);
    }

    function AdminLogout(){

        Session::forget('admin_id', 'admin_name', 'admin_email','admin_password', 'admin_token');
        return view('Admin.AdminLogin');

    }
}
