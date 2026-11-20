
const WebSocket = require('ws');
const { v4: uuidv4 } = require('uuid');

const PORT = 8080;
const wss = new WebSocket.Server({ port: PORT });

// Подключённые участники: WebSocket -> имя
const clients = new Map();

// Отправка одному клиенту
function sendToClient(ws, data) {
    if (ws.readyState === WebSocket.OPEN) {
        ws.send(JSON.stringify(data));
    }
}

// Рассылка всем участникам
function broadcast(data, exclude = null) {
    for (const ws of clients.keys()) {
        if (ws !== exclude) {
            sendToClient(ws, data);
        }
    }
}

// Системное сообщение
function systemMessage(message) {
    broadcast({
        type: 'system',
        message,
        timestamp: new Date().toLocaleTimeString(),
        id: uuidv4()
    });
}

wss.on('connection', (ws) => {
    const clientId = uuidv4();
    console.log('Новое подключение');

    ws.on('message', (data) => {
        let parsed;

        try {
            parsed = JSON.parse(data.toString());
        } catch {
            return;
        }
        
        if (parsed === null ||
            typeof parsed !== 'object' ||
            Array.isArray(parsed)) {
            return;
        }
        
        const { type } = parsed;

        // Вход пользователя
        if (type === 'join') {
            if (clients.has(ws)) return;

            const name = typeof parsed.name === 'string'
                ? parsed.name.trim().slice(0, 30)
                : '';

            if (!name) return;

            clients.set(ws, name);

            sendToClient(ws, {
                type: 'joined',
                clientId
            });

            systemMessage(`Пользователь ${name} вошёл в чат`);

            sendToClient(ws, {
                type: 'system',
                message: `Добро пожаловать, ${name}!`,
                timestamp: new Date().toLocaleTimeString()
            });
        }

        // Остальные действия доступны после входа
        if (!clients.has(ws)) return;

        const name = clients.get(ws);

        // Отправка сообщения
        if (type === 'message') {
            if (typeof parsed.message !== 'string') return;

            const message = parsed.message.trim();
            if (!message || message.length > 2000) return;

            broadcast({
                type: 'message',
                sender: name,
                senderId: clientId,
                message,
                timestamp: new Date().toLocaleTimeString(),
                id: uuidv4()
            });
        }

        // Индикатор набора текста
        if (type === 'typing') {
            broadcast({
                type: 'typing',
                clientId,
                name,
                isTyping: parsed.isTyping === true
            }, ws);
        }
    });

    // Выход пользователя
    ws.on('close', (code, reason) => {
        const name = clients.get(ws);

        if (name) {
            clients.delete(ws);
            systemMessage(`Пользователь ${name} покинул чат`);
        }

        console.log(`Клиент отключился. Код: ${code}, причина: ${reason.toString()}`);
    });
});

console.log(`WebSocket-сервер запущен на ws://localhost:${PORT}`);
