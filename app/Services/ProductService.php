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
        $limit = $request->query('limit', 100);
        $sortField = $request->query('sort_field', 'id');
        $sortOrder = $request->query('sort_order', 'asc');
        $product = Product::orderBy($sortField, $sortOrder)->paginate($limit);
        $product->load('productimages');
        return $product;
    }


    public function createProduct($request)
    {
        $productData = $request->only('title', 'description', 'price', 'category_id');
        $productData['user_id'] = auth()->id();
        $product = Product::create($productData);
        
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $index => $file) {
                $imagePath = $this->uploadImage($file);
                $isFeatured = $request->input('is_featured.' . $index, false);
                ProductImage::create([
                    'product_id' => $product->id,
                    'product_images' => $imagePath,
                    'is_featured' => $isFeatured,
                ]);
            }
        }
        return $product;
    }

    private function uploadImage($image)
    {
        $filename = time(). '.'. $image->getClientOriginalExtension();
        $image->storeAs('products', $filename, 'public');
        return $filename;
    }

 
 

    public function getSingleProduct($id)
    {
       
        $product = Product::with('productimages')->find($id);
        return $product;
    }
   
    public function deleteProduct($id)
    {
        $product = Product::find($id);
        $product->delete();
        return $product;
    }


    public function updateProduct1($id, $requestData)
    {
        $product = Product::findOrFail($id);
        $product->update($requestData);

        return $product;
    }

   
    public function updateProduct($id, $request)
    {
        $product = Product::findOrFail($id);
        $product->load('productimages');
        $productData = $request->only('title', 'description', 'price', 'category_id');
        $product->update($productData);
    
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $index => $file) {
                $imagePath = $this->uploadImage($file);
                $isFeatured = $request->input('is_featured.' . $index, false);
                ProductImage::create([
                    'product_id' => $product->id,
                    'product_images' => $imagePath,
                    'is_featured' => $isFeatured,
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
