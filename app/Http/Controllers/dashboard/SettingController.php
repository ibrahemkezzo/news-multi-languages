<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SettingController extends Controller
{
    public function index(){    
        $setting = Setting::first();
        $this->authorize('view', $setting);
        // dd($setting);
        return view('dashboard.settings');
    }
    public function update(Request $request , Setting $setting){

        $this->authorize('update', $setting);

        $data = [
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'favicon' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'facebook' => 'nullable|string',
            'instagram' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',

        ];
        foreach (config('app.languages') as $key => $value) {
            $data[$key . '*.title'] = 'nullable|string';
            $data[$key . '*.content'] = 'nullable|string';
            $data[$key . '*.address'] = 'nullable|string';
        }
        $validatedData = $request->validate($data);
        $updata = $request->except('logo', 'favicon', '_token');

         $setting->update($request->except('logo', 'favicon', '_token'));
        if ($request->file('logo')) {
            $file = $request->file('logo');
            $filename = Str::uuid() . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            $path = '/images/' . $filename;
            $updata['logo'] = $path;
            // dd($updata);
            // $setting->update(['logo' => $path]);
        }
        if ($request->file('favicon')) {
            $file = $request->file('favicon');
            $filename = Str::uuid() . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            $path = '/images/' . $filename;
            // dd($path);
            $updata['favicon'] = $path;
        }
        // dd($updata);
        $setting->update($updata);

        return redirect()->route('dashboard.settings.index');

    }
}
