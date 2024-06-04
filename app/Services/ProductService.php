<?php

namespace App\Services;

use App\Http\Requests\Product\ProductIndexRequest;
use App\Http\Requests\Product\ProductRequest;
use App\Models\Product;
use App\Models\Productimage;
use App\Repositories\Eloquents\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductService
{

    public function getAllProducts(Request $request)
    {
        $limit = $request->query('limit', 3);
        $sortField = $request->query('sort_field', 'id');
        $sortOrder = $request->query('sort_order', 'asc');
        $product = Product::orderBy($sortField, $sortOrder)->paginate($limit);
        $product->load('productimages');
        return $product;
    }

    public function createProduct(ProductRequest $request)
    {
        $product = Product::create(array_merge(
            $request->only('title', 'description', 'price' ,'category_id'),
            ['user_id' => auth()->id()]
        ));

        if ($request->hasfile('image')) {
            $imagePath = $this->uploadImage($request->file('image'));
            Productimage::create([
                'product_id' => $product->id,
                'product_images' => $imagePath,
            ]);
        }
        return $product;
    }
    private function uploadImage($image)
    {
        $uploadFolder = 'products';
        $image_uploaded_path = $image->store($uploadFolder, 'public');
        return Storage::disk('public')->url($image_uploaded_path);
    }
    
    public function getSingleProduct($id)
    {
        $product = Product::with('Productimages')->find($id);
        return $product;
    }

    public function deleteProduct($id)
    {
        $product = Product::find($id);
        $product->delete();
        return $product;
    }

}
