<?php

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
        Route::post('/settings',[SettingController::class,'update'])->name('settings.update');
        Route::post('/users/delete',[UserController::class,'delete'])->name('users.delete');
        Route::get('/users/all', [UserController::class, 'getUsersDatatable'])->name('users.all');
        Route::resources([
            'users' => UserController::class,
        ]);
    }
    );
