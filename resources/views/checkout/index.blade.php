@extends('layouts.app')

@section('title', 'Оформление заказа — BookMarket')

@section('content')
<section class="checkout-page">
    <div class="container">
        <p class="checkout-page__eyebrow">Заказ</p>

        <h1 class="checkout-page__title">
            {{ $buyNow
                ? 'Оформление выбранной книги'
                : 'Заполните данные для доставки' }}
        </h1>

        <div class="checkout-layout">
            <section class="checkout-form-card">
                <form class="checkout-form"
                      id="checkout-form"
                      action="{{ route('checkout.store') }}"
                      method="POST">
                    @csrf
                    <input type="hidden" name="mode"
                        value="{{ $buyNow ? 'buy-now' : 'cart' }}">

                    @if($errors->has('cart'))
                        <p class="error-message checkout-form__group--full">
                            {{ $errors->first('cart') }}
                        </p>
                    @endif

                    @foreach([
                        'name' => ['Имя получателя', auth()->user()->name],
                        'phone' => ['Номер телефона', auth()->user()->phone],
                        'city' => ['Город', auth()->user()->city],
                        'street' => ['Улица', ''],
                        'house' => ['Дом', ''],
                        'flat' => ['Квартира', ''],
                    ] as $field => [$label, $value])

                        <div class="checkout-form__group">
                            <label class="visually-hidden"
                                   for="checkout-{{ $field }}">
                                {{ $label }}
                            </label>

                            <input
                                class="checkout-form__input @error($field) input-error @enderror"
                                id="checkout-{{ $field }}"
                                name="{{ $field }}"
                                type="{{ $field === 'phone' ? 'tel' : 'text' }}"
                                placeholder="{{ $label }}"
                                value="{{ old($field, $value) }}"
                                @required($field !== 'flat')
                            >

                            @error($field)
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    @endforeach

                    <div class="checkout-form__group checkout-form__group--full">
                        <label class="visually-hidden"
                               for="checkout-comment">
                            Комментарий к заказу
                        </label>

                        <textarea class="checkout-form__textarea"
                                  id="checkout-comment"
                                  name="comment"
                                  placeholder="Комментарий к заказу">{{ old('comment') }}</textarea>

                        @error('comment')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="checkout-options">
                        <div class="checkout-option">
                            Способ оплаты: при получении
                        </div>
                        <div class="checkout-option">
                            Доставка: курьером
                        </div>
                    </div>
                </form>
            </section>

            <aside class="checkout-summary">
                <h2 class="checkout-summary__title">
                    Ваш заказ
                </h2>

                <div class="checkout-summary__rows">
                    <div class="checkout-summary__row">
                        <span>Товары</span>
                        <span>
                            {{ number_format($subtotal, 0, '', ' ') }} ₽
                        </span>
                    </div>

                    @if($discount > 0)
                        <div class="checkout-summary__row">
                            <span>Скидка на первый заказ (10%)</span>
                            <span>
                                −{{ number_format($discount, 0, '', ' ') }} ₽
                            </span>
                        </div>
                    @endif
                </div>

                <div class="checkout-summary__total">
                    <span>Итого</span>
                    <span>
                        {{ number_format($total, 0, '', ' ') }} ₽
                    </span>
                </div>

                <button class="btn btn--primary checkout-summary__button"
                        form="checkout-form"
                        type="submit">
                    Подтвердить заказ
                </button>
            </aside>
        </div>
    </div>
</section>
@endsection
