<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class CartHelper
{
    public static function addToCart(
        $product_id,
        $product_name,
        $product_image,
        $product_price_id,
        $product_sale_price,
        $product_mrp_price,
        $product_variation_id,
        $variation_id,
        $variation_value,
        $product_attribute_id,
        $attribute_id,
        $attribute_value,
        $quantity,
        $cond
    ) {


        $cart = Session::get('Cart');
        $cart[] = [
            'product_id' => $product_id,
            'product_name' => $product_name,
            'product_thumbnail' => $product_image,

            'products__pricing' => [
                'product_price_id' => $product_price_id,
                'sale_price' => $product_sale_price,
                'mrp_price' => $product_mrp_price,
            ],
            'products__variations' => [
                'product_variation_id' => $product_variation_id,
                'variation_id' => $variation_id,
                'variation_value' => $variation_value
            ],

            'products__attributes' => [
                'product_attribute_id' => $product_attribute_id,
                'attribute_id' => $attribute_id,
                'attribute_value' => $attribute_value
            ],

            'quantity' => $quantity
        ];
        if (self::checkItemExistInCart($product_id, $product_price_id)) {
            self::updateCartItemQty($product_id, $quantity, $product_price_id, $cond);
        } else {
            Session::put('Cart', $cart);
        }


        return true;
    }
    public static function checkItemExistInCart($product_id, $product_price_id)
    {

        $cart = Session::get('Cart', []);

        if (is_array($cart)) {
            foreach ($cart as $item) {

                if ($item['product_id'] == $product_id && $item['products__pricing']['product_price_id'] == $product_price_id) {

                    return true;
                }
            }
        }

        return false;
    }
    public static function updateCartItemQty($product_id, $quantity, $product_price_id, $cond)
    {
        $cart = Session::get('Cart', []);
        if($cond === true){
            // dd('add to cart');
            foreach ($cart as $key => $item) {
                if (
                    $item['product_id'] == $product_id &&
                    $item['products__pricing']['product_price_id'] == $product_price_id
                ) {

                    $existingQuantity = $item['quantity'];
                    if ($quantity <= $existingQuantity) {
                        $newQuantity = $existingQuantity + 1;
                        $cart[$key]['quantity'] = $newQuantity;
                    }else{
                    }

                }
            }
        }else{
            // dd('cart list ');
            foreach ($cart as $key => $item) {
                if (
                    $item['product_id'] == $product_id &&
                    $item['products__pricing']['product_price_id'] == $product_price_id
                ) {

                    $existingQuantity = $item['quantity'];
                    if ($quantity < $existingQuantity) {
                        // dd('enter');
                        $newQuantity = $existingQuantity - 1;
                        $cart[$key]['quantity'] = $newQuantity;
                    } else {
                        // dd('exit');
                        $newQuantity = $item['quantity'] + 1;
                        $cart[$key]['quantity'] = $newQuantity;
                    }

                    break;
                }
            }
        }

        Session::put('Cart', $cart);
    }




    public static function deleteCartItem($productID, $product_price_id)
    {
        $cart = Session::get('Cart', []);

        foreach ($cart as $key => $item) {
            if ($item['product_id'] == $productID && $item['products__pricing']['product_price_id'] == $product_price_id) {
                unset($cart[$key]);
                break;
            }
        }

        Session::put('Cart', $cart);
    }



    public static function getCart()
    {
        $items = [];


        $cartItems = Session::get('Cart');
        if ($cartItems) {

            foreach ($cartItems as $item) {
                $productId = isset($item->product_id) ? $item->product_id : $item['product_id'];
                $productName = isset($item->product_name) ? $item->product_name : $item['product_name'];
                $productThumbnail = isset($item->product_thumbnail) ? $item->product_thumbnail : $item['product_thumbnail'];

                $productPricing = [
                    'product_price_id' => isset($item->product_price_id) ? $item->product_price_id : $item['products__pricing']['product_price_id'],
                    'sale_price' => isset($item->sale_price) ? $item->sale_price : $item['products__pricing']['sale_price'],
                    'mrp_price' => isset($item->mrp_price) ? $item->mrp_price : $item['products__pricing']['mrp_price'],
                ];

                $productVariations = [
                    'product_variation_id' => isset($item->product_variation_id) ? $item->product_variation_id : $item['products__variations']['product_variation_id'],
                    'variation_id' => isset($item->variation_id) ? $item->variation_id : $item['products__variations']['variation_id'],
                    'variation_value' => isset($item->variation_value) ? $item->variation_value : $item['products__variations']['variation_value'],
                ];

                $productAttributes = [
                    'product_attribute_id' => isset($item->product_attribute_id) ? $item->product_attribute_id : $item['products__attributes']['product_attribute_id'],
                    'attribute_id' => isset($item->attribute_id) ? $item->attribute_id : $item['products__attributes']['attribute_id'],
                    'attribute_value' => isset($item->attribute_value) ? $item->attribute_value : $item['products__attributes']['attribute_value'],
                ];

                $items[] = [
                    'product_id' => $productId,
                    'product_name' => $productName,
                    'product_thumbnail' => $productThumbnail,
                    'products__pricing' => $productPricing,
                    'products__variations' => $productVariations,
                    'products__attributes' => $productAttributes,
                    'quantity' => isset($item->quantity) ? $item->quantity : $item['quantity']
                ];
            }
        }

        return  $items;
    }
    public static function transferSessionToCartTable($userId)
    {
        $cartItems = Session::get('Cart', []);

        if (!empty($cartItems)) {
            foreach ($cartItems as $item) {
                $productId = isset($item['product_id']) ? $item['product_id'] : null;
                $productPriceId = isset($item['products__pricing']['product_price_id']) ? $item['products__pricing']['product_price_id'] : null;
                $productVariationId = isset($item['products__variations']['product_variation_id']) ? $item['products__variations']['product_variation_id'] : null;
                $productAttributeId = isset($item['products__attributes']['product_attribute_id']) ? $item['products__attributes']['product_attribute_id'] : null;
                $quantity = isset($item['quantity']) ? $item['quantity'] : 1;

                // Check if the product already exists in the cart for the customer
                $existingCartItem = DB::table('cart')
                    ->where('customer_id', $userId)
                    ->where('product_id', $productId)
                    ->first();

                if ($existingCartItem) {
                    // Update the existing cart item with session data
                    DB::table('cart')
                        ->where('customer_id', $userId)
                        ->where('product_id', $productId)
                        ->update([
                            'product_price_id' => $productPriceId,
                            'product_variation_id' => $productVariationId,
                            'product_attribute_id' => $productAttributeId,
                            'quantity' => $quantity,
                            'updated_at' => now(),
                        ]);
                } else {
                    // Insert the cart item into the database cart table
                    DB::table('cart')->insert([
                        'customer_id' => $userId,
                        'product_id' => $productId,
                        'product_price_id' => $productPriceId,
                        'product_variation_id' => $productVariationId,
                        'product_attribute_id' => $productAttributeId,
                        'quantity' => $quantity,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            // Clear the cart session after transferring to the database
            Session::forget('Cart');
        }
    }
    public static function ProcessPayment($paymentMethod, $req)
    {
        if ($paymentMethod == 'cash_on_delivery') {

            $customerId = $req->input('customerId');

            $Customer_address = DB::table('customers__address')
                ->where('customer_id', $customerId)
                ->where('customer_default_address', 1)
                ->first();

            $cart = DB::table('cart')
                ->join('products__pricing', 'products__pricing.product_price_id', '=', 'cart.product_price_id')
                ->where('cart.customer_id', $customerId)
                ->get();

            if ($cart->isEmpty()) {
                return response()->json(['success' => false, 'message' => 'Sorry Your Cart Is Empty...!']);
            } else {

                $order = DB::table('orders')->insert([
                    'customer_id' => $customerId,
                    'order_status' => 0,
                    'total_amount' => $req->input('GrandTotal'),
                    'payment_method' => 'Cash On Deliver',
                    'order_date' => now(),
                ]);

                $order_id = DB::getPdo()->lastInsertId();


                if ($order) {
                    $cart = DB::table('cart')
                        ->join('products__pricing', 'products__pricing.product_price_id', '=', 'cart.product_price_id')
                        ->where('cart.customer_id', $customerId)
                        ->get();

                    foreach ($cart as $item) {
                        $cart_items = DB::table('orders__items')->insert([
                            'order_id' => $order_id,
                            'customer_id' => $item->customer_id,
                            'product_id' => $item->product_id,
                            'product_price' => $item->sale_price,
                            'item_qty' => $item->quantity,
                            'order_item_status' => 0
                        ]);
                    }
                    $orders__address = DB::table('orders__address')->insert([
                        'customer_id' => $customerId,
                        'customer_name' => $Customer_address->customer_name,
                        'customer_mobile' => $Customer_address->customer_mobile,
                        'customer_pincode' => $Customer_address->customer_pincode,
                        'customer_locality' => $Customer_address->customer_locality,
                        'customer_address' => $Customer_address->customer_address,
                        'customer_city' => $Customer_address->customer_city,
                        'state_id' => $Customer_address->state_id
                    ]);
                    $cart = DB::table('cart')->where('customer_id', $customerId)->delete();

                    return response()->json(['success' => true, 'message' => 'Order Placed Successfully...']);
                } else {
                    return response()->json(['success' => false, 'message' => 'Your Cart is Empty...!']);
                }
            }
            return 'Cash on Delivery successful';
        } elseif ($paymentMethod == 'paypal') {



            return 'PayPal payment successful';
        } elseif ($paymentMethod == 'credit_card') {


            return 'Credit card payment successful';
        } else {
            return 'Invalid payment method';
        }
    }
}
