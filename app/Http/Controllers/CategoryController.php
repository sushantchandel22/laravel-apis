<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }
    public function index()
    {
        try {
            $category = $this->categoryService->getAllCategories();
            //return CategoryResource::collection($category);
            return $category;
        } catch (\Throwable $th) {
            \Log::error('error' . $th->getMessage());
            return response()->json([
                'message' => 'no category found'
            ]);
        }
    }

    public function getProductInCategory(){
     try{
        $category = $this->categoryService->getCategories();
        return CategoryResource::collection($category);
     }catch(\Throwable $th){
        \Log::error('error' . $th->getMessage());
        return response()->json([
       'message'=>'no category find']);
     }
    }

    public function store(Request $request)
    {
        try {
            $category =$this->categoryService->createCategory($request);
            return response()->json([
                'status' => true,
                'message' => 'Category created successfully',
                'data' => $category
            ]);
        } catch (\Throwable $th) {
            \Log::error('error' . $th->getMessage());
            return response()->json([
                'status' => false,
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

    }


    public function destroy(string $id)
    {
        try {
          $category = $this->categoryService->deleteCategory($id);
            return response()->json([
                'status' => true,
                "message"=> "Category Deleted successfully"
            ]);
        } catch (\Throwable $th) {
            \Log::error('error' . $th->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'category delete failed'
            ]);
        }
    }
}
