
@extends('layouts.app')

@section('title', 'Администрирование — BookMarket')

@push('styles')
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
@endpush

@section('content')
<section class="admin-page">
    <div class="container">
        @include('admin.partials.nav')

        <!-- Статистика -->
        <section class="admin-dashboard">
            @foreach([
                'Книги' => $productsCount,
                'Категории' => $categoriesCount,
                'Заказы' => $ordersCount,
                'Пользователи' => $usersCount,
            ] as $label => $count)

                <article class="admin-card">
                    <span class="admin-card__label">
                        {{ $label }}
                    </span>

                    <strong class="admin-card__value">
                        {{ $count }}
                    </strong>
                </article>
            @endforeach
        </section>

        <!-- Последние заказы -->
        <section class="admin-section">
            <div class="admin-section__head">
                <h1 class="admin-section__title">
                    Последние заказы
                </h1>
            </div>

            @if($latestOrders->isEmpty())
                <p class="admin-empty">
                    Заказов пока нет.
                </p>
            @else
                <div class="admin-table admin-table--orders">

                    <div class="admin-table__head">
                        <div>Номер</div>
                        <div>Покупатель</div>
                        <div>Сумма</div>
                        <div>Статус</div>
                    </div>

                    @foreach($latestOrders as $order)
                        <article class="admin-table__row">
                            <div class="admin-table__cell admin-table__cell--title">
                                #{{ $order->order_number }}
                            </div>

                            <div class="admin-table__cell">
                                {{ $order->customer_name }}
                            </div>

                            <div class="admin-table__cell">
                                {{ number_format((float) $order->total, 0, '', ' ') }} ₽
                            </div>

                            <div class="admin-table__cell">
                                {{ [
                                    'new' => 'Новый',
                                    'processing' => 'В обработке',
                                    'sent' => 'Отправлен',
                                    'done' => 'Доставлен',
                                    'cancelled' => 'Отменён',
                                ][$order->status] ?? $order->status }}
                            </div>
                        </article>
                    @endforeach

                </div>
            @endif
        </section>

    </div>
</section>
@endsection
