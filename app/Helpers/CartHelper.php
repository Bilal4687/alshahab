<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
class CartHelper
{
    public static function addToCart($product_id,$product_name,$product_image,$product_price_id,$product_sale_price,$product_mrp_price,$product_variation_id,$variation_id,$variation_value,$product_attribute_id,$attribute_id,$attribute_value,$quantity)
    {
        if(Session::get('id') == ""){
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
            if(self::checkItemExistInCart($product_id)){
                self::updateCartItemQty($product_id, $quantity);
            }else{
                Session::put('Cart', $cart);
            }
        }else{
            $Customer_id = Session::get('id');

            $existingCartItem = DB::table('cart')
            ->where('customer_id', $Customer_id)
            ->where('product_id', $product_id)
            ->first();

            if ($existingCartItem) {
                CartHelper::updateCartItemQty($product_id, $quantity);
            }else{
                $Cart = DB::table('cart')
                ->insert(
                        ['product_id' => $product_id,
                        'product_price_id' => $product_price_id,
                        'product_variation_id' => $variation_id,
                        'product_attribute_id' => $attribute_id,
                        'customer_id' => $Customer_id,
                        'quantity' => $quantity
                ]);
            }
        }
        return true;
    }
    public static function checkItemExistInCart($product_id)
    {
        $customerId = Session::get('id');
        $cart = Session::get('Cart', []);

        if ($customerId) {

            $cartItem = DB::table('cart')
                ->where('customer_id', $customerId)
                ->where('product_id', $product_id)
                ->get();

            return $cartItem !== null;

        } else {

            if (is_array($cart)) {
                foreach ($cart as $item) {
                    if ($item['product_id'] == $product_id) {
                        return true;
                    }
                }
            }

            return false;
        }
    }
    public static function updateCartItemQty($product_id, $quantity)
{
    $customerId = Session::get('id');

    if (!$customerId) {
        $cart = Session::get('Cart', []);

        foreach ($cart as $key => $item) {
            if ($item['product_id'] == $product_id) {

                if($quantity < $item['quantity'])
                {
                    $newQuantity = $item['quantity'] - 1;
                    $cart[$key]['quantity'] = $newQuantity;
                    break;
                }else
                {
                    $newQuantity = $item['quantity'] + 1;
                    $cart[$key]['quantity'] = $newQuantity;
                    break;
                }
            }
        }

        Session::put('Cart', $cart);
    } else {
        $cartItem = DB::table('cart')
            ->where('customer_id', $customerId)
            ->where('product_id', $product_id)
            ->first();

        if ($cartItem) {
            $CartQty = $cartItem->quantity;

            if ($quantity < $CartQty) {
                $newQuantity = $CartQty - 1;
            } else {
                $newQuantity = $CartQty + 1;
            }

            DB::table('cart')
                ->where('cart_id', $cartItem->cart_id)
                ->update([
                    'quantity' => $newQuantity,
                    'updated_at' => now(),
                ]);
        }
    }
}


public static function deleteCartItem($productID)
{
    $customerId = Session::get('id');

    if (!$customerId) {
        $cart = Session::get('Cart', []);

        foreach ($cart as $key => $item) {
            if ($item['product_id'] == $productID) {
                unset($cart[$key]); // Remove the item from the array
                break;
            }
        }

        Session::put('Cart', $cart); // Update the session
    } else {
        DB::table('cart')
            ->where('customer_id', $customerId)
            ->where('product_id', $productID)
            ->delete();
    }
}



    public static function getCart()
    {
        $items = [];

        if (empty(Session::get('id'))) {

            $cartItems = Session::get('Cart');

        } else
        {
            $customerId = Session::get('id');
            $cartItems = DB::table('cart')
            ->Join('products', 'products.product_id', '=', 'cart.product_id')
            ->Join('products__pricing', 'products__pricing.product_price_id', '=', 'cart.product_price_id')
            ->Join('products__attributes', 'products__attributes.product_attribute_id', '=', 'cart.product_attribute_id')
            ->Join('products__variations', 'products__variations.product_variation_id', '=', 'cart.product_variation_id')
            ->where('cart.customer_id', $customerId)
            ->select(
                'cart.cart_id',
                'cart.quantity',
                'products.product_id',
                'products.product_name',
                'products.product_thumbnail',
                'products__pricing.product_price_id',
                'products__pricing.sale_price',
                'products__pricing.mrp_price',
                'products__variations.product_variation_id',
                'products__variations.variation_id',
                'products__variations.variation_value',
                'products__attributes.product_attribute_id',
                'products__attributes.attribute_id',
                'products__attributes.attribute_value'
                )
                ->get();
        }
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



}

