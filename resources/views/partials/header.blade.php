<header class="header">
    <div class="container">
        <div class="header__container">
            <a aria-label="BookMarket — перейти на главную"
               class="logo" href="{{ route('home') }}">
                <span class="logo__icon">B</span>
                <span class="logo__content">
                    <span class="logo__text">BookMarket</span>
                    <span class="logo__subtitle">Интернет-магазин книг</span>
                </span>
            </a>

            <nav aria-label="Основная навигация" class="nav">
                <ul class="nav__list">
                    <li class="nav__item">
                        <a class="nav__link {{ request()->routeIs('home') ? 'nav__link--active' : '' }}"
                           href="{{ route('home') }}">Главная</a>
                    </li>
                    <li class="nav__item">
                        <a class="nav__link {{ request()->routeIs('catalog.*') ? 'nav__link--active' : '' }}"
                           href="{{ route('catalog.index') }}">Каталог</a>
                    </li>
                    <li class="nav__item">
                        <span class="nav__link">Контакты</span>
                    </li>
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <li class="nav__item">
                                <a class="nav__link {{ request()->routeIs('admin.*') ? 'nav__link--active' : '' }}"
                                href="{{ route('admin.index') }}">
                                    Админка
                                </a>
                            </li>
                        @endif
                    @endauth
                </ul>
            </nav>

            <div class="user-nav">
                @auth
                    <a class="user-nav__link" href="{{ route('profile.index') }}">
                        {{ auth()->user()->name }}
                    </a>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf

                        <button class="user-nav__link"
                                type="submit"
                                style="font-family: inherit; cursor: pointer;">
                            Выйти
                        </button>
                    </form>
                @else
                    <a class="user-nav__link" href="{{ route('login') }}">
                        Войти
                    </a>
                @endauth

                <a class="user-nav__link user-nav__link--accent"
                    href="{{ route('cart.index') }}">
                    Корзина (<span class="cart-count">{{ array_sum(session('cart', [])) }}</span>)
                </a>
            </div>
        </div>
    </div>
</header>
  