<?php

namespace App\Http\Controllers\website;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function show(Post $post)
    {
       return view('website.post' , compact('post'));
    }
}
