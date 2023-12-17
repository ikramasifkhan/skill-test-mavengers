<?php

use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => 'api'], function () {
    Route::post('/login', [AuthController::class, 'login']);
});


Route::group(['middleware' => 'jwt.verify'], function () {
    Route::get('categories/{slug}', [CategoryController::class, 'show']);
    Route::apiResource('categories', CategoryController::class);
    
    Route::get('articles/{slug}', [ArticleController::class, 'show']);
    Route::apiResource('articles', ArticleController::class);
});

