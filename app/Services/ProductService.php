<?php

namespace App\Services;

use App\Http\Requests\Product\ProductIndexRequest;
use App\Http\Requests\Product\ProductRequest;
use App\Models\Product;
use App\Models\ProductImage;
use App\Repositories\Eloquents\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    public function getAllProducts($request)
    {
        $limit = $request->query('limit', 40);
        $sortField = $request->query('sort_field', 'id');
        $sortOrder = $request->query('sort_order', 'asc');
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
                $image->url = $image->image_url;
            }
        }
        return $product;
    }

    public function deleteProduct($id)
    {
        $product = Product::find($id);
        $product->delete();
        return $product;
    }


    // public function updateProduct1($id, $requestData)
    // {
    //     $product = Product::findOrFail($id);
    //     $product->update($requestData);

    //     return $product;
    // }


    public function updateProduct($id, $request)
    {
        $product = Product::findOrFail($id);
        $product->load('productimages');
        $productData = $request->only('title', 'description', 'price');
        $product->update($productData);
       
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as$file){
                $imagePath = $this->uploadImage($file ,$product->id);
                ProductImage::create([
                    'product_id' => $product->id,
                    'product_images' => $imagePath,
                ]);
            }
        }

        if ($request->has('delete_images')) {
            foreach ($request->input('delete_images') as $imageId) {
                $productImage = ProductImage::find($imageId);
                if ($productImage) {
                    Storage::disk('public')->delete('products/' . basename($productImage->product_images));
                    $productImage->delete();
                }
            }
        }
        return $product;
    }



}
