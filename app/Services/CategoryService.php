<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{

    public function getAllCategories()
    {
        $category = Category::all();
        return $category;
    }

    public function createCategory($request)
    {
        $category = Category::create($request->only(['name']));
        return $category;
    }

    public function getProducts()
    {
        return Category::with('products.productimages')->get();
    }

    public function deleteCategory($id)
    {
        return Category::findOrFail($id)->delete();
    }
}