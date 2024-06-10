<?php

namespace App\Services;

use App\Http\Requests\CartRequest;
use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\Product;
use Illuminate\Http\Request;

class CartService
{
    public function getCarts()
    {
        $carts = Cart::all();
        return $carts;
    }
    public function createCart(CartRequest $request)
    {
        $cartData = $request->only('date', 'products');
        $cart = Cart::create(['date' => $cartData['date'], 'user_id' => auth()->id()]);

        foreach ($cartData['products'] as $product) {
            CartProduct::create([
                'cart_id' => $cart->id,
                'quantity' => $product['quantity'],
                'product_id' => $product['product_id']
            ]);
        }
        return $cart;
    }

    public function updateCart(CartRequest $request, $cartId)
    {
        $cartData = $request->only('date', 'products');
        $cart = Cart::findOrFail($cartId);

        $cart->update(['date' => $cartData['date']]);
        foreach ($cartData['products'] as $product) {
            CartProduct::updateOrCreate(
                [
                    'cart_id' => $cartId,
                    'product_id' => $product['product_id']
                ],
                ['quantity' => $product['quantity']]
            );
        }
        CartProduct::where('cart_id', $cartId)
            ->whereNotIn('product_id', collect($cartData['products'])->pluck('product_id'))
            ->delete();

        return $cart;
    }

    public function updateCartStatus($cartId, $status)
    {
        $cart = Cart::findOrFail($cartId);
        $cart->update(['status' => $status]);
        return $cart;
    }
}
