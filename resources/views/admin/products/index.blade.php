@extends('layouts.app')

@section('title', 'Управление книгами — BookMarket')

@push('styles')
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
@endpush

@section('content')
<section class="admin-page">
    <div class="container">

        @include('admin.partials.nav')

        <section class="admin-section" id="products-list">
            <div class="admin-section__head">
                <h1 class="admin-section__title">
                    Список книг
                </h1>
            </div>

            <!-- Фильтры -->
            <form action="{{ route('admin.products.index') }}"
                  method="GET" class="admin-filter">

                <input type="text"
                       name="q"
                       placeholder="Поиск по названию, автору или артикулу"
                       value="{{ request('q') }}">

                <select name="category_id">
                    <option value="">Все категории</option>

                    @foreach($categories as $category)
                        <option value="{{ $category->id }}"
                            @selected(request('category_id') == $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

                <select name="status">
                    <option value="">Любой статус</option>
                    <option value="1" @selected(request('status') === '1')>
                        Активные
                    </option>
                    <option value="0" @selected(request('status') === '0')>
                        Скрытые
                    </option>
                </select>

                <button class="btn btn--secondary" type="submit">
                    Найти
                </button>
            </form>

            <!-- Таблица -->
            @if($products->isEmpty())
                <p class="admin-empty">Книги не найдены.</p>
            @else
                <div class="admin-table admin-table--products">

                    <div class="admin-table__head">
                        <div>Книга</div>
                        <div>Категория</div>
                        <div>Цена</div>
                        <div>Остаток</div>
                        <div>Статус</div>
                        <div>Действия</div>
                    </div>

                    @foreach($products as $book)
                        <article class="admin-table__row">

                            <div class="admin-table__cell admin-table__cell--title">
                                {{ $book->name }}
                                <br>
                                <small>{{ $book->author }}</small>
                            </div>

                            <div class="admin-table__cell">
                                {{ $book->category?->name ?? 'Без категории' }}
                            </div>

                            <div class="admin-table__cell">
                                {{ number_format((float) $book->price, 0, '', ' ') }} ₽
                            </div>

                            <div class="admin-table__cell">
                                {{ $book->quantity }}
                            </div>

                            <div class="admin-table__cell">
                                {{ $book->status ? 'Активна' : 'Скрыта' }}
                            </div>

                            <div class="admin-table__cell admin-table__actions">
                                <a class="admin-action admin-action--edit"
                                   href="{{ route('catalog.show', $book->slug) }}">
                                    Открыть
                                </a>
                            </div>

                        </article>
                    @endforeach
                </div>

                <!-- Пагинация -->
                @if($products->lastPage() > 1)
                    <nav class="admin-pagination">
                        @for($page = 1; $page <= $products->lastPage(); $page++)
                            <a class="admin-pagination__link {{ $products->currentPage() === $page ? 'admin-pagination__link--active' : '' }}"
                               href="{{ $products->url($page) }}#products-list">
                                {{ $page }}
                            </a>
                        @endfor
                    </nav>
                @endif
            @endif
        </section>

    </div>
</section>
@endsection
