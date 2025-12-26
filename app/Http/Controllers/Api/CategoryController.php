<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Resources\CategoryResource;


class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('posts')->get();
        
        return CategoryResource::collection($categories);
    }

    public function show(Category $category)
    {
        $category->load('posts');
        
        return new CategoryResource($category);
    }
}
