
document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('quickViewModal');
    const closeButton = modal.querySelector('.modal__close');
    let lastButton = null;

    function closeModal() {
        modal.classList.remove('show');
        modal.setAttribute('aria-hidden', 'true');
        lastButton?.focus();
    }

    document.querySelectorAll('.open-modal').forEach(button => {
        button.addEventListener('click', () => {
            const card = button.closest('.product-card');
            lastButton = button;

            const getText = selector =>
                card.querySelector(selector)?.textContent.trim() ?? '';

            modal.querySelector('.quick-view__title').textContent =
                getText('.product-card__title');

            modal.querySelector('.quick-view__author').textContent =
                getText('.product-card__author');

            modal.querySelector('.quick-view__price').textContent =
                getText('.product-card__price');

            modal.querySelector('.quick-view__category').textContent =
                card.dataset.category;

            modal.querySelector('.quick-view__description').textContent =
                card.dataset.description || 'Описание отсутствует';

            const status = modal.querySelector('.quick-view__status');
            status.textContent = getText('.product-card__status');
            status.classList.toggle(
                'quick-view__status--out',
                status.textContent === 'Нет в наличии'
            );

            const cover = card.querySelector('.product-card__image img');
            const image = modal.querySelector('.quick-view__cover img');
            const placeholder = modal.querySelector('.quick-view__cover span');

            image.style.display = cover ? 'block' : 'none';
            placeholder.style.display = cover ? 'none' : 'block';

            if (cover) {
                image.src = cover.src;
                image.alt = cover.alt;
            }

            modal.querySelector('.quick-view__button').href =
                card.querySelector('.product-card__image').href;

            modal.classList.add('show');
            modal.setAttribute('aria-hidden', 'false');
            closeButton.focus();
        });
    });

    closeButton.addEventListener('click', closeModal);

    modal.addEventListener('click', event => {
        if (event.target === modal) closeModal();
    });

    document.addEventListener('keydown', event => {
        if (event.key === 'Escape' && modal.classList.contains('show')) {
            closeModal();
        }
    });
});
