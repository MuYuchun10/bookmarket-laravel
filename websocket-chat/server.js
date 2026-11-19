
const WebSocket = require('ws');

const PORT = 8080;
const wss = new WebSocket.Server({ port: PORT });

console.log(`WebSocket-сервер запущен на ws://localhost:${PORT}`);

wss.on('connection', (ws) => {
    console.log('Клиент подключился');

    ws.on('message', (data) => {
        const message = data.toString();

        console.log('Получено:', message);
        ws.send(`Сервер получил: ${message}`);
    });

    ws.on('close', () => {
        console.log('Клиент отключился');
    });
});
