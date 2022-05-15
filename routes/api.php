<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AutorController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/post/create', [PostController::class,'create']);
Route::put('/post/update/{id}', [PostController::class,'update']);
Route::delete('/post/destroy/{id}', [PostController::class,'destroy']);
Route::get('/post', [PostController::class,'index']);
Route::post('/post/upload', [PostController::class,'upload']);
Route::get('/post/image/{filename}', [PostController::class,'getImage']);

Route::post('/autor/create', [AutorController::class,'create']);
Route::put('/autor/update/{id}', [AutorController::class,'update']);
Route::delete('/autor/destroy/{id}', [AutorController::class,'destroy']);
Route::get('/autor', [AutorController::class,'index']);
Route::get('/autor/user/{id}', [AutorController::class,'getOne']);