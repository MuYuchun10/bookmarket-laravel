
@extends('layouts.app')

@section('title', $product->name . ' — BookMarket')

@section('content')
@php
    $available = $product->status && $product->quantity > 0;

    $description = $product->full_description
        ?: $product->description
        ?: 'Описание книги скоро появится.';

    $paragraphs = preg_split('/\R{2,}/u', trim($description));

    $specs = [
        'Издательство' => $product->publisher,
        'Год издания' => $product->publication_year,
        'Количество страниц' => $product->pages,
        'Язык' => $product->language,
        'Тип обложки' => $product->cover_type,
        'Артикул' => $product->article,
    ];
@endphp

<section class="book-page" aria-labelledby="book-title">
    <div class="container">

        <!-- Навигация -->
        <nav class="breadcrumbs" aria-label="Хлебные крошки">
            <a class="breadcrumbs__link" href="{{ route('home') }}">
                Главная
            </a>
            <span class="breadcrumbs__separator">/</span>

            <a class="breadcrumbs__link" href="{{ route('catalog.index') }}">
                Каталог
            </a>
            <span class="breadcrumbs__separator">/</span>

            <a class="breadcrumbs__link"
               href="{{ route('catalog.index', ['category' => $product->category->slug]) }}">
                {{ $product->category->name }}
            </a>
            <span class="breadcrumbs__separator">/</span>

            <span class="breadcrumbs__current">
                {{ $product->name }}
            </span>
        </nav>

        <div class="book-layout">

            <!-- Обложка -->
            <div class="book-gallery">
                <div class="book-gallery__frame">
                    @if($product->image)
                        <img
                            class="book-gallery__image"
                            src="{{ asset($product->image) }}"
                            alt="Обложка книги {{ $product->name }}"
                            id="mainImage">
                    @else
                        <p>Обложка отсутствует</p>
                    @endif
                </div>
            </div>

            <!-- Информация о книге -->
            <article class="book-card">
                <div class="book-card__badge">
                    {{ $product->category->name }}
                </div>

                <h1 class="book-card__title" id="book-title">
                    {{ $product->name }}
                </h1>

                <p class="book-card__author">
                    {{ $product->author }}
                </p>

                <div class="book-card__purchase">
                    <p class="book-card__price">
                        {{ number_format((float) $product->price, 0, '', ' ') }} ₽
                    </p>

                    <p class="book-card__stock {{ $available ? '' : 'book-card__stock--out' }}">
                        {{ $available ? 'В наличии' : 'Нет в наличии' }}
                    </p>
                </div>

                <!-- Описание -->
                <div class="book-card__description">
                    @foreach($paragraphs as $paragraph)
                        <p>{{ $paragraph }}</p>
                    @endforeach
                </div>

                <!-- Корзину подключим позже -->
                <div class="book-card__actions">
                    <button class="btn btn--primary"
                            type="button" disabled>
                        Добавить в корзину
                    </button>

                    <button class="btn btn--secondary"
                            type="button" disabled>
                        Купить сейчас
                    </button>
                </div>

                <!-- Характеристики -->
                <div class="book-specs">
                    @foreach($specs as $label => $value)
                        @if(filled($value))
                            <div class="book-spec">
                                <p class="book-spec__label">
                                    {{ $label }}
                                </p>
                                <p class="book-spec__value">
                                    {{ $value }}
                                </p>
                            </div>
                        @endif
                    @endforeach
                </div>
            </article>
        </div>
    </div>
</section>
@endsection
