<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'q' => 'nullable|string|max:255',
            'category_id' => 'nullable|integer|exists:categories,id',
            'status' => 'nullable|in:0,1',
        ]);

        $categories = Category::orderBy('name')->get();

        $query = Product::with('category');

        // Поиск по названию, автору и артикулу
        if ($request->filled('q')) {
            $search = $request->input('q');

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('article', 'like', "%{$search}%");
            });
        }

        // Фильтр по категории
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Активные и скрытые книги
        if ($request->filled('status')) {
            $query->where('status', (bool) $request->status);
        }

        $products = $query->orderByDesc('id')
            ->paginate(8)
            ->withQueryString();

        return view('admin.products.index',
            compact('products', 'categories'));
    }
}
