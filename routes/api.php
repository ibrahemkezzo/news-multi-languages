<?php

use App\Http\Controllers\api\CategoryAydminController;
use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\PostController;
use App\Http\Controllers\api\SettingController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/settings',[SettingController::class,'index'])->middleware('auth:sanctum');
Route::get('/categories',[CategoryController::class,'navbarCategories']);
Route::get('/categories-with-posts',[CategoryController::class,'indexPageCategorieswithPosts']);

Route::get('/categories',[CategoryController::class,'index']);
Route::get('/categories/{id}',[CategoryController::class,'show']);

Route::apiResource('post',PostController::class);
Route::apiResource('categoryadmin',CategoryAydminController::class)->except(['index','show'])->middleware('auth:sanctum');;

Route::group([

],function(){

});

