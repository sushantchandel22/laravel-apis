<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\ProductIndexRequest;
use App\Http\Requests\Product\ProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Cart;
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
                'status' => true,
                'product' => $product
            ]);
        } catch (\Throwable $th) {
            \Log::error('error' . $th->getMessage());
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ]);
        }
    }


    public function store(ProductRequest $request)
    {
        try {
            $product = $this->productService->createProduct($request);
            return response()->json([
                'status' => true,
                'message' => 'Product created successfully',
                'product' =>$product
            ]);
        } catch (\Throwable $th) {
            \Log::error('error' . $th->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'product creation failed'
            ]);
        }
    }

    public function show(string $id)
    {
        try {
            $product = $this->productService->getSingleProduct($id);
            return response()->json([
                'status' => true,
                'product' => $product
            ]);
        } catch (\Throwable $th) {
            \Log::error('error' . $th->getMessage());
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ]);
        }
    }



    public function update(UpdateProductRequest $request, string $id)
    {
        try {
            $product = $this->productService->updateProduct($id, $request);
            return response()->json([
                'status' => true,
                'message' => 'Product updated successfully',
                'product' => $product
            ]);
        } catch (\Throwable $th) {
            \Log::error('Error updating product: ' . $th->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Product updation failed'
            ]);
        }
    }
    public function updateData(UpdateProductRequest $request, $id)
    {
        dd($request);
        try {

        } catch (\Throwable $e) {

        }
    }


    public function destroy(string $id)
    {
        try {
            $product = $this->productService->deleteProduct($id);
            return response()->json([
                'status' => true,
               
                'message' => 'product deleted successfully'
            ]);
        } catch (\Throwable $th) {
            \Log::error('error' . $th->getMessage());
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ]);
        }
    }
   
}
