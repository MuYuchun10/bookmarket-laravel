
@extends('layouts.app')

@section('title', 'Главная — BookMarket')

@section('content')

<!-- Главный баннер -->
<section class="hero">
    <div class="container hero__container">
        <div class="hero__content">
            <p class="hero__subtitle">Новинки и бестселлеры</p>

            <h1 class="hero__title">
                Найди свою следующую любимую книгу
            </h1>

            <p class="hero__description">
                Художественная литература, учебные издания,
                книги по бизнесу и саморазвитию —
                всё в одном удобном каталоге.
            </p>

            <div class="hero__actions">
                <a class="btn btn--primary"
                   href="{{ route('catalog.index') }}">
                    Перейти в каталог
                </a>
                <a class="btn btn--secondary" href="#featured">
                    Популярные книги
                </a>
            </div>
        </div>

        <!-- Быстрый поиск -->
        <aside class="hero__aside">
            <h2 class="hero__aside-title">Быстрый поиск</h2>

            <form action="{{ route('catalog.index') }}"
                  class="search-form" method="GET">

                <input class="search-form__input"
                       name="search"
                       placeholder="Название книги">

                <input class="search-form__input"
                       name="author"
                       placeholder="Автор">

                <select class="search-form__select" name="category">
                    <option value="">Категория</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->slug }}">
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

                <div class="search-form__price">
                    <input class="search-form__input"
                           type="number" name="price-from"
                           placeholder="Цена от" min="0">

                    <input class="search-form__input"
                           type="number" name="price-to"
                           placeholder="Цена до" min="0">
                </div>

                <button class="btn btn--accent search-form__button"
                        type="submit">
                    Найти книгу
                </button>
            </form>
        </aside>
    </div>
</section>

<!-- Категории -->
<section class="categories">
    <div class="container">
        <div class="categories__block">
            <h2 class="section-title">Популярные категории</h2>

            <ul class="categories__list">
                @foreach($categories as $category)
                    <li class="categories__item">
                        <a class="category-pill"
                           href="{{ route('catalog.index', ['category' => $category->slug]) }}">
                            {{ $category->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</section>

<!-- Популярные книги -->
<section class="featured" id="featured">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Популярные книги</h2>

            <a class="section-link"
               href="{{ route('catalog.index') }}">
                Смотреть все
            </a>
        </div>

        <div class="products-grid" id="featured-products">
            @foreach($featuredProducts as $book)
                @include('partials.product-card', ['book' => $book])
            @endforeach
        </div>
    </div>
</section>

<!-- Преимущества -->
<section class="advantages">
    <div class="container">
        <h2 class="visually-hidden">Преимущества магазина</h2>

        <div class="advantages__grid">
            <article class="advantage-card">
                <span class="advantage-card__icon advantage-card__icon--delivery"></span>
                <h3 class="advantage-card__title">Быстрая доставка</h3>
                <p class="advantage-card__text">
                    Оформление заказа за пару шагов и понятная форма адреса.
                </p>
            </article>

            <article class="advantage-card">
                <span class="advantage-card__icon advantage-card__icon--stock"></span>
                <h3 class="advantage-card__title">Актуальное наличие</h3>
                <p class="advantage-card__text">
                    На карточке книги сразу видно,
                    доступен ли товар на складе.
                </p>
            </article>

            <article class="advantage-card">
                <span class="advantage-card__icon advantage-card__icon--account"></span>
                <h3 class="advantage-card__title">Удобный кабинет</h3>
                <p class="advantage-card__text">
                    Пользователь может посмотреть историю заказов
                    и изменить профиль.
                </p>
            </article>
        </div>
    </div>
</section>

<!-- Рекламный блок -->
<section class="promo">
    <div class="container">
        <div class="promo__container">
            <h2 class="promo__title">Скидка 10% на первый заказ</h2>
            <a class="btn btn--light"
               href="{{ route('catalog.index') }}">
                Выбрать книги
            </a>
        </div>
    </div>
</section>

@endsection
