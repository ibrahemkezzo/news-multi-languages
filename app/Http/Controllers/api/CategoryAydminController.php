<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryAydminController extends Controller
{
    protected $setting;
    public function __construct(Setting $setting)
    {
        $this->setting = $setting;
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $this->authorize('viewAny', $this->setting);
        $category =  $request->except('image', '_token');
        if ($request->file('image')) {
            $file = $request->file('image');
            $filename = Str::uuid() . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            $path = '/images/' . $filename;
            // dd($path);
            $category['image'] = $path;
        }
        // dd($category);
        $category =  Category::create($category);
        return CategoryResource::make($category);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $categoryadmin)
    {
        $this->authorize('viewAny', $this->setting);
        $categoryadmin->update($request->except('image', '_token'));
        if ($request->file('image')) {
            $file = $request->file('image');
            $filename = Str::uuid() . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            $path = 'images/' . $filename;

            $categoryadmin->update(['image' => $path]);
        }

        return CategoryResource::make($categoryadmin);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $categoryadmin)
    {
        $categoryadmin->delete();
        return response()->json('the deleted successfull',200);
    }
}
