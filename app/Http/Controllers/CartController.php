<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartRequest;
use App\Models\CartProduct;
use App\Services\CartService;

class CartController extends Controller
{
    protected $cartservice;

    public function __construct(CartService $cartService)
    {
        $this->cartservice = $cartService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $carts = $this->cartservice->getCarts();
            return response()->json([
                'status' => true,
                'carts' => $carts
            ]);
        } catch (\Throwable $th) {
            \Log::error('error' . $th->getMessage());
            return response()->json([
                'status' => false
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     * 
     */
    public function create()
    {

    }

    /*
     * Store a newly created resource in storage.
     */
    public function store(CartRequest $request)
    {
        try {
            $cart = $this->cartservice->createCart($request);
            return response()->json([
                'status' => true,
                'message' => 'cart creation successful',
                'cart' => $cart
            ]);
        } catch (\Throwable $th) {
            \Log::error('error' . $th->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'cart creation failed'
            ]);
        }
    }

    public function deleteProductFromCart($cartId, $productId)
    {
        try {
            CartProduct::where('cart_id', $cartId)
                ->where('product_id', $productId)
                ->delete();
            return response()->json([
                'Status' => true,
                'message' => 'Product deleted from cart'
            ]);
        } catch (\Throwable $th) {
            \Log::error('error' . $th->getMessage());
            return response()->json([
                'Status' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CartRequest $request, string $id)
    {
        try {
            $cart = $this->cartservice->updateCart($request, $id);
            return response()->json($cart);
        } catch (\Throwable $th) {
            \Log::error('error' . $th->getMessage());
            return response()->json([
                'message' => 'cart updation failed'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

    }
}
