<?php

namespace App\Services;

use App\Http\Requests\CartRequest;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartService
{
    // public function createCart(CartRequest $request)
    // { {
    //         $addCart = Cart::create(array_merge($request->all(), 
    //         ['user_id' => auth()->id()]));
    //         return $addCart;
    //     }
    // }
    
    public function createCart(CartRequest $request)
    {
        $cartData = $request->all();
        $cartData['user_id'] = auth()->id();
        $cartData['date'] = now()->format('Y-m-d'); 
    
        $products = [];
        foreach ($request->input('products') as $product) {
            $products[] = [
                'product_id' => $product['id'],
                'quantity' => $product['quantity'],
            ];
        }
        $cartData['products'] = $products;
    
        $addCart = Cart::create($cartData);
        return $addCart;
    }
   
}