
<article class="product-card"
         data-category="{{ $book->category?->name ?? 'Книги' }}"
         data-description="{{ $book->description }}">
    <a class="product-card__image"
       href="{{ route('catalog.show', $book->slug) }}">
        @if($book->image)
            <img class="cover-media"
                 src="{{ asset($book->image) }}"
                 alt="{{ $book->name }}">
        @else
            Обложка книги
        @endif
    </a>

    <div class="product-card__content">
        <h3 class="product-card__title">
            <a href="{{ route('catalog.show', $book->slug) }}">
                {{ $book->name }}
            </a>
        </h3>

        <p class="product-card__author">
            {{ $book->author }}
        </p>

        <div class="product-card__meta">
            <p class="product-card__price">
                {{ number_format((float) $book->price, 0, '', ' ') }} ₽
            </p>

            <p class="product-card__status {{ $book->status && $book->quantity > 0 ? '' : 'product-card__status--out' }}">
                {{ $book->status && $book->quantity > 0 ? 'В наличии' : 'Нет в наличии' }}
            </p>
        </div>

        <div class="product-card__actions">
            <button class="product-card__btn"
                    type="button" disabled>
                Добавить в корзину
            </button>

            <button class="product-card__quick-btn open-modal"
                    type="button">
                Быстрый просмотр
            </button>
        </div>
    </div>
</article>
