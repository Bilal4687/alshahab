<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    function AdminLogin()
    {
        return view('Login');
    }

    function Dashboard()
    {
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
}
