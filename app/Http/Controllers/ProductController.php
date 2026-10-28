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
        $categories = Category::all();

        $query = Product::with('category')->active();

        // Фильтрация по слагу категории, если передан параметр ?category=...
        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->query('category'));
            });
        }

        // Поиск по названию или автору
        if ($request->filled('search')) {
            $search = $request->query('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%");
            });
        }

        // Пагинация по 9 книг на страницу с сохранением query-параметров в URL
        $products = $query->latest()->paginate(9)->withQueryString();

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