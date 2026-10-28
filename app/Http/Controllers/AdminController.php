<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        $productsCount = Product::count();
        $categoriesCount = Category::count();
        $ordersCount = Order::count();
        $usersCount = User::count();

        $latestOrders = Order::latest()->take(5)->get();

        return view('admin.index', compact(
            'productsCount',
            'categoriesCount',
            'ordersCount',
            'usersCount',
            'latestOrders'
        ));
    }
}
