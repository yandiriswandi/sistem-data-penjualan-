<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function category()
    {
        $data = Category::orderBy('name', 'asc')->get();
        // $data = Product::all();
        return view('category.category', compact('data'));
    }
}
