<?php

use App\Http\Controllers\dashboard\SettingController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix'=>'dashboard',
                'as'=>'dashboard.'],
            function(){
                Route::get('/', function () {
                    return view('dashboard.index');
                });
                Route::get('/settings',[SettingController::class,'index'])->name('settings.index');
                Route::post('/settings',[SettingController::class,'update'])->name('settings.update');
            }
            );
