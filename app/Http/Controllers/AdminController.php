<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use App\Models\Tag;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard', [
            'categories' => Category::withCount('products')->get(), // coleção
            'products' => Product::with(['images', 'category', 'tag'])->get(), // coleção
            'totalProducts' => Product::count(),  // número para os cards
            'totalUsers' => User::count(),     // número para os cards
            'totalTags' => Tag::count(),      // número para os cards
        ]);
    }
}