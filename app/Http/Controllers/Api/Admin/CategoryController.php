<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $categories = Category::select(['id', 'name', 'slug'])->latest()->get();
            return response()->successResponse(CategoryResource::collection($categories), 'Category list');
        }catch(Exception $exception){
            Log::info($exception->getMessage());
            return response()->errorResponse();
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
    public function store(CategoryRequest $request)
    {
        try{
            $category = Category::create($request->validated());
            return response()->successResponse(new CategoryResource($category), 'Category created successfully', 201);
        }catch(Exception $exception){
            Log::info($exception->getMessage());
            return response()->errorResponse();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        try{
            $category = Category::with(['articles'])->where(['slug' => $slug])->first();
            if($category){
                return response()->successResponse(new CategoryResource($category), 'Category details', 200);
            }else{
                return response()->notFoundResponse();
            }

        }catch(Exception $exception){
            Log::info($exception->getMessage());
            return response()->errorResponse();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, string $id)
    {
        try{
            $category = Category::findOrFail($request->id);
            $category->update($request->validated());
            $updatedCategory = Category::findOrFail($request->id);
            return response()->successResponse(new CategoryResource($updatedCategory), 'Category updated successfully', 201);
        }catch(Exception $exception){
            Log::info($exception->getMessage());
            return response()->errorResponse();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $article = Category::find($id);
            if($article){
                $article->delete();
                return response()->successResponse([], 'Category deleted successfully', 201);
            }else{
                return response()->notFoundResponse();
            }
        }catch(Exception $exception){
            Log::info($exception->getMessage());
            return response()->errorResponse();
        }
    }
}
