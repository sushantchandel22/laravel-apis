<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        try {
            $product = Product::all();
            return response()->json([
                'product' => $product
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()   
            ], 500);
        }
    }

    public function create()
    {

    }

   
    public function store(ProductRequest $request)
    {
        try {
            $product = Product::create($request->all());
            return response()->json([
                'message' => 'Product created successfully',
                'product' => $product
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'product creation failed'
            ]);
        }
    }



 
    public function show(string $id)
    {
        try {
            $product = Product::find($id);
            return response()->json([
                'product' => $product
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }
    }

  
    public function edit(string $id)
    {
        
    }

   
    public function update(Request $request, string $id)
    {
        try {
            $product = Product::find($id);
            $product->update($request->all());
            return response()->json([
                'message' => 'Product updated successfully',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }
    }

  
    public function destroy(string $id)
    {
        try {
            $product = Product::find($id);
            $product->delete();
            return response()->json([
                'message' => 'product deleted'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
