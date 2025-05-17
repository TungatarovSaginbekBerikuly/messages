<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Чат поддержки (клиент)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container py-4">
    <h1>Поддержка</h1>

    <div id="chatBox" class="border rounded p-3 mb-3" style="height: 300px; overflow-y: auto;"></div>

    <form id="messageForm" class="input-group">
        <input id="messageInput" class="form-control" placeholder="Ваше сообщение..." required>
        <button class="btn btn-primary">Отправить</button>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/centrifuge@5/dist/centrifuge.min.js"></script>

    <script>
        const chatBox = document.getElementById('chatBox');
        const messageForm = document.getElementById('messageForm');
        const messageInput = document.getElementById('messageInput');
        let visitorId;

        function renderMessage(msg) {
            const messageDiv = document.createElement('div');
            messageDiv.classList.add('mb-2', 'p-2', 'rounded');

            if (!msg.fromAdmin) {
                messageDiv.classList.add('bg-dark', 'text-light', 'text-end');
                messageDiv.textContent = "Админ: " + msg.message;
            } else {
                messageDiv.classList.add('bg-light');
                messageDiv.textContent = "Вы: " + msg.message;
            }

            chatBox.appendChild(messageDiv);
            chatBox.scrollTop = chatBox.scrollHeight;
        }

        fetch('../../token.php')
            .then(res => res.json())
            .then(data => {
                const token = data.token;
                visitorId = data.visitor_id;
                const channel = 'user_' + visitorId;

                const centrifuge = new Centrifuge("ws://localhost:8000/connection/websocket", {
                    token: token
                });

                centrifuge
                    .on('connecting', ctx => console.log(`connecting: ${ctx.code}, ${ctx.reason}`))
                    .on('connected', ctx => console.log(`connected over ${ctx.transport}`))
                    .on('disconnected', ctx => console.log(`disconnected: ${ctx.code}, ${ctx.reason}`))
                    .connect();

                const sub = centrifuge.newSubscription(channel);

                sub.on('publication', ctx => {
                    renderMessage(ctx.data);
                });

                sub
                    .on('subscribed', ctx => {
                        console.log('Подписка успешно:', ctx);

                        // Загружаем историю только после подписки
                        fetch('../../history.php', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify({ visitor_id: visitorId })
                        })
                            .then(res => res.json())
                            .then(json => {
                                const history = json.result?.publications;
                                if (Array.isArray(history)) {
                                    history.forEach(item => {
                                        renderMessage(item.data);
                                    });
                                } else {
                                    console.warn('Неверный формат истории:', json);
                                }
                            })
                            .catch(err => console.error('Ошибка загрузки истории:', err));
                    })
                    .on('subscribing', ctx => console.log(`subscribing: ${ctx.code}, ${ctx.reason}`))
                    .on('unsubscribed', ctx => console.log(`unsubscribed: ${ctx.code}, ${ctx.reason}`))
                    .subscribe();

                messageForm.addEventListener('submit', function (e) {
                    e.preventDefault();
                    const messageText = messageInput.value.trim();
                    if (messageText === '') return;

                    fetch('../../publish.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({
                            visitor_id: visitorId,
                            message: messageText
                        })
                    })
                        .then(res => res.json())
                        .then(() => {
                            messageInput.value = '';
                        })
                        .catch(err => console.error('Ошибка отправки:', err));
                });
            })
            .catch(err => {
                console.error('Ошибка при получении токена:', err);
            });
    </script>
</body>

</html>
