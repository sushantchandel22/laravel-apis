<?php

namespace App\Http\Controllers;
use App\Http\Requests\CartRequest;
use App\Services\CartService;
use Illuminate\Http\Request;

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
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CartRequest $request)
    {      
        try{
            $cart =$this->cartservice->createCart($request);
            return response()->json([
                'message'=>'cart creation successful',
                'cart'=>$cart
            ]);
            }catch(\Throwable $th){
                \Log::error('error'.$th->getMessage());
                return response()->json([
                    'message'=>'cart creation failed'
                ]);
            }
    }

    /**
     * Display the specified resource.
     */
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
