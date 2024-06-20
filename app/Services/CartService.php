<?php

namespace App\Services;
use App\Models\Cart;
use App\Models\CartProduct;

class CartService
{
    public function getCarts()
    {
        $carts = Cart::where('user_id', auth()->id())->get();
        $carts->load('cartProducts');
        return $carts;
    }

    public function createCart($request)
    {
        $cartData = $request->only('products');
        $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);
        foreach ($cartData['products'] as $product) {
            $existingCartProduct = CartProduct::where('cart_id', $cart->id)
                ->where('product_id', $product['product_id'])
                ->first();
            if ($existingCartProduct) {
                $existingCartProduct->quantity +=1;
                $existingCartProduct->save();
            } else {
                CartProduct::create([
                    'cart_id' => $cart->id,
                    'quantity' => $product['quantity'],
                    'product_id' => $product['product_id']
                ]);
            }
        }
        return $cart;
    }

    // public function createCart($request)
    // {
    //     $cartData = $request->only('products');
    //     $tempUserId = $request->input('userId');

    //     $cart = Cart::firstOrCreate(['user_id' => $tempUserId]);
    //     foreach ($cartData['products'] as $product) {
    //         $existingCartProduct = CartProduct::where('cart_id', $cart->id)
    //             ->where('product_id', $product['product_id'])
    //             ->first();
    //         if ($existingCartProduct) {
    //             $existingCartProduct->quantity +=1;
    //             $existingCartProduct->save();
    //         } else {
    //             CartProduct::create([
    //                 'cart_id' => $cart->id,
    //                 'quantity' => $product['quantity'],
    //                 'product_id' => $product['product_id']
    //             ]);
    //         }
    //     }
    //     return $cart;
    // }

    public function updateCart($request, $cartId)
    {
        $cartData = $request->only('products');
        $cart = Cart::findOrFail($cartId);
        foreach ($cartData['products'] as $product) {
            CartProduct::updateOrCreate(
                [
                    'cart_id' => $cartId,
                    'product_id' => $product['product_id']
                ],
                ['quantity' => $product['quantity']]
            );
        }
        return $cart;
    }

    public function updateCartStatus($cartId, $status)
    {
        $cart = Cart::findOrFail($cartId);
        $cart->update(['status' => $status]);
        return $cart;
    }

}
