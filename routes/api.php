<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use app\Http\Controllers\PostController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Route::get('/users', function(){return response()->json(['success'=>true, 'data'=> "Hello"]);
// });

// Route::get('/posts', [PostController::class]);

// Route::resource('/posts', PostController::class);
Route::middleware(['auth:api','Admin'])->group(function(){
    Route::resource('/posts', PostController::class);
});

Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);
//middleware -> checks lw el user logged in 34an mynfa3sh el user y3ml log out/refresh/view my profile w howa msh logged in
// Route::post('/logout',[AuthController::class,'logout'])->middleware('auth:api');
// Route::post('/refresh',[AuthController::class,'refresh'])->middleware('auth:api');
// Route::get('/user',[AuthController::class,'me'])->middleware('auth:api');

Route::middleware('auth:api')->group(function(){
    Route::post('/logout',[AuthController::class,'logout']);
    Route::post('/refresh',[AuthController::class,'refresh']);
    Route::get('/user',[AuthController::class,'me']);
});