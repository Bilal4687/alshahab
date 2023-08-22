<?php

namespace App\Http\Controllers\Website\Cart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function Checkout(){
        return view('Website.Cart.Checkout');
    }
}
