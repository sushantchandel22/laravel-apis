<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductImage;

class ProductService
{
    public function getAllProducts()
    {
        $limit = 50;
        $sortField = 'id';
        $sortOrder = 'desc';
        $products = Product::orderBy($sortField, $sortOrder)->paginate($limit);
        $products->load('productimages');
        $products->each(function ($product) {
            foreach ($product->productimages as $image) {
                $image->url = $image->image_url;
            }
        });
        return $products;
    }

    public function createProduct($request)
    {
        $productData = $request->only('title', 'description', 'price', 'category_id');
        $productData['user_id'] = auth()->id();
        $product = Product::create($productData);

        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $file) {
                $imagePath = $this->uploadImage($file, $product->id);
                ProductImage::create([
                    'product_id' => $product->id,
                    'product_image' => $imagePath,
                ]);
            }
        }
        return $product;
    }

    public function uploadImage($image, $productId)
    {
        $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
        $path = 'products/' . $productId;
        $image->storeAs($path, $filename, 'public');
        return $filename;
    }

    public function getSingleProduct($id)
    {
        $product = Product::with('productimages')->find($id);
        if ($product) {
            foreach ($product->productimages as $image) {
                $image->image_id = $image->id;
                $image->url = $image->image_url;
            }
        }
        return $product;
    }

    public function deleteProduct($id)
    {
        $product = Product::find($id);
        if ($product && $product->user_id === auth()->id()) {
            $product->delete();
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }


    public function updateProductData($id, $request)
    {
        $product = Product::with('productimages')->findOrFail($id);
        $productData = $request->only('title', 'description', 'price', 'category_id');
        $product->update($productData);
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $file) {
                $imagePath = $this->uploadImage($file, $product->id);
                ProductImage::create([
                    'product_id' => $product->id,
                    'product_image' => $imagePath,
                ]);
            }
        }
        return $product;
    }

    public function deleteImage($id)
    {
        return ProductImage::find($id)->delete();
    }
}

