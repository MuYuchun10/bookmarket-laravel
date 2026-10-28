<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Список товаров (каталог) с фильтрацией по категории и поиском.
     */
    
    public function index(Request $request)
    {
        $request->validate([
            'search' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:100',
            'author' => 'nullable|string|max:150',
            'price-from' => 'nullable|numeric|min:0',
            'price-to' => 'nullable|numeric|min:0',
        ]);

        $categories = Category::all();
        $query = Product::active()->with('category');

        // Название книги
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }

        // Категория
        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->input('category'));
            });
        }

        // Автор
        if ($request->filled('author')) {
            $query->where('author', 'like', '%' . $request->input('author') . '%');
        }

        // Минимальная цена
        if ($request->filled('price-from')) {
            $query->where('price', '>=', $request->input('price-from'));
        }

        // Максимальная цена
        if ($request->filled('price-to')) {
            $query->where('price', '<=', $request->input('price-to'));
        }

        $sort = $request->input('sort', 'price-asc');

        if ($sort === 'price-desc') {
            $query->orderByDesc('price');
        } else {
            $query->orderBy('price');
        }

        $products = $query->orderBy('id')
            ->paginate(9)
            ->withQueryString();

        return view('catalog.index', compact('products', 'categories'));
    }


    /**
     * Детальная страница отдельной книги.
     */
    public function show(string $slug)
    {
        $product = Product::with(['category', 'reviews.user'])
            ->where('slug', $slug)
            ->firstOrFail();

        // 4 похожие книги из той же категории
        $relatedProducts = Product::active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('catalog.show', compact('product', 'relatedProducts'));
    }
}