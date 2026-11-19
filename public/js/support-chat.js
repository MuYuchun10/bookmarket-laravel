
document.addEventListener('DOMContentLoaded', () => {
    const status = document.getElementById('chatStatus');
    const joinBlock = document.getElementById('chatJoin');
    const nameInput = document.getElementById('chatName');
    const joinButton = document.getElementById('joinButton');
    const messages = document.getElementById('chatMessages');
    const typingIndicator = document.getElementById('typingIndicator');
    const form = document.getElementById('chatForm');
    const messageInput = document.getElementById('messageInput');
    const sendButton = document.getElementById('sendButton');

    let socket = null;
    let userName = '';
    let typingTimeout = null;

    const typingUsers = new Map();

    // Добавление сообщения в окно чата
    function addMessage(sender, text, type, time = '') {
        const element = document.createElement('div');
        element.className = `chat-message ${type}`;

        if (type === 'system') {
            element.textContent = text;
        } else {
            const name = document.createElement('span');
            name.className = 'sender';
            name.textContent = sender;

            const content = document.createElement('div');
            content.textContent = text;

            const timestamp = document.createElement('span');
            timestamp.className = 'time';
            timestamp.textContent = time;

            element.append(name, content, timestamp);
        }

        messages.appendChild(element);
        messages.scrollTop = messages.scrollHeight;
    }

    // Отображение печатающих пользователей
    function renderTyping() {
        const names = [...typingUsers.keys()];

        if (names.length === 0) {
            typingIndicator.textContent = '';
        } else if (names.length === 1) {
            typingIndicator.textContent = `${names[0]} печатает...`;
        } else {
            typingIndicator.textContent =
                `${names.join(', ')} печатают...`;
        }
    }

    function handleTyping(name, isTyping) {
        if (!name || name === userName) return;

        if (typingUsers.has(name)) {
            clearTimeout(typingUsers.get(name));
            typingUsers.delete(name);
        }

        if (isTyping) {
            const timer = setTimeout(() => {
                typingUsers.delete(name);
                renderTyping();
            }, 2500);

            typingUsers.set(name, timer);
        }

        renderTyping();
    }

    function sendTyping(isTyping) {
        if (socket?.readyState === WebSocket.OPEN) {
            socket.send(JSON.stringify({
                type: 'typing',
                isTyping
            }));
        }
    }

    // Подключение к серверу
    joinButton.addEventListener('click', () => {
        userName = nameInput.value.trim();

        if (!userName) {
            alert('Введите ваше имя');
            return;
        }

        joinButton.disabled = true;
        status.textContent = 'Подключение...';

        const protocol = location.protocol === 'https:' ? 'wss' : 'ws';
        socket = new WebSocket(
            `${protocol}://${location.hostname}:8080`
        );

        socket.onopen = () => {
            socket.send(JSON.stringify({
                type: 'join',
                name: userName
            }));

            status.textContent = 'Подключён';
            status.className = 'chat-status online';

            joinBlock.style.display = 'none';
            messageInput.disabled = false;
            sendButton.disabled = false;
            messageInput.focus();
        };

        socket.onmessage = (event) => {
            let data;

            try {
                data = JSON.parse(event.data);
            } catch {
                return;
            }

            if (data.type === 'message') {
                addMessage(
                    data.sender,
                    data.message,
                    data.sender === userName ? 'self' : 'other',
                    data.timestamp
                );

                handleTyping(data.sender, false);
            }

            if (data.type === 'system') {
                addMessage(null, data.message, 'system');
            }

            if (data.type === 'typing') {
                handleTyping(data.name, data.isTyping);
            }
        };

        socket.onerror = () => {
            status.textContent = 'Ошибка соединения';
            status.className = 'chat-status offline';
        };

        socket.onclose = () => {
            status.textContent = 'Отключён';
            status.className = 'chat-status offline';

            messageInput.disabled = true;
            sendButton.disabled = true;
            joinButton.disabled = false;
            joinBlock.style.display = 'flex';

            clearTimeout(typingTimeout);
            typingIndicator.textContent = '';

            for (const timer of typingUsers.values()) {
                clearTimeout(timer);
            }
            typingUsers.clear();
        };
    });

    // Отправка сообщения
    form.addEventListener('submit', (event) => {
        event.preventDefault();

        const text = messageInput.value.trim();

        if (!text || socket?.readyState !== WebSocket.OPEN) {
            return;
        }

        socket.send(JSON.stringify({
            type: 'message',
            message: text
        }));

        messageInput.value = '';
        clearTimeout(typingTimeout);
        sendTyping(false);
    });

    // Индикатор набора текста
    messageInput.addEventListener('input', () => {
        clearTimeout(typingTimeout);

        if (messageInput.value.trim()) {
            sendTyping(true);

            typingTimeout = setTimeout(() => {
                sendTyping(false);
            }, 2000);
        } else {
            sendTyping(false);
        }
    });
});
