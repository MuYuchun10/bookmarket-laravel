@extends('layouts.app')

@section('title', 'Личный кабинет — BookMarket')

@section('content')
<section class="profile-page">
    <div class="container">

        <!-- Шапка профиля -->
        <div class="profile-hero">
            <div class="profile-hero__info">
                <div class="profile-hero__avatar">👤</div>

                <div class="profile-hero__content">
                    <h1 class="profile-hero__title">
                        Личный кабинет
                    </h1>

                    <p class="profile-hero__text">
                        {{ $user->name }} · {{ $user->email }}
                    </p>
                </div>
            </div>

            <form action="{{ route('logout') }}" method="POST">
                @csrf

                <button class="btn btn--primary profile-hero__button"
                        type="submit">
                    Выйти из аккаунта
                </button>
            </form>
        </div>

        <!-- Данные профиля -->
        <section class="profile-card">
            <div class="profile-section-heading">
                <span class="profile-section-heading__icon">👤</span>

                <h2 class="profile-section-heading__title">
                    Данные профиля
                </h2>
            </div>

            @if(session('success'))
                <div class="contact-form__success">
                    {{ session('success') }}
                </div>
            @endif

            <form class="profile-form"
                  id="profile-form"
                  action="{{ route('profile.update') }}"
                  method="POST">
                @csrf
                @method('PATCH')

                @foreach([
                    'name' => 'Имя',
                    'email' => 'Email',
                    'phone' => 'Телефон',
                    'city' => 'Город',
                    'address' => 'Адрес',
                    'postcode' => 'Почтовый индекс',
                ] as $field => $label)
                    <div>
                        <label class="visually-hidden"
                               for="profile-{{ $field }}">
                            {{ $label }}
                        </label>

                        <input
                            class="profile-form__input @error($field) input-error @enderror"
                            id="profile-{{ $field }}"
                            name="{{ $field }}"
                            type="{{ $field === 'email' ? 'email' : ($field === 'phone' ? 'tel' : 'text') }}"
                            placeholder="{{ $label }}"
                            value="{{ old($field, $user->$field) }}"
                            @required(in_array($field, ['name', 'email']))
                        >

                        @error($field)
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                @endforeach
            </form>

            <button class="btn btn--accent profile-form__button"
                    type="submit"
                    form="profile-form">
                Сохранить изменения
            </button>
        </section>

        <!-- История заказов -->
        <section class="profile-card">
            <div class="profile-section-heading">
                <span class="profile-section-heading__icon">📦</span>

                <h2 class="profile-section-heading__title">
                    История заказов
                </h2>
            </div>

            <div class="orders-list">
                @forelse($orders as $order)
                    <article class="order-row">
                        <div class="order-row__id">
                            #{{ $order->order_number }}
                        </div>

                        <div class="order-row__count">
                            {{ $order->items->sum('quantity') }} шт.
                        </div>

                        <div class="order-row__price">
                            {{ number_format((float) $order->total, 0, '', ' ') }} ₽
                        </div>

                        <div class="order-row__status">
                            {{ [
                                'new' => 'Новый',
                                'processing' => 'В обработке',
                                'sent' => 'Отправлен',
                                'done' => 'Выполнен',
                                'cancelled' => 'Отменён',
                            ][$order->status] ?? $order->status }}
                        </div>
                    </article>

                    <div class="orders-list__details">
                        @foreach($order->items as $item)
                            <div>
                                {{ $item->product_name }} —
                                {{ $item->quantity }} шт. ×
                                {{ number_format((float) $item->price, 0, '', ' ') }} ₽
                            </div>
                        @endforeach
                    </div>
                @empty
                    <p class="orders-list__empty">
                        История заказов пока пуста.
                    </p>
                @endforelse
            </div>
        </section>

    </div>
</section>
@endsection
