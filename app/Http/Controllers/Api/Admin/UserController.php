<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index(){
        try{
            $users = User::latest()->get();
            return response()->successResponse(UserResource::collection($users), 'User list');

        }catch(Exception $exception){
            Log::info($exception->getMessage());
            return response()->errorResponse();
        }
    }
    public function show(){
        try{
            $user = User::with('articles', 'articles.categories:id,name')->findOrFail(auth()->user()->id);
            return response()->successResponse(new UserResource($user), 'User details');

        }catch(Exception $exception){
            Log::info($exception->getMessage());
            return response()->errorResponse();
        }
    }
}
