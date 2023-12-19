<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
            $categories = Category::select(['id', 'name', 'slug', 'status'])->latest()->get();
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
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
