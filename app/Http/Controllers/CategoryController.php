<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $category = Category::all();
            return response()->json([
                'categories' => $category
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'no user found'
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
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
            return response()->json([
                'message' => 'category creation failed'
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
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
            return response()->json([
                'message' => 'category update failed'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Category::findOrFail($id)->delete();
            return response()->json(null, 204);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'category delete failed'
            ]);
        }
    }
}
