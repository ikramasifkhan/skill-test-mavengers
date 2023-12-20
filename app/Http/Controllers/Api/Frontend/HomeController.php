<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function index(){
        try{
            $articles = Article::with(['author:id,name', 'categories:id,name'])->where(['status' => 'published'])->latest()->get();
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
}
