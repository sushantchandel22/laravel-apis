<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
        public function index()
    {
        try {
        $category = Category::all();
        $category->load('products');
            return CategoryResource::collection($category);
        } catch (\Throwable $th) {
            \Log::error('error' . $th->getMessage());
            return response()->json([
                'message' => 'no category found'
            ]);
        }
    }

    public function store(Request $request)
    {
        try {
            $category = Category::create($request->only(['name']));
            return response()->json([
                'status' => 'success',
                'message' => 'Category created successfully',
                'data' => $category
            ]);
        } catch (\Throwable $th) {
            \Log::error('error' . $th->getMessage());
            return response()->json([
                'message' => 'category creation failed'
            ]);
        }
    }

    public function show(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->update($request->only(['name']));
            return response()->json([
                'status' => 'success',
                'message' => 'Category updated successfully',
                'data' => $category
            ]);
        } catch (\Throwable $th) {
            \Log::error('error' . $th->getMessage());
            return response()->json([
                'message' => 'category update failed'
            ]);
        }
    }


    public function destroy(string $id)
    {
        try {
            Category::findOrFail($id)->delete();
            return response()->json(null, 204);
        } catch (\Throwable $th) {
            \Log::error('error' . $th->getMessage());
            return response()->json([
                'message' => 'category delete failed'
            ]);
        }
    }
}
