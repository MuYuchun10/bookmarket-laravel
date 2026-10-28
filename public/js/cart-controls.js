document.addEventListener('DOMContentLoaded', () => {
    const busy = new Set();
    let toastTimer;

    function showToast(message) {
        let toast = document.querySelector('.toast-message');

        if (!toast) {
            toast = document.createElement('div');
            toast.className = 'toast-message';
            toast.setAttribute('role', 'status');
            document.body.appendChild(toast);
        }

        toast.textContent = message;
        toast.classList.add('show');

        clearTimeout(toastTimer);
        toastTimer = setTimeout(() => {
            toast.classList.remove('show');
        }, 2400);
    }

    function renderProduct(id, quantity) {
        document.querySelectorAll('.js-cart-add').forEach(form => {
            if (form.dataset.id !== id) return;

            form.dataset.qty = quantity;
            form.hidden = quantity > 0;

            let counter = form.nextElementSibling;

            if (!counter?.classList.contains('add-to-cart-counter')) {
                counter = null;
            }

            if (quantity <= 0) {
                counter?.remove();
                return;
            }

            if (!counter) {
                counter = document.createElement('div');
                counter.className = 'add-to-cart-counter';

                counter.innerHTML = `
                    <button class="add-to-cart-counter__btn"
                            type="button" data-cart-change="-1">−</button>

                    <a class="add-to-cart-counter__value">
                        <span class="add-to-cart-counter__label">В корзине</span>
                        <span class="add-to-cart-counter__count"></span>
                    </a>

                    <button class="add-to-cart-counter__btn"
                            type="button" data-cart-change="1">+</button>
                `;

                form.insertAdjacentElement('afterend', counter);
            }

            counter.querySelector('a').href = form.dataset.cartUrl;
            counter.querySelector('.add-to-cart-counter__count')
                .textContent = quantity;

            counter.querySelector('[data-cart-change="1"]').disabled =
                quantity >= Number(form.dataset.stock);
        });
    }

    async function changeCart(form, change = null) {
        const id = form.dataset.id;

        if (busy.has(id)) return;
        busy.add(id);

        const url = change === null
            ? form.action
            : form.dataset.updateUrl;

        try {
            const response = await fetch(url, {
                method: change === null ? 'POST' : 'PATCH',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN':
                        form.querySelector('[name="_token"]').value
                },
                credentials: 'same-origin',
                body: JSON.stringify(
                    change === null ? {} : { change }
                )
            });

            const data = await response.json();

            if (data.quantity !== undefined) {
                renderProduct(id, Number(data.quantity));
            }

            if (data.cartCount !== undefined) {
                document.querySelectorAll('.cart-count').forEach(el => {
                    el.textContent = data.cartCount;
                });
            }

            showToast(data.message || 'Ошибка обновления корзины');
        } catch (error) {
            showToast('Не удалось связаться с сервером');
        } finally {
            busy.delete(id);
        }
    }

    // Восстанавливаем счётчики после открытия страницы
    document.querySelectorAll('.js-cart-add').forEach(form => {
        renderProduct(form.dataset.id, Number(form.dataset.qty));
    });

    // Добавление
    document.addEventListener('submit', event => {
        const form = event.target.closest('.js-cart-add');
        if (!form) return;

        event.preventDefault();
        changeCart(form);
    });

    // Кнопки + и −
    document.addEventListener('click', event => {
        const button = event.target.closest('[data-cart-change]');
        if (!button) return;

        const form = button.closest('.add-to-cart-counter')
            ?.previousElementSibling;

        if (!form?.classList.contains('js-cart-add')) return;

        changeCart(form, Number(button.dataset.cartChange));
    });
});
