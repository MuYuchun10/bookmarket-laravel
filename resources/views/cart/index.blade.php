
@extends('layouts.app')

@section('title', 'Корзина — BookMarket')

@section('content')
<section class="cart-page">
    <div class="container">
        <p class="cart-page__eyebrow">Корзина</p>
        <h1 class="cart-page__title">
            Проверьте выбранные книги перед оформлением заказа
        </h1>

        <div class="cart-layout">
            <section class="cart-items">
                @forelse($items as $item)
                    @php
                        $book = $item['product'];
                        $quantity = $item['quantity'];
                    @endphp

                    <article class="cart-item">
                        <a class="cart-item__image"
                           href="{{ route('catalog.show', $book->slug) }}">
                            @if($book->image)
                                <img class="cart-item__cover cover-media"
                                     src="{{ asset($book->image) }}"
                                     alt="{{ $book->name }}">
                            @else
                                Обложка книги
                            @endif
                        </a>

                        <div class="cart-item__content">
                            <h2 class="cart-item__title">
                                <a href="{{ route('catalog.show', $book->slug) }}">
                                    {{ $book->name }}
                                </a>
                            </h2>

                            <p class="cart-item__author">
                                {{ $book->author }}
                            </p>

                            <p class="cart-item__status">В наличии</p>
                        </div>

                        <div class="cart-item__counter">
                            <span class="cart-item__counter-value">
                                {{ $quantity }} шт.
                            </span>
                        </div>

                        <div class="cart-item__summary">
                            <p class="cart-item__price">
                                {{ number_format((float) $book->price * $quantity, 0, '', ' ') }} ₽
                            </p>
                        </div>
                    </article>
                @empty
                    <article class="cart-empty">
                        <div class="cart-empty__content">
                            <h2 class="cart-empty__title">
                                Корзина пока пуста
                            </h2>
                            <p class="cart-empty__text">
                                Добавьте книги из каталога,
                                и они появятся здесь.
                            </p>
                            <a class="btn btn--accent"
                               href="{{ route('catalog.index') }}">
                                Перейти в каталог
                            </a>
                        </div>
                    </article>
                @endforelse
            </section>

            <aside class="cart-total">
                <h2 class="cart-total__title">Итого по заказу</h2>

                <div class="cart-total__rows">
                    <div class="cart-total__row">
                        <span>Товары</span>
                        <span>
                            {{ number_format((float) $subtotal, 0, '', ' ') }} ₽
                        </span>
                    </div>
                </div>

                <div class="cart-total__result">
                    <span>Итого</span>
                    <span>
                        {{ number_format((float) $subtotal, 0, '', ' ') }} ₽
                    </span>
                </div>

                <button class="btn btn--accent cart-total__button"
                        type="button" disabled>
                    Перейти к оформлению
                </button>
            </aside>
        </div>
    </div>
</section>
@endsection
