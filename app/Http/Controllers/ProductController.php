<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\ProductIndexRequest;
use App\Http\Requests\Product\ProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Services\ProductService;

class ProductController extends Controller
{
    protected $productService;
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        try {
            $product = $this->productService->getAllProducts();
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
                'product' => $product
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


    public function updateProduct(UpdateProductRequest $request, $id)
    {
        try {
            $updateProduct = $this->productService->updateProductData($id, $request);
            return response()->json([
                'status' => true,
                'message' => 'Product Image update successfully',
                'updatedata' => $updateProduct
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'false',
                'message' => $th->getMessage()
            ]);
        }
    }

    public function deleteProductImage($id)
    {
        try {
            $deleteProduct = $this->productService->deleteImage($id);
            return response()->json([
                'status' => true,
                'message' => 'Product image deleted successfully'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ]);
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
