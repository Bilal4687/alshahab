<?php

namespace App\Http\Controllers\Website\Cart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Helpers\CartHelper;

class CartController extends Controller
{
    public function AddToCart(Request $req)
    {
        $product_id = $req->input('product_id');
        $product = DB::table('products')
            ->join('products__pricing', 'products__pricing.product_id', '=', 'products.product_id')
            ->join('products__attributes', 'products__attributes.product_id', '=', 'products.product_id')
            ->join('products__variations', 'products__variations.product_id', '=', 'products.product_id')
            ->where('products.product_id', $product_id)
            ->first();

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
            $quantity = $product->quantity ?? '1'
        ];

        $addToCart = CartHelper::addToCart(...array_values($cartData));

        if (Session::get('id') == "") {
            $addToCart;
        } else {
            $addToCart;
        }
        return response()->json(['success' => true]);
    }

    public function ViewCart()
    {
        $CartItems = CartHelper::getCart();
        return view('Website.Cart.CartItems', ['CartItems' => $CartItems]);
    }
    public function RemoveFromCart(Request $req)
    {
        $productID = $req->input('id');

        CartHelper::deleteCartItem($productID);

        return response()->json(['success' => true, 'message' => 'Successfully removed']);
    }

    public function updateCart(Request $request)
    {
        $product_id = $request->input('id');
        $quantity = $request->input('quantity');

        CartHelper::updateCartItemQty($product_id, $quantity);
        return response()->json(['message' => 'Cart updated successfully']);
    }
}
