<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $articles = Article::with(['author:id,name', 'categories:id,name'])->latest()->get();
            if($articles){
                return response()->successResponse(ArticleResource::collection($articles), 'Article list');
            }else{
                return response()->notFoundResponse();
            }

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
    public function store(ArticleRequest $request)
    {
        try{
            $data = $request->except('categories');
            $data['user_id'] = auth()->user()->id;
            $article = Article::create($data);

            if($request->has('categories')){
                $article->categories()->sync($request->categories);
            }
            return response()->successResponse(new ArticleResource($article), 'Article created successfully', 201);
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
            $article = Article::with(['author:id,name', 'categories:id,name'])->where(['slug' => $slug])->first();
            if($article){
                return response()->successResponse(new ArticleResource($article), 'Article details', 200);
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
    public function update(ArticleRequest $request, string $id)
    {
        try{
            $article = Article::findOrFail($request->id);
            $data = $request->except('categories');

            $article->update($data);

            if($request->has('categories')){
                $article->categories()->sync($request->categories);
            }
            return response()->successResponse(new ArticleResource($article), 'Article updated successfully', 201);
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
            $article = Article::find($id);
            if($article){
                $article->delete();
                return response()->successResponse([], 'Article deleted successfully', 201);
            }else{
                return response()->notFoundResponse();
            }
        }catch(Exception $exception){
            Log::info($exception->getMessage());
            return response()->errorResponse();
        }
    }
}
