<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SettingResource;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index(){
        $settings = SettingResource::make(Setting::checkSettings());
        return response()->json([
            'data'=>$settings,
            'error'=>'',
        ],200);
    }
}
