<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $buyNow = $request->query('mode') === 'buy-now';

        $cart = $request->session()->get(
            $buyNow ? 'buy_now' : 'cart',
            []
        );

        if (!$cart) {
            return redirect()->route('cart.index');
        }

        $products = Product::whereIn('id', array_keys($cart))->get();

        if ($products->count() !== count($cart)) {
            return redirect()->route('cart.index')
                ->with('cart_error', 'Некоторые книги больше недоступны');
        }

        $items = $products->map(fn ($product) => [
            'product' => $product,
            'quantity' => (int) $cart[$product->id],
        ]);

        foreach ($items as $item) {
            $product = $item['product'];
            $quantity = $item['quantity'];

            if (!$product->status || $quantity < 1 ||
                $quantity > $product->quantity) {
                return redirect()->route('cart.index')
                    ->with('cart_error', 'Проверьте наличие книг в корзине');
            }
        }

        $subtotal = round($items->sum(fn ($item) =>
            (float) $item['product']->price * $item['quantity']
        ), 2);

        $firstOrder = !$request->user()->orders()
            ->where('status', '!=', 'cancelled')
            ->exists();

        $discount = $firstOrder ? round($subtotal * 0.1, 2) : 0;
        $total = $subtotal - $discount;

        return view('checkout.index',
            compact('items', 'subtotal', 'discount', 'total', 'buyNow'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'phone' => 'required|string|max:30',
            'city' => 'required|string|max:100',
            'street' => 'required|string|max:150',
            'house' => 'required|string|max:50',
            'flat' => 'nullable|string|max:50',
            'comment' => 'nullable|string|max:2000',
            'mode' => 'required|in:cart,buy-now',
        ]);

        if (strlen(preg_replace('/\D/', '', $data['phone'])) < 10) {
            throw ValidationException::withMessages([
                'phone' => 'Введите корректный номер телефона',
            ]);
        }

        $sessionKey = $data['mode'] === 'buy-now'
            ? 'buy_now'
            : 'cart';

        $cart = $request->session()->get($sessionKey, []);

        if (!$cart) {
            return redirect()->route('cart.index');
        }

        DB::transaction(function () use ($request, $data, $cart) {
            $user = User::whereKey($request->user()->id)
                ->lockForUpdate()
                ->firstOrFail();

            $products = Product::whereIn('id', array_keys($cart))
                ->orderBy('id')
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            if ($products->count() !== count($cart)) {
                throw ValidationException::withMessages([
                    'cart' => 'Некоторые книги больше недоступны',
                ]);
            }

            $subtotal = 0;

            foreach ($cart as $id => $quantity) {
                $product = $products->get($id);
                $quantity = (int) $quantity;

                if (!$product || !$product->status ||
                    $quantity < 1 || $quantity > $product->quantity) {
                    throw ValidationException::withMessages([
                        'cart' => 'Недостаточно книг на складе. Проверьте корзину.',
                    ]);
                }

                $subtotal += round((float) $product->price * $quantity, 2);
            }

            $subtotal = round($subtotal, 2);

            $firstOrder = !$user->orders()
                ->where('status', '!=', 'cancelled')
                ->exists();

            $discount = $firstOrder ? round($subtotal * 0.1, 2) : 0;

            $order = $user->orders()->create([
                'order_number' => 'BM-' . Str::ulid(),
                'status' => 'new',
                'customer_name' => $data['name'],
                'customer_email' => $user->email,
                'phone' => $data['phone'],
                'city' => $data['city'],
                'street' => $data['street'],
                'house' => $data['house'],
                'flat' => $data['flat'] ?? '',
                'comment' => $data['comment'] ?? '',
                'subtotal' => $subtotal,
                'discount' => $discount,
                'total' => round($subtotal - $discount, 2),
            ]);

            foreach ($cart as $id => $quantity) {
                $product = $products->get($id);

                $order->items()->create([
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_author' => $product->author,
                    'price' => $product->price,
                    'quantity' => (int) $quantity,
                ]);

                $product->decrement('quantity', (int) $quantity);
            }

            $user->update([
                'phone' => $data['phone'],
                'city' => $data['city'],
                'address' => trim(
                    $data['street'] . ', ' . $data['house'] .
                    (empty($data['flat']) ? '' : ', кв. ' . $data['flat'])
                ),
            ]);
        });

        $request->session()->forget($sessionKey);

        return redirect()->route('profile.index')
            ->with('success', 'Заказ успешно оформлен!');
    }

    
    public function buyNow(Request $request, Product $product)
    {
        if (!$product->status || $product->quantity < 1) {
            return back()->with(
                'cart_error',
                'Книга отсутствует в наличии'
            );
        }

        $request->session()->put('buy_now', [
            $product->id => 1,
        ]);

        return redirect()->route('checkout.index', [
            'mode' => 'buy-now',
        ]);
    }

}