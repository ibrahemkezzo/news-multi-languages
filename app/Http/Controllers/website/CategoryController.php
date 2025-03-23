<?php

namespace App\Http\Controllers\website;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(){
        $categories = Category::all();
        return view('website.categories', compact('categories'));
    }
    public function show(Category $category)
    {
        $category = $category->load('children','parents');
        $categoryIds = $category->children->pluck('id')->toArray();
        $categoryIds[] = $category->id;
        $posts = Post::whereIn('category_id', $categoryIds)->paginate(15);


        return view('website.category' , compact('category','posts'));
    }
}
