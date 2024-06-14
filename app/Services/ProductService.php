<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductImage;
use Log;

class ProductService
{
    public function getAllProducts()
    {
        $limit = 50;
        $sortField = 'id';
        $sortOrder = 'desc';
        $user = auth()->user();
        $products = $user->products()->orderBy($sortField, $sortOrder)->paginate($limit);
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
        $filename = time() . '.' . $image->getClientOriginalExtension();
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
        return Product::findOrFail($id)->delete();
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

