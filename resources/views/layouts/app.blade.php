<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'BookMarket — Книжный интернет-магазин')</title>
    
    <link rel="stylesheet" href="{{ asset('css/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        /* Базовые доработки для аккуратной сетки Laravel */
        .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
        .site-header { background: #2c3e50; color: #fff; padding: 15px 0; }
        .header-wrap { display: flex; justify-content: space-between; align-items: center; }
        .site-logo { font-size: 24px; font-weight: bold; color: #fff; text-decoration: none; }
        .search-form { display: flex; gap: 8px; }
        .search-form input { padding: 6px 12px; border-radius: 4px; border: 1px solid #ccc; }
        .search-form button { padding: 6px 14px; background: #e74c3c; color: #fff; border: none; border-radius: 4px; cursor: pointer; }
        .nav-links a { color: #fff; text-decoration: none; margin-left: 15px; }
        .site-footer { background: #1a252f; color: #aaa; text-align: center; padding: 25px 0; margin-top: 50px; }
        .pagination { display: flex; justify-content: center; gap: 8px; margin: 30px 0; list-style: none; padding: 0; }
        .pagination li a, .pagination li span { padding: 8px 14px; border: 1px solid #ddd; text-decoration: none; border-radius: 4px; color: #333; }
        .pagination li.active span { background: #e74c3c; color: #fff; border-color: #e74c3c; }
    </style>
</head>
<body>
    <header class="site-header">
        <div class="container header-wrap">
            <a href="{{ route('home') }}" class="site-logo">📚 BookMarket</a>
            
            <form action="{{ route('catalog.index') }}" method="GET" class="search-form">
                <input type="text" name="search" placeholder="Поиск по названию или автору..." value="{{ request('search') }}">
                <button type="submit">Найти</button>
            </form>

            <nav class="nav-links">
                <a href="{{ route('catalog.index') }}">Каталог</a>
                <a href="#">Корзина</a>
            </nav>
        </div>
    </header>

    <main class="container" style="padding-top: 30px; min-height: 70vh;">
        @yield('content')
    </main>

    <footer class="site-footer">
        <div class="container">
            <p>&copy; {{ date('Y') }} BookMarket. Лабораторная работа по веб-разработке (Laravel).</p>
        </div>
    </footer>
</body>
</html>