
@extends('layouts.app')

@section('title', 'Каталог — BookMarket')

@section('content')
<section class="catalog-page" aria-labelledby="catalog-title">
    <div class="container">
        <p class="catalog-page__eyebrow">Каталог</p>
        <h1 class="catalog-page__title" id="catalog-title">
            Выберите книги по жанру, автору и цене
        </h1>

        <div class="catalog-layout">
            <aside class="catalog-sidebar">
                <div class="catalog-panel">
                    <h2 class="catalog-panel__title">Фильтры</h2>

                    <form action="{{ route('catalog.index') }}"
                          class="catalog-filter-form" method="GET">

                        <input type="hidden" name="sort" value="{{ request('sort', 'price-asc') }}">
                        
                        <div class="catalog-filter__group">
                            <label class="catalog-filter__label" for="search">
                                Название книги
                            </label>
                            <input class="catalog-filter__input"
                                   id="search" name="search"
                                   placeholder="Введите название книги"
                                   value="{{ request('search') }}">
                        </div>

                        <div class="catalog-filter__group">
                            <label class="catalog-filter__label" for="category">
                                Категория
                            </label>
                            <select class="catalog-filter__select"
                                    id="category" name="category">
                                <option value="">Категория</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->slug }}"
                                        @selected(request('category') == $category->slug)>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="catalog-filter__group">
                            <label class="catalog-filter__label" for="author">
                                Автор
                            </label>
                            <input class="catalog-filter__input"
                                id="author" name="author"
                                placeholder="Введите автора"
                                value="{{ request('author') }}">
                        </div>

                        <div class="catalog-filter__group">
                            <span class="catalog-filter__label">Цена</span>
                            <div class="catalog-filter__price">
                                <input class="catalog-filter__input"
                                    type="number" name="price-from"
                                    placeholder="от 300" min="0"
                                    value="{{ request('price-from') }}">

                                <input class="catalog-filter__input"
                                    type="number" name="price-to"
                                    placeholder="до 1500" min="0"
                                    value="{{ request('price-to') }}">
                            </div>
                        </div>

                        <div class="catalog-filter__actions">
                            <button class="btn btn--accent catalog-filter__button"
                                    type="submit">
                                Применить фильтры
                            </button>
                            <a class="catalog-filter__clear"
                               href="{{ route('catalog.index') }}">
                                Сбросить
                            </a>
                        </div>
                    </form>
                </div>
            </aside>

            <section class="catalog-content">
                <div class="catalog-toolbar">
                    <div class="catalog-toolbar__info">
                        <h2 class="catalog-toolbar__title">
                            Найдено {{ $products->total() }} книг
                        </h2>
                        <p class="catalog-toolbar__text">
                            Фильтры можно комбинировать
                        </p>
                    </div>

                    <div class="catalog-toolbar__actions">
                        <a href="{{ route('catalog.index', array_merge(request()->except(['sort', 'page']), ['sort' => 'price-asc'])) }}"
                        class="sort-btn {{ request('sort', 'price-asc') === 'price-asc' ? 'sort-btn--active' : '' }}">
                            Сначала дешевле
                        </a>

                        <a href="{{ route('catalog.index', array_merge(request()->except(['sort', 'page']), ['sort' => 'price-desc'])) }}"
                        class="sort-btn {{ request('sort') === 'price-desc' ? 'sort-btn--active' : '' }}">
                            Сначала дороже
                        </a>
                    </div>
                </div>

                <div class="products-grid catalog-products" id="catalog-products">
                    @foreach($products as $book)
                        <article class="product-card">
                            <a class="product-card__image"
                               href="{{ route('catalog.show', $book->slug) }}">
                                @if($book->image)
                                    <img class="cover-media"
                                         src="{{ asset($book->image) }}"
                                         alt="{{ $book->name }}">
                                @else
                                    Обложка книги
                                @endif
                            </a>

                            <div class="product-card__content">
                                <h3 class="product-card__title">
                                    <a href="{{ route('catalog.show', $book->slug) }}">
                                        {{ $book->name }}
                                    </a>
                                </h3>

                                <p class="product-card__author">
                                    {{ $book->author }}
                                </p>

                                <div class="product-card__meta">
                                    <p class="product-card__price">
                                        {{ number_format((float) $book->price, 0, '', ' ') }} ₽
                                    </p>

                                    <p class="product-card__status {{ $book->quantity > 0 ? '' : 'product-card__status--out' }}">
                                        {{ $book->quantity > 0 ? 'В наличии' : 'Нет в наличии' }}
                                    </p>
                                </div>

                                <div class="product-card__actions">
                                    <button class="product-card__btn"
                                            type="button" disabled>
                                        Добавить в корзину
                                    </button>
                                    <button class="product-card__quick-btn"
                                            type="button" disabled>
                                        Быстрый просмотр
                                    </button>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                @if($products->isEmpty())
                    <div class="catalog-empty">
                        <h3 class="catalog-empty__title">
                            По заданным параметрам книги не найдены
                        </h3>
                    </div>
                @endif

                
                @if($products->hasPages())
                    <nav style="display: flex; align-items: center; justify-content: center; gap: 20px; margin-top: 30px;">
                        @if($products->previousPageUrl())
                            <a class="btn btn--secondary"
                            href="{{ $products->previousPageUrl() }}">
                                ← Назад
                            </a>
                        @endif

                        <span>
                            Страница {{ $products->currentPage() }}
                            из {{ $products->lastPage() }}
                        </span>

                        @if($products->nextPageUrl())
                            <a class="btn btn--secondary"
                            href="{{ $products->nextPageUrl() }}">
                                Вперёд →
                            </a>
                        @endif
                    </nav>
                @endif
            </section>
        </div>
    </div>
</section>
@endsection
