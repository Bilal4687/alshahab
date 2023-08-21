<?php

namespace App\Http\Controllers\Website\Cart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;

class CartController extends Controller
{
    public function AddToCart(Request $req)
    {
         $productDetails = [
                'product_id' => $req->input('product_id')
            ];
            $req->session()->push('cart', $productDetails);

            return response()->json(['success' => true]);

    }
    public function CartDetail(){
        $cart = Session::get('cart', []);
        return view('Website.Cart.CartItems', ['cart' => $cart]);
    }

}
