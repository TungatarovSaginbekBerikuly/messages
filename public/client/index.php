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
    </script>
</body>

</html>