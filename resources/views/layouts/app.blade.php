
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'BookMarket')</title>

    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">

    <link href="{{ asset('css/normalize.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body class="page">
    @include('partials.header')

    <main class="main">
        @yield('content')
    </main>

    @include('partials.footer')

    
    <div class="modal" id="quickViewModal" aria-hidden="true">
        <div class="modal__content"
            role="dialog"
            aria-modal="true"
            aria-labelledby="quickViewTitle">

            <button class="modal__close"
                    type="button" aria-label="Закрыть">×</button>

            <h2 class="modal__title" id="quickViewTitle">
                Быстрый просмотр
            </h2>

            <div class="modal__body">
                <article class="quick-view">
                    <div class="quick-view__cover">
                        <img class="cover-media" alt="">
                        <span>Обложка отсутствует</span>
                    </div>

                    <div class="quick-view__content">
                        <span class="quick-view__category"></span>
                        <h3 class="quick-view__title"></h3>
                        <p class="quick-view__author"></p>
                        <p class="quick-view__price"></p>
                        <p class="quick-view__status"></p>
                        <p class="quick-view__description"></p>

                        <a class="btn btn--accent quick-view__button">
                            Подробнее
                        </a>
                    </div>
                </article>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/quick-view.js') }}" defer></script>


    @stack('scripts')
</body>
</html>
  