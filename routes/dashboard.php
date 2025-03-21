<?php

use App\Http\Controllers\dashboard\CategoryController;
use App\Http\Controllers\dashboard\PostController;
use App\Http\Controllers\dashboard\SettingController;
use App\Http\Controllers\dashboard\UserController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix'=>'dashboard',
    'as'=>'dashboard.',
    'middleware'=>['auth','checkstatus'], ],
    function(){
        Route::get('/', function () {
            return view('dashboard.index');
        });
        Route::get('/settings',[SettingController::class,'index'])->name('settings.index');
        Route::post('/settings/{setting}',[SettingController::class,'update'])->name('settings.update');

        Route::post('/users/delete',[UserController::class,'delete'])->name('users.delete');
        Route::get('/users/all', [UserController::class, 'getUsersDatatable'])->name('users.all');

        Route::post('/category/delete',[CategoryController::class,'delete'])->name('category.delete');
        Route::get('/category/all', [CategoryController::class, 'getCategoriesDatatable'])->name('category.all');

        Route::get('/posts/all', [PostController::class, 'getPostsDatatable'])->name('posts.all');
        Route::post('/posts/delete', [PostController::class, 'delete'])->name('posts.delete');

        Route::resources([
            'users' => UserController::class,
            'category' => CategoryController::class,
            'posts' => PostController::class,
        ]);
    }
    );
