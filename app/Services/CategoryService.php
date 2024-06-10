<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{


    public function createCategory($request)
    {
        $category = Category::create($request->only(['name']));
        return $category;
    }

    public function getCategories()
    {
        $category = Category::all();
        $category->load('products');
        return $category;
    }
     public function getAllCategories(){
        $category =Category::all();
        return $category;
     }
    public function deleteCategory($id)
    {
        $Category = Category::findOrFail($id)->delete();
        return $Category;
    }
}