@extends('layouts.app')

@section('title', 'Контакты — BookMarket')

@section('content')
<section class="contacts-page">
    <div class="container">

        <p class="contacts-page__eyebrow">Контакты</p>
        <h1 class="contacts-page__title">
            Свяжитесь с нами удобным способом
        </h1>

        <div class="contacts-layout">

            <!-- Контактная информация -->
            <div class="contacts-info">

                <article class="contact-card">
                    <div class="contact-card__row">
                        <span class="contact-card__icon">☎</span>
                        <div class="contact-card__content">
                            <p class="contact-card__label">Телефон</p>
                            <a class="contact-card__value"
                               href="tel:+79001234567">
                                +7 (900) 123-45-67
                            </a>
                        </div>
                    </div>
                </article>

                <article class="contact-card">
                    <div class="contact-card__row">
                        <span class="contact-card__icon">✉</span>
                        <div class="contact-card__content">
                            <p class="contact-card__label">Email</p>
                            <a class="contact-card__value"
                               href="mailto:bookmarket@mail.ru">
                                bookmarket@mail.ru
                            </a>
                        </div>
                    </div>
                </article>

                <article class="contact-card">
                    <div class="contact-card__row">
                        <span class="contact-card__icon">⌖</span>
                        <div class="contact-card__content">
                            <p class="contact-card__label">Адрес</p>
                            <p class="contact-card__value">
                                г. Орёл, ул. Примерная, 10
                            </p>
                        </div>
                    </div>
                </article>

                <article class="contact-card contact-card--schedule">
                    <h2 class="contact-card__title">
                        График работы
                    </h2>
                    <div class="contact-schedule">
                        <p class="contact-schedule__item">
                            Пн–Пт: 09:00–20:00
                        </p>
                        <p class="contact-schedule__item">
                            Сб: 10:00–18:00
                        </p>
                        <p class="contact-schedule__item">
                            Вс: выходной
                        </p>
                    </div>
                </article>

            </div>

            <!-- Обратная связь -->
            <section class="contact-form-card">
                <h2 class="contact-form-card__title">
                    Форма обратной связи
                </h2>

                @if(session('success'))
                    <div class="contact-form__success">
                        {{ session('success') }}
                    </div>
                @endif

                <form class="contact-form"
                      action="{{ route('contacts.store') }}"
                      method="POST">
                    @csrf

                    @foreach([
                        'name' => 'Ваше имя',
                        'email' => 'Email',
                        'subject' => 'Тема сообщения',
                    ] as $field => $label)
                        <div class="contact-form__group">
                            <label class="visually-hidden"
                                   for="contact-{{ $field }}">
                                {{ $label }}
                            </label>

                            <input
                                class="contact-form__input @error($field) input-error @enderror"
                                id="contact-{{ $field }}"
                                name="{{ $field }}"
                                type="{{ $field === 'email' ? 'email' : 'text' }}"
                                placeholder="{{ $label }}"
                                value="{{ old($field, auth()->user()?->$field ?? '') }}"
                                required
                            >

                            @error($field)
                                <p class="error-message">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    @endforeach

                    <div class="contact-form__group">
                        <label class="visually-hidden"
                               for="contact-message">
                            Сообщение
                        </label>

                        <textarea
                            class="contact-form__textarea @error('message') input-error @enderror"
                            id="contact-message"
                            name="message"
                            placeholder="Сообщение"
                            required>{{ old('message') }}</textarea>

                        @error('message')
                            <p class="error-message">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <button class="btn btn--accent contact-form__button"
                            type="submit">
                        Отправить сообщение
                    </button>
                </form>
            </section>

        </div>
    </div>
</section>
@endsection
