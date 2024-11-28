<?php

use App\Http\Controllers\PostsController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\UserController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('/login',[UserController::class, 'login']);
Route::post('/logout',[UserController::class, 'logout'])->middleware('auth:sanctum');;

Route::post('/register',[UserController::class, 'register']);
Route::get('/posts/{post_id}/comments',[PostsController::class,'getComments'])->middleware('auth:sanctum');
Route::post('/posts/{post_id}/comments',[PostsController::class,'addComments'])->middleware('auth:sanctum');

Route::apiResource('/posts',PostsController::class)->middleware('auth:sanctum')->except(['index','show']);   
Route::get('/posts',[PostsController::class,'index']);
Route::get('/posts/{Post}',[PostsController::class,'show']);
// Route::put('/posts',[PostsController::class,'destroy']);
// Route::post('/posts',[PostsController::class,'destroy']);
// Route::delete('/posts/{$Post}',[PostsController::class,'destroy']);


// Route::apiResource('/posts',PostsController::class)->middleware('auth:sanctum');
Route::apiResource('/comments',CommentsController::class)->middleware('auth:sanctum');
