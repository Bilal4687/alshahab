<?php

namespace App\Http\Controllers\Website\Cart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class CartController extends Controller
{
    public function AddToCart(Request $req)
    {
        $product_id = $req->input('product_id');
        $product = DB::table('products')
        ->join('products__pricing', 'products__pricing.product_id', '=', 'products.product_id')
        ->join('products__attributes', 'products__attributes.product_id', '=', 'products.product_id')
        ->join('products__variations', 'products__variations.product_id', '=', 'products.product_id')
        ->select('products__pricing.*', 'products.*', 'products__attributes.*', 'products__variations.*')
        ->where('products.product_id', $product_id)
        ->first();

        $Cart = session()->get('Cart', []);

        if(isset($Cart[$product_id])){
            $Cart[$product_id]['quantity']++;
        }else{
            $Cart[$product_id] = [
                'product_id' => $product->product_id ?? '',
                'product_name' => $product->product_name ?? '',
                'product_image' => $product->product_thumbnail ?? '',
                'product_sale_price' => $product->sale_price ?? '',
                'product_mrp_price' => $product->mrp_price ?? '',
                'product_variation' => $product->variation_value ?? '',
                'product_attribute' => $product->attribute_value ?? '',
                'quantity' => 1
            ];
        }

        session()->put('Cart', $Cart);

        return response()->json(['success' => true]);
    }
    public function CartDetail(){
        $cart = Session::get('cart', []);
        return view('Website.Cart.CartItems', ['cart' => $cart]);
    }
    public function RemoveFromCart(Request $req){

        if($req->input('id')){
            $Cart = session()->get('Cart');
            if(isset($Cart[$req->id])){
                unset($Cart[$req->id]);
                session()->put('Cart', $Cart);
            }
            session()->flash('success', 'Product Removed Successfully');
        }
        return response()->json(['success' => true, 'message' => 'Successfully removed']);
    }
    public function UpdateCart(Request $req){

        $productID = $req->input('id');
        $quantity = $req->input('quantity');

        if($productID && $quantity){

            $Cart = session()->get('Cart');

            $Cart[$req->id]['quantity'] = $req->quantity;

            session()->put('Cart', $Cart);

            session()->flash('success', "Product Updated Successfully");
        }
    }
}
