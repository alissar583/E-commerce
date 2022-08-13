<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::prefix('auth')->group(function (){
    Route::post('signup',[\App\Http\Controllers\AuthController::class,'signup']);
    Route::post('login',[\App\Http\Controllers\AuthController::class,'login']);
    Route::post('logout',[\App\Http\Controllers\AuthController::class,'logout'])->middleware('auth:api');
    Route::delete('deleteUser/{user}',[\App\Http\Controllers\AuthController::class,'deleteUser'])->middleware('auth:api');
});
Route::prefix('categories')->group(function (){
    Route::get('/', [\App\Http\Controllers\CategoryController::class, 'index']);
    Route::post('/', [\App\Http\Controllers\CategoryController::class, 'store']);
//    Route::get('/{category}', [\App\Http\Controllers\CategoryController::class, 'show']);
//    Route::put('/{category}', [\App\Http\Controllers\CategoryController::class, 'update']);
//    Route::delete('/{category}', [\App\Http\Controllers\CategoryController::class, 'destroy']);
});
Route::prefix('products')->group(function (){
    Route::post('index', [\App\Http\Controllers\ProductController::class, 'index']);
//    Route::post('sorting', [\App\Http\Controllers\ProductController::class, 'sorting']);
//    Route::post('search', [\App\Http\Controllers\ProductController::class, 'search']);
    Route::get('/{product}', [\App\Http\Controllers\ProductController::class, 'show']);
    Route::get('user_Products/{user_id}', [\App\Http\Controllers\ProductController::class, 'user_Products']);
});
Route::middleware('auth:api')->prefix('products')->group(function (){
    Route::put('/{product}', [\App\Http\Controllers\ProductController::class, 'update']);
    Route::put('updateQuantity/{product}', [\App\Http\Controllers\ProductController::class, 'updateQuantity']);
    Route::post('/', [\App\Http\Controllers\ProductController::class, 'store']);
    Route::delete('/{product}', [\App\Http\Controllers\ProductController::class, 'destroy']);
});

Route::middleware('auth:api')->prefix('comments')->group(function (){
    Route::post('/', [\App\Http\Controllers\CommentController::class, 'store']);
    Route::put('/{comment}', [\App\Http\Controllers\CommentController::class, 'update']);
    Route::delete('/{comment}', [\App\Http\Controllers\CommentController::class, 'destroy']);
});
Route::prefix('comments')->group(function (){
    Route::get('/', [\App\Http\Controllers\CommentController::class, 'index']);
    Route::get('/{comment}', [\App\Http\Controllers\CommentController::class, 'show']);
});
Route::post('like/', [\App\Http\Controllers\LikeController::class, 'store'])->middleware('auth:api');
Route::delete('like/{product}', [\App\Http\Controllers\LikeController::class, 'destroy'])->middleware('auth:api');




Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
