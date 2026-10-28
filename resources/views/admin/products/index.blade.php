@extends('layouts.app')

@section('title', 'Управление книгами — BookMarket')

@push('styles')
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
@endpush

@section('content')
<section class="admin-page">
    <div class="container">

        @include('admin.partials.nav')

        
        @if(session('success'))
            <div class="admin-alert admin-alert--success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="admin-alert admin-alert--error">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <section class="admin-section" id="product-form">
            <div class="admin-section__head">
                <h1 class="admin-section__title">Добавить книгу</h1>
            </div>

            <form class="admin-form"
                action="{{ route('admin.products.store') }}"
                method="POST"
                enctype="multipart/form-data">
                @csrf

                <label class="admin-form__field">
                    <span>Название</span>
                    <input name="name" value="{{ old('name') }}" required>
                </label>

                <label class="admin-form__field">
                    <span>Автор</span>
                    <input name="author" value="{{ old('author') }}" required>
                </label>

                <label class="admin-form__field">
                    <span>Категория</span>
                    <select name="category_id" required>
                        <option value="">Выберите категорию</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                @selected(old('category_id') == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </label>

                <label class="admin-form__field">
                    <span>Цена</span>
                    <input type="number" name="price"
                        step="0.01" min="0"
                        value="{{ old('price') }}" required>
                </label>

                <label class="admin-form__field">
                    <span>Количество</span>
                    <input type="number" name="quantity"
                        min="0" value="{{ old('quantity', 0) }}" required>
                </label>

                <label class="admin-form__field">
                    <span>Издательство</span>
                    <input name="publisher" value="{{ old('publisher') }}">
                </label>

                <label class="admin-form__field">
                    <span>Год издания</span>
                    <input type="number" name="publication_year"
                        min="1901" max="2155"
                        value="{{ old('publication_year') }}">
                </label>

                <label class="admin-form__field">
                    <span>Количество страниц</span>
                    <input type="number" name="pages" min="1"
                        value="{{ old('pages') }}">
                </label>

                <label class="admin-form__field admin-form__field--wide">
                    <span>Загрузить обложку</span>
                    <input type="file" name="image_file"
                        accept="image/jpeg,image/png,image/webp,image/gif">
                </label>

                <label class="admin-form__field admin-form__field--wide">
                    <span>Краткое описание</span>
                    <textarea name="description" rows="3"
                            required>{{ old('description') }}</textarea>
                </label>

                <label class="admin-form__field admin-form__field--wide">
                    <span>Полное описание</span>
                    <textarea name="full_description" rows="5">{{ old('full_description') }}</textarea>
                </label>

                <div class="admin-form__checks">
                    <label>
                        <input type="checkbox" name="is_new" value="1"
                            @checked(old('is_new'))>
                        Новинка
                    </label>

                    <label>
                        <input type="checkbox" name="is_hit" value="1"
                            @checked(old('is_hit'))>
                        Хит
                    </label>

                    <label>
                        <input type="hidden" name="status" value="0">
                        <input type="checkbox" name="status" value="1"
                            @checked(old('status', 1))>
                        Активна
                    </label>
                </div>

                <div class="admin-form__actions">
                    <button class="btn btn--accent" type="submit">
                        Сохранить книгу
                    </button>
                </div>
            </form>
        </section>


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
