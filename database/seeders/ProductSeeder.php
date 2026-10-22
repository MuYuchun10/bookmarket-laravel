<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'id' => 1, 'category_id' => 1, 'name' => '1984', 'slug' => 'book-1984',
                'author' => 'Джордж Оруэлл', 'description' => 'Культовый роман-антиутопия о тотальном контроле, страхе и мире подавленной свободы.',
                'full_description' => '«1984» Джорджа Оруэлла — мрачная антиутопия о мире тотального надзора...',
                'price' => 590.00, 'image' => 'images/products/20260519204044-5cd7767f-1984-front.jpg',
                'quantity' => 9, 'is_new' => false, 'is_hit' => true, 'status' => true,
                'publisher' => 'Book House', 'publication_year' => 2023, 'pages' => 352,
                'language' => 'Русский', 'cover_type' => 'Твердая', 'article' => 'BK-1984-14',
            ],
            [
                'id' => 2, 'category_id' => 1, 'name' => 'Мастер и Маргарита', 'slug' => 'book-master-margarita',
                'author' => 'Михаил Булгаков', 'description' => 'Мистический роман о любви, добре, зле и судьбе на фоне Москвы.',
                'full_description' => 'Роман Михаила Булгакова объединяет сатиру, мистику, философию и историю любви...',
                'price' => 720.00, 'image' => 'images/products/20260519204315-90897dd8-master-front.jpg',
                'quantity' => 11, 'is_new' => true, 'is_hit' => true, 'status' => true,
                'publisher' => 'Эксмо', 'publication_year' => 2024, 'pages' => 480,
                'language' => 'Русский', 'cover_type' => 'Твердая', 'article' => 'BK-MM-09',
            ],
            [
                'id' => 3, 'category_id' => 6, 'name' => 'Атомные привычки', 'slug' => 'book-atomic-habits',
                'author' => 'Джеймс Клир', 'description' => 'Практичная книга о том, как маленькие привычки приводят к большим результатам.',
                'full_description' => 'Джеймс Клир показывает, как ежедневные небольшие изменения накапливаются...',
                'price' => 850.00, 'image' => 'images/products/20260519204541-7c992d38-atomic-front.jpg',
                'quantity' => 8, 'is_new' => false, 'is_hit' => true, 'status' => true,
                'publisher' => 'МИФ', 'publication_year' => 2024, 'pages' => 368,
                'language' => 'Русский', 'cover_type' => 'Мягкая', 'article' => 'BK-AH-21',
            ],
            [
                'id' => 4, 'category_id' => 2, 'name' => 'Гарри Поттер и философский камень', 'slug' => 'book-harry-potter-philosopher-stone',
                'author' => 'Дж. К. Роулинг', 'description' => 'История о мире магии, дружбе, приключениях и борьбе со злом.',
                'full_description' => 'Первая книга знаменитой серии открывает читателю школу магии Хогвартс...',
                'price' => 910.00, 'image' => 'images/products/20260519204639-682202d6-harry-front.jpg',
                'quantity' => 10, 'is_new' => false, 'is_hit' => true, 'status' => true,
                'publisher' => 'Росмэн', 'publication_year' => 2022, 'pages' => 432,
                'language' => 'Русский', 'cover_type' => 'Твердая', 'article' => 'BK-HP-01',
            ],
            [
                'id' => 5, 'category_id' => 4, 'name' => 'Чистый код', 'slug' => 'book-clean-code',
                'author' => 'Роберт Мартин', 'description' => 'Книга о принципах написания понятного, поддерживаемого и качественного кода.',
                'full_description' => 'Популярная книга Роберта Мартина о том, как писать код, который легко читать...',
                'price' => 1200.00, 'image' => 'images/products/20260519204916-d6f6296e-clear-front.jpg',
                'quantity' => 7, 'is_new' => false, 'is_hit' => true, 'status' => true,
                'publisher' => 'Питер', 'publication_year' => 2023, 'pages' => 464,
                'language' => 'Русский', 'cover_type' => 'Твердая', 'article' => 'BK-CC-17',
            ],
            [
                'id' => 6, 'category_id' => 3, 'name' => 'Убийство в Восточном экспрессе', 'slug' => 'book-orient-express',
                'author' => 'Агата Кристи', 'description' => 'Классический детектив о загадочном убийстве в роскошном поезде.',
                'full_description' => 'Один из самых известных романов Агаты Кристи...',
                'price' => 640.00, 'image' => 'images/products/20260519205015-21436baa-dead-front.jpg',
                'quantity' => 10, 'is_new' => false, 'is_hit' => true, 'status' => true,
                'publisher' => 'АСТ', 'publication_year' => 2024, 'pages' => 320,
                'language' => 'Русский', 'cover_type' => 'Мягкая', 'article' => 'BK-OE-05',
            ],
            [
                'id' => 7, 'category_id' => 2, 'name' => 'Ведьмак. Последнее желание', 'slug' => 'book-witcher-last-wish',
                'author' => 'Анджей Сапковский', 'description' => 'Сборник историй о ведьмаке Геральте, монстрах и сложном выборе.',
                'full_description' => '«Последнее желание» знакомит с Геральтом из Ривии...',
                'price' => 780.00, 'image' => 'images/products/20260519205049-aaee407c-witcher-front.jpg',
                'quantity' => 11, 'is_new' => true, 'is_hit' => true, 'status' => true,
                'publisher' => 'АСТ', 'publication_year' => 2024, 'pages' => 384,
                'language' => 'Русский', 'cover_type' => 'Твердая', 'article' => 'BK-WT-01',
            ],
            [
                'id' => 8, 'category_id' => 7, 'name' => 'Дюна', 'slug' => 'book-dune',
                'author' => 'Фрэнк Герберт', 'description' => 'Масштабная научная фантастика о планете Арракис, власти и судьбе.',
                'full_description' => 'Фрэнк Герберт создал эпическую историю о политике, религии...',
                'price' => 990.00, 'image' => 'images/products/20260519205120-fb2d786d-dune-front.jpg',
                'quantity' => 6, 'is_new' => false, 'is_hit' => true, 'status' => true,
                'publisher' => 'Азбука', 'publication_year' => 2023, 'pages' => 704,
                'language' => 'Русский', 'cover_type' => 'Твердая', 'article' => 'BK-DUNE-07',
            ],
            [
                'id' => 9, 'category_id' => 1, 'name' => 'Преступление и наказание', 'slug' => 'book-crime-punishment',
                'author' => 'Федор Достоевский', 'description' => 'Психологический роман о преступлении, совести и нравственном выборе.',
                'full_description' => 'Классический роман Достоевского исследует внутренний мир человека...',
                'price' => 560.00, 'image' => 'images/products/20260519205147-4191d6a2-prestuplenie-front.jpg',
                'quantity' => 14, 'is_new' => false, 'is_hit' => false, 'status' => true,
                'publisher' => 'Азбука', 'publication_year' => 2023, 'pages' => 608,
                'language' => 'Русский', 'cover_type' => 'Мягкая', 'article' => 'BK-CP-11',
            ],
            [
                'id' => 10, 'category_id' => 1, 'name' => 'Маленький принц', 'slug' => 'book-little-prince',
                'author' => 'Антуан де Сент-Экзюпери', 'description' => 'Философская сказка о дружбе, взрослении и главных ценностях.',
                'full_description' => 'Небольшая, но очень глубокая книга о взгляде на мир...',
                'price' => 430.00, 'image' => 'images/products/20260519205224-7b9085e0-prince-front.jpg',
                'quantity' => 20, 'is_new' => false, 'is_hit' => false, 'status' => true,
                'publisher' => 'Эксмо', 'publication_year' => 2024, 'pages' => 128,
                'language' => 'Русский', 'cover_type' => 'Твердая', 'article' => 'BK-LP-03',
            ],
            [
                'id' => 11, 'category_id' => 5, 'name' => 'Думай медленно... решай быстро', 'slug' => 'book-thinking-fast-slow',
                'author' => 'Даниэль Канеман', 'description' => 'Книга о мышлении, ошибках восприятия и принятии решений.',
                'full_description' => 'Даниэль Канеман объясняет, как работают быстрые интуитивные реакции...',
                'price' => 980.00, 'image' => 'images/products/20260519205327-19be69e5-think-front.jpg',
                'quantity' => 5, 'is_new' => false, 'is_hit' => false, 'status' => true,
                'publisher' => 'АСТ', 'publication_year' => 2023, 'pages' => 656,
                'language' => 'Русский', 'cover_type' => 'Твердая', 'article' => 'BK-TFS-22',
            ],
            [
                'id' => 12, 'category_id' => 5, 'name' => 'Богатый папа, бедный папа', 'slug' => 'book-rich-dad-poor-dad',
                'author' => 'Роберт Кийосаки', 'description' => 'Популярная книга о финансовом мышлении и личных деньгах.',
                'full_description' => 'Автор рассказывает о различиях в подходе к деньгам, активам...',
                'price' => 760.00, 'image' => 'images/products/20260519205355-f9f9fc1c-papa-front.jpg',
                'quantity' => 13, 'is_new' => false, 'is_hit' => true, 'status' => true,
                'publisher' => 'Попурри', 'publication_year' => 2023, 'pages' => 352,
                'language' => 'Русский', 'cover_type' => 'Мягкая', 'article' => 'BK-RDPD-18',
            ],
            [
                'id' => 13, 'category_id' => 4, 'name' => 'PHP и MySQL. Разработка веб-приложений', 'slug' => 'book-php-mysql-web',
                'author' => 'Люк Веллинг, Лора Томсон', 'description' => 'Практическое руководство по созданию веб-приложений на PHP и MySQL.',
                'full_description' => 'Книга объясняет базовые и прикладные приемы разработки сайтов...',
                'price' => 1350.00, 'image' => 'images/products/20260519205442-18201771-php-front.jpg',
                'quantity' => 4, 'is_new' => true, 'is_hit' => true, 'status' => true,
                'publisher' => 'Диалектика', 'publication_year' => 2022, 'pages' => 768,
                'language' => 'Русский', 'cover_type' => 'Твердая', 'article' => 'BK-PHP-DB-06',
            ],
            [
                'id' => 14, 'category_id' => 7, 'name' => 'Автостопом по галактике', 'slug' => 'book-hitchhikers-guide',
                'author' => 'Дуглас Адамс', 'description' => 'Ироничная фантастика о путешествиях по космосу и странностях вселенной.',
                'full_description' => 'Дуглас Адамс смешивает абсурдный юмор, приключения...',
                'price' => 690.00, 'image' => 'images/products/20260519205509-3a9c5ebb-autostop-front.jpg',
                'quantity' => 9, 'is_new' => false, 'is_hit' => false, 'status' => true,
                'publisher' => 'АСТ', 'publication_year' => 2024, 'pages' => 288,
                'language' => 'Русский', 'cover_type' => 'Мягкая', 'article' => 'BK-HHG-42',
            ],
            [
                'id' => 15, 'category_id' => 3, 'name' => 'Шерлок Холмс. Этюд в багровых тонах', 'slug' => 'book-sherlock-study-scarlet',
                'author' => 'Артур Конан Дойл', 'description' => 'Первая история о Шерлоке Холмсе и докторе Ватсоне.',
                'full_description' => 'В этом произведении читатель впервые знакомится с Холмсом...',
                'price' => 520.00, 'image' => 'images/products/20260519205534-c9af8071-sherlok-front.jpg',
                'quantity' => 15, 'is_new' => false, 'is_hit' => false, 'status' => true,
                'publisher' => 'Азбука', 'publication_year' => 2024, 'pages' => 256,
                'language' => 'Русский', 'cover_type' => 'Мягкая', 'article' => 'BK-SH-01',
            ],
            [
                'id' => 16, 'category_id' => 1, 'name' => 'Евгений Онегин', 'slug' => 'book-evgeniy-onegin',
                'author' => 'Александр Пушкин', 'description' => 'Роман в стихах о любви, выборе и светском обществе.',
                'full_description' => 'Классическое произведение русской литературы о взрослении...',
                'price' => 480.00, 'image' => 'images/products/20260519205601-55e3168b-eugenii-front.jpg',
                'quantity' => 17, 'is_new' => false, 'is_hit' => false, 'status' => true,
                'publisher' => 'Азбука', 'publication_year' => 2024, 'pages' => 288,
                'language' => 'Русский', 'cover_type' => 'Твердая', 'article' => 'BK-EO-02',
            ],
            [
                'id' => 17, 'category_id' => 1, 'name' => 'Три товарища', 'slug' => 'book-three-comrades',
                'author' => 'Эрих Мария Ремарк', 'description' => 'Роман о дружбе, любви и попытке сохранить надежду после войны.',
                'full_description' => 'История трех друзей и их жизни в послевоенной Германии...',
                'price' => 740.00, 'image' => 'images/products/20260519205621-685b0b61-three-front.jpg',
                'quantity' => 7, 'is_new' => false, 'is_hit' => false, 'status' => true,
                'publisher' => 'АСТ', 'publication_year' => 2023, 'pages' => 480,
                'language' => 'Русский', 'cover_type' => 'Мягкая', 'article' => 'BK-TC-13',
            ],
            [
                'id' => 18, 'category_id' => 2, 'name' => 'Властелин колец. Братство кольца', 'slug' => 'book-lord-rings-fellowship',
                'author' => 'Дж. Р. Р. Толкин', 'description' => 'Начало эпического путешествия по Средиземью.',
                'full_description' => 'Первая часть легендарной трилогии Толкина...',
                'price' => 1250.00, 'image' => 'images/products/20260519205706-9da14cd7-vlastelin-front.jpg',
                'quantity' => 6, 'is_new' => true, 'is_hit' => false, 'status' => true,
                'publisher' => 'АСТ', 'publication_year' => 2024, 'pages' => 576,
                'language' => 'Русский', 'cover_type' => 'Твердая', 'article' => 'BK-LOTR-01',
            ],
            [
                'id' => 20, 'category_id' => 7, 'name' => '451 градус по Фаренгейту', 'slug' => 'book-fahrenheit-451',
                'author' => 'Рэй Брэдбери', 'description' => 'Антиутопия о мире, где книги запрещены.',
                'full_description' => 'Роман Рэя Брэдбери рассказывает об обществе, отказавшемся от чтения...',
                'price' => 640.00, 'image' => 'images/products/20260519205823-d75112fc-451-front.jpg',
                'quantity' => 12, 'is_new' => false, 'is_hit' => true, 'status' => true,
                'publisher' => 'Эксмо', 'publication_year' => 2024, 'pages' => 256,
                'language' => 'Русский', 'cover_type' => 'Твердая', 'article' => 'BK-F451-08',
            ],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(['id' => $product['id']], $product);
        }
    }
}