<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

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

    
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'author' => 'required|string|max:150',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0|max:99999999.99',
            'quantity' => 'required|integer|min:0',
            'description' => 'required|string',
            'full_description' => 'nullable|string',
            'publisher' => 'nullable|string|max:150',
            'publication_year' => 'nullable|integer|between:1901,2155',
            'pages' => 'nullable|integer|min:1',
            'image_file' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:4096',
        ]);

        unset($data['image_file']);

        // Генерируем уникальный slug
        $slug = Str::slug($data['name']) ?: 'book';
        $data['slug'] = $slug . '-' . Str::lower(Str::random(8));

        // Дополнительные параметры
        $data['is_new'] = $request->boolean('is_new');
        $data['is_hit'] = $request->boolean('is_hit');
        $data['status'] = $request->boolean('status');

        // Загружаем обложку
        if ($request->hasFile('image_file')) {
            $folder = public_path('images/products');

            File::ensureDirectoryExists($folder);

            $file = $request->file('image_file');
            $filename = Str::uuid() . '.' . $file->extension();

            $file->move($folder, $filename);

            $data['image'] = 'images/products/' . $filename;
        }

        Product::create($data);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Книга успешно добавлена');
    }

}
