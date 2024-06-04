<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\ProductIndexRequest;
use App\Http\Requests\Product\ProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(ProductIndexRequest $request)
    {
        try {
            $product = $this->productService->getAllProducts($request);
            return response()->json([
                'product' => $product
            ]);
        } catch (\Throwable $th) {
            \Log::error('error' . $th->getMessage());
            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }
    }


    public function store(ProductRequest $request)
    {
        try {
            $product = $this->productService->createProduct($request);
            return response()->json([
                'message' => 'Product created successfully',
                'product' => $product
            ]);
        } catch (\Throwable $th) {
            \Log::error('error' . $th->getMessage());
            return response()->json([
                'message' => 'product creation failed'
            ]);
        }
    }

    public function show(string $id)
    {
        try {
            $product = $this->productService->getSingleProduct($id);
            return response()->json([
                'product' => $product
            ]);
        } catch (\Throwable $th) {
            \Log::error('error' . $th->getMessage());
            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }
    }



    public function update(UpdateProductRequest $request, string $id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->update($request->all());
            return response()->json([
                'message' => 'Product updated successfully',
                'product' => $product
            ]);
        } catch (\Throwable $th) {
            \Log::error('error' . $th->getMessage());
            return response()->json([
                'message' => "Product updation failed"
            ], 500);
        }
    }
  

    public function destroy(string $id)
    {
        try {
            $product = $this->productService->deleteProduct($id);
            return response()->json([
                'message' => 'product deleted'
            ]);
        } catch (\Throwable $th) {
            \Log::error('error' . $th->getMessage());
            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
