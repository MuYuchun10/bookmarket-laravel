<nav class="admin-nav">
    <a class="admin-nav__link {{ request()->routeIs('admin.index') ? 'admin-nav__link--active' : '' }}"
       href="{{ route('admin.index') }}">
        Обзор
    </a>

    <a class="admin-nav__link {{ request()->routeIs('admin.products.*') ? 'admin-nav__link--active' : '' }}"
       href="{{ route('admin.products.index') }}">
        Книги
    </a>

    <span class="admin-nav__link">Категории</span>
    <span class="admin-nav__link">Заказы</span>
    <span class="admin-nav__link">Пользователи</span>
</nav>
