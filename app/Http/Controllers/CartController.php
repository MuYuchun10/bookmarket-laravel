<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    
    public function index(Request $request)
    {
        $cart = $request->session()->get('cart', []);

        $products = Product::whereIn('id', array_keys($cart))->get();

        $items = $products->map(function ($product) use ($cart) {
            return [
                'product' => $product,
                'quantity' => min(
                    (int) $cart[$product->id],
                    (int) $product->quantity
                ),
            ];
        })->filter(fn ($item) =>
            $item['product']->status && $item['quantity'] > 0
        );

        $subtotal = $items->sum(fn ($item) =>
            $item['product']->price * $item['quantity']
        );

        return view('cart.index', compact('items', 'subtotal'));
    }


    public function add(Request $request, Product $product)
    {
        if (!$product->status || $product->quantity < 1) {
            return back()->with('cart_error', 'Книга отсутствует в наличии');
        }

        $cart = $request->session()->get('cart', []);

        $count = $cart[$product->id] ?? 0;

        if ($count >= $product->quantity) {
            return back()->with('cart_error', 'Больше книг нет на складе');
        }

        $cart[$product->id] = $count + 1;

        $request->session()->put('cart', $cart);

        return back()->with('cart_success', 'Книга добавлена в корзину');
    }

    
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'change' => 'required|integer|in:-1,1',
        ]);

        $cart = $request->session()->get('cart', []);

        if (!isset($cart[$product->id])) {
            return redirect()->route('cart.index');
        }

        $quantity = $cart[$product->id] + (int) $request->change;

        if ($quantity <= 0) {
            unset($cart[$product->id]);
        } elseif (!$product->status || $quantity > $product->quantity) {
            return back()->with('cart_error', 'Недостаточно книг на складе');
        } else {
            $cart[$product->id] = $quantity;
        }

        $request->session()->put('cart', $cart);

        return redirect()->route('cart.index');
    }

    public function remove(Request $request, Product $product)
    {
        $cart = $request->session()->get('cart', []);

        unset($cart[$product->id]);

        $request->session()->put('cart', $cart);

        return redirect()->route('cart.index');
    }

}
