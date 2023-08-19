<?php

namespace App\Http\Controllers\Website\Cart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
class CartController extends Controller
{
    public function AddToCart($product){
        $cart = Session::get('cart');
        $product->cart_id = rand(1000000000,999999999999999);
        $cart[] = $product;
        Session::put('cart', $cart);
        Session::save();
        return true;
    }

}
