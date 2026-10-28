@extends('layouts.app')

@section('title', 'Вход и регистрация — BookMarket')

@section('content')
<section class="auth-page" style="padding-top: 28px;">
    <div class="container">
        <div class="auth-page__grid">

            <!-- Вход -->
            <section class="auth-card">
                <h1 class="auth-card__title">Вход</h1>
                <p class="auth-card__subtitle">
                    Введите email и пароль, чтобы войти в личный кабинет
                </p>

                <form class="auth-form"
                      action="{{ route('login.store') }}"
                      method="POST">
                    @csrf

                    <input class="auth-form__input"
                           type="email"
                           name="email"
                           placeholder="Email"
                           autocomplete="email"
                           value="{{ old('email') }}"
                           required>

                    <input class="auth-form__input"
                           type="password"
                           name="password"
                           placeholder="Пароль"
                           autocomplete="current-password"
                           required>

                    @if($errors->login->any())
                        <p class="error-message">
                            {{ $errors->login->first() }}
                        </p>
                    @endif

                    <button class="auth-form__button auth-form__button--dark"
                            type="submit">
                        Войти
                    </button>
                </form>
            </section>

            <!-- Регистрация -->
            <section class="auth-card">
                <h2 class="auth-card__title">Регистрация</h2>
                <p class="auth-card__subtitle">
                    Создайте аккаунт, чтобы сохранять данные
                    и отслеживать заказы
                </p>

                <form class="auth-form"
                      action="{{ route('register.store') }}"
                      method="POST">
                    @csrf

                    <input class="auth-form__input"
                           type="text"
                           name="name"
                           placeholder="Имя"
                           autocomplete="name"
                           value="{{ old('name') }}"
                           required>

                    <input class="auth-form__input"
                           type="email"
                           name="email"
                           placeholder="Email"
                           autocomplete="email"
                           value="{{ old('email') }}"
                           required>

                    <input class="auth-form__input"
                           type="password"
                           name="password"
                           placeholder="Пароль (не менее 8 символов)"
                           autocomplete="new-password"
                           required>

                    <input class="auth-form__input"
                           type="password"
                           name="password_confirmation"
                           placeholder="Повторите пароль"
                           autocomplete="new-password"
                           required>

                    @if($errors->register->any())
                        @foreach($errors->register->all() as $error)
                            <p class="error-message">{{ $error }}</p>
                        @endforeach
                    @endif

                    <button class="auth-form__button auth-form__button--accent"
                            type="submit">
                        Создать аккаунт
                    </button>
                </form>
            </section>

        </div>
    </div>
</section>
@endsection