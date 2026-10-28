@extends('layouts.app')

@section('title', 'Каталог книг — BookMarket')

@section('content')
<div style="display: flex; gap: 30px;">
    <!-- Боковая колонка с категориями -->
    <aside style="width: 260px; flex-shrink: 0;">
        <h3 style="margin-bottom: 15px; font-size: 18px;">Жанры</h3>
        <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 8px;">
            <li>
                <a href="{{ route('catalog.index') }}" 
                   style="text-decoration: none; color: {{ !request('category') ? '#e74c3c; font-weight: bold;' : '#555;' }}">
                   Все книги
                </a>
            </li>
            @foreach($categories as $category)
                <li>
                    <a href="{{ route('catalog.index', ['category' => $category->slug]) }}" 
                       style="text-decoration: none; color: {{ request('category') === $category->slug ? '#e74c3c; font-weight: bold;' : '#555;' }}">
                        {{ $category->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    </aside>

    <!-- Сетка товаров -->
    <section style="flex-grow: 1;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2 style="margin: 0; font-size: 24px;">
                @if(request('search'))
                    Результаты поиска по запросу «{{ request('search') }}»
                @elseif(request('category'))
                    Категория: {{ $categories->firstWhere('slug', request('category'))?->name }}
                @else
                    Все книги каталога
                @endif
            </h2>
            <span style="color: #888;">Найдено: {{ $products->total() }}</span>
        </div>

        @if($products->isEmpty())
            <p style="padding: 40px 0; color: #777;">По вашему запросу ничего не найдено.</p>
        @else
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 25px;">
                @foreach($products as $book)
                    <article style="border: 1px solid #e1e8ed; border-radius: 8px; overflow: hidden; display: flex; flex-direction: column; background: #fff;">
                        <a href="{{ route('catalog.show', $book->slug) }}" style="text-align: center; background: #f8f9fa; padding: 15px 0;">
                            @if($book->image && file_exists(public_path($book->image)))
                                <img src="{{ asset($book->image) }}" alt="{{ $book->name }}" style="height: 220px; max-width: 90%; object-fit: contain;">
                            @else
                                <div style="height: 220px; display: flex; align-items: center; justify-content: center; color: #999;">Нет обложки</div>
                            @endif
                        </a>

                        <div style="padding: 15px; display: flex; flex-direction: column; flex-grow: 1;">
                            <span style="font-size: 12px; color: #e74c3c; font-weight: bold; text-transform: uppercase;">
                                {{ $book->category->name }}
                            </span>
                            <h4 style="margin: 8px 0 4px; font-size: 16px;">
                                <a href="{{ route('catalog.show', $book->slug) }}" style="text-decoration: none; color: #2c3e50;">
                                    {{ $book->name }}
                                </a>
                            </h4>
                            <p style="color: #7f8c8d; font-size: 14px; margin: 0 0 12px;">{{ $book->author }}</p>
                            
                            <div style="margin-top: auto; display: flex; justify-content: space-between; align-items: center; pt: 10px;">
                                <strong style="font-size: 18px; color: #27ae60;">{{ number_format($book->price, 2, '.', ' ') }} ₽</strong>
                                <a href="{{ route('catalog.show', $book->slug) }}" style="background: #3498db; color: #fff; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 13px;">
                                    Подробнее
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <!-- Пагинация -->
            <div style="margin-top: 30px;">
                {{ $products->links() }}
            </div>
        @endif
    </section>
</div>
@endsection