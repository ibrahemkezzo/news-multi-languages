<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{


    public function navbarCategories() {
        $categories = Category::with('children')->where('parent' , 0)->orWhere('parent' , null)->get();
        return new CategoryCollection($categories);
    }


    public function indexPageCategorieswithPosts(){
        $categories = Category::with(['posts'=>function($q){
            $q->limit(5);
        },'user'])->get();
        return new CategoryCollection($categories);
    }

    public function index(){
        $categories = Category::paginate(2);
        return CategoryResource::collection($categories);
    }


    public function show($id){
        $category = Category::where('id',$id)->firstOrFail();
        return CategoryResource::make($category);
    }
}
