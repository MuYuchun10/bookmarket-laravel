
<footer class="footer">
    <div class="container">
        <div class="footer__container">
            <div class="footer__column">
                <h3 class="footer__title">BookMarket</h3>
                <p class="footer__text">
                    Онлайн-магазин печатных книг для учёбы, отдыха и саморазвития.
                </p>
            </div>

            <div class="footer__column">
                <h3 class="footer__title">Разделы</h3>
                <ul class="footer__list">
                    <li class="footer__item">
                        <a class="footer__link" href="{{ route('home') }}">Главная</a>
                    </li>
                    <li class="footer__item">
                        <a class="footer__link" href="{{ route('catalog.index') }}">Каталог</a>
                    </li>
                    <li class="footer__item">
                        <span class="footer__link">Контакты</span>
                    </li>
                </ul>
            </div>

            <div class="footer__column">
                <h3 class="footer__title">Покупателю</h3>
                <ul class="footer__list">
                    <li class="footer__item">
                        <span class="footer__link">Личный кабинет</span>
                    </li>
                    <li class="footer__item">
                        <span class="footer__link">Корзина</span>
                    </li>
                    <li class="footer__item">
                        <span class="footer__link">Оформление заказа</span>
                    </li>
                </ul>
            </div>

            <div class="footer__column">
                <h3 class="footer__title">Контакты</h3>
                <address class="footer__address">
                    <a class="footer__link" href="tel:+79001234567">+7 (900) 123-45-67</a><br>
                    <a class="footer__link" href="mailto:bookmarket@mail.ru">bookmarket@mail.ru</a><br>
                    г. Орёл
                </address>
            </div>
        </div>
    </div>
</footer>