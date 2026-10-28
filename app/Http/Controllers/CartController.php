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
        $cart = $request->session()->get('cart', []);
        $count = (int) ($cart[$product->id] ?? 0);

        if (!$product->status || $product->quantity < 1 ||
            $count >= $product->quantity) {
            $message = 'Книга отсутствует или закончилась на складе';

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => $message,
                    'quantity' => $count,
                    'cartCount' => array_sum($cart),
                ], 422);
            }

            return back()->with('cart_error', $message);
        }

        $cart[$product->id] = $count + 1;
        $request->session()->put('cart', $cart);

        $message = "«{$product->name}» добавлена в корзину";

        if ($request->expectsJson()) {
            return response()->json([
                'message' => $message,
                'quantity' => $cart[$product->id],
                'cartCount' => array_sum($cart),
            ]);
        }

        return back()->with('cart_success', $message);
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'change' => 'required|integer|in:-1,1',
        ]);

        $cart = $request->session()->get('cart', []);

        if (!isset($cart[$product->id])) {
            $message = 'Книга уже удалена из корзины';

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => $message,
                    'quantity' => 0,
                    'cartCount' => array_sum($cart),
                ], 409);
            }

            return redirect()->route('cart.index');
        }

        $quantity = $cart[$product->id] + (int) $request->change;

        if ($quantity <= 0) {
            unset($cart[$product->id]);
        } elseif (!$product->status || $quantity > $product->quantity) {
            $message = 'Больше книг нет на складе';

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => $message,
                    'quantity' => $cart[$product->id],
                    'cartCount' => array_sum($cart),
                ], 422);
            }

            return back()->with('cart_error', $message);
        } else {
            $cart[$product->id] = $quantity;
        }

        $request->session()->put('cart', $cart);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Количество обновлено',
                'quantity' => $cart[$product->id] ?? 0,
                'cartCount' => array_sum($cart),
            ]);
        }

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
