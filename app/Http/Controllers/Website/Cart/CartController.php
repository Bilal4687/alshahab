<?php

namespace App\Http\Controllers\Website\Cart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\CartHelper;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function AddToCart(Request $req)
    {

        // dd($req);
        // return false;
        $product_id = $req->input('product_id');
        $product_price_id = $req->input('product_price_id');
        $variation_id = $req->input('variation_id');
        $product_attribute_id = $req->input('attribute_id');
        $cond = $req->input('cond');

        // dd('Data', compact('product_id', 'product_price_id','variation_id','product_attribute_id'));
        // return false;

        $product = DB::table('products')
        ->join('products__pricing', 'products__pricing.product_id', '=', 'products.product_id')
        ->join('products__attributes', 'products__attributes.product_id', '=', 'products.product_id')
        ->join('products__variations', 'products__variations.product_id', '=', 'products.product_id')
        ->where('products__variations.variation_id', $variation_id)
        ->where('products__pricing.product_price_id', $product_price_id)
        ->where('products__attributes.product_attribute_id', $product_attribute_id)
        ->where('products.product_id', $product_id)
        ->first();

        // dd($product);
        // return false;

        $cartData = [
            $product_id = $product->product_id,
            $product_name = $product->product_name,
            $product_image = $product->product_thumbnail,
            $product_price_id = $product->product_price_id,
            $product_sale_price = $product->sale_price,
            $product_mrp_price = $product->mrp_price,
            $product_variation_id = $product->product_variation_id,
            $variation_id = $product->variation_id,
            $variation_value = $product->variation_value,
            $product_attribute_id = $product->product_attribute_id,
            $attribute_id = $product->attribute_id,
            $attribute_value = $product->attribute_value,
            $quantity = $product->quantity ?? '1',
            $cond = true
        ];
        $addToCart = CartHelper::addToCart(...array_values($cartData));
        if ($cartData) {
            $addToCart;
        }
        return response()->json(['success' => true]);
    }

    public function ViewCart()
    {
        //       session::flush('Cart');
        // dd(session::get('Cart'));
        // return false;
        $CartItems = CartHelper::getCart();
        return view('Website.Cart.CartItems', ['CartItems' => $CartItems]);
    }
    public function RemoveFromCart(Request $req)
    {
        // return false;
        $product_id = $req->input('pid');
        $product_price_id = $req->input('productPriceId');
        CartHelper::deleteCartItem($product_id, $product_price_id);

        return response()->json(['success' => true, 'message' => 'Successfully removed']);
    }

    public function updateCart(Request $request)
    {
        $product_id = $request->input('id');
        $quantity = $request->input('quantity');
        $product_price_id = $request->input('PriceId');
        $cond = $request->input('cond');
        CartHelper::updateCartItemQty($product_id, $quantity, $product_price_id, $cond);
        return response()->json(['message' => 'Cart updated successfully']);
    }
}
