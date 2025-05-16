<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Чат поддержки (клиент)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container py-4">
    <h1>Поддержка</h1>
    <div id="chatBox" class="border rounded p-3 mb-3" style="height: 300px; overflow-y: auto;">
        <!-- Сообщения будут добавляться динамический -->
    </div>
    <form id="messageForm" class="input-group">
        <input id="messageInput" class="form-control" placeholder="Ваше сообщение..." required>
        <button class="btn btn-primary">Отправить</button>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/centrifuge@5/dist/centrifuge.min.js"></script>
    
    <script>
        const chatBox = document.getElementById('chatBox');
        const messageForm = document.getElementById('messageForm');
        const messageInput = document.getElementById('messageInput');

        // Отправка сообщений
        messageForm.addEventListener('submit', function (e) {
            e.preventDefault(); 
            const messageText = messageInput.value.trim();
            
            if (messageText === '') return;
            
            const messageDiv = document.createElement('div');
            messageDiv.classList.add('mb-2', 'p-2', 'bg-light', 'rounded');
            messageDiv.textContent = "Вы: " + messageText;
            chatBox.appendChild(messageDiv);
            chatBox.scrollTop = chatBox.scrollHeight;
            messageInput.value = '';
        });

        // Генерация токена
        fetch('../../token.php')
        .then(res => res.json())
        .then(data => {
            console.log('JWT токен:', data.token);
            console.log('visitor_id:', data.visitor_id);

            const centrifuge = new Centrifuge("ws://localhost:8000/connection/websocket", {
                token: data.token
            });

            centrifuge
            .on('connecting', ctx => console.log(`connecting: ${ctx.code}, ${ctx.reason}`))
            .on('connected', ctx => console.log(`connected over ${ctx.transport}`))
            .on('disconnected', ctx => console.log(`disconnected: ${ctx.code}, ${ctx.reason}`))
            .connect();

            const sub = centrifuge.newSubscription("channel");

            sub
            .on('publication', ctx => {
                // Получение сообщение
                const messageDiv = document.createElement('div');
                messageDiv.classList.add('mb-2', 'p-2', 'bg-dark', 'text-light', 'text-end', 'rounded');
                messageDiv.textContent = "Админ: " + ctx.data.message;
                chatBox.appendChild(messageDiv);
                chatBox.scrollTop = chatBox.scrollHeight;
            })
            .on('subscribing', ctx => console.log(`subscribing: ${ctx.code}, ${ctx.reason}`))
            .on('subscribed', ctx => console.log('subscribed', ctx))
            .on('unsubscribed', ctx => console.log(`unsubscribed: ${ctx.code}, ${ctx.reason}`))
            .subscribe();
        })
        .catch(err => {
            console.error('Ошибка при получении токена или подключении:', err);
        });
    </script>
</body>

</html>