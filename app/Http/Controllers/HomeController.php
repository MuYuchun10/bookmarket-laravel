<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        $featuredProducts = Product::active()
            ->with('category')
            ->orderByDesc('is_hit')
            ->orderByDesc('is_new')
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->limit(4)
            ->get();

        return view('home', compact('categories', 'featuredProducts'));
    }
}
