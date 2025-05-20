<?php
session_start();
if (empty($_SESSION['is_admin'])) {
    header('Location: auth.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Все чаты</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="#">Admin</a>
    <div class="d-flex align-items-center">
      <a class="nav-link me-3" href="chats.php">Все чаты</a>
      <div class="dropdown">
        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
          Пользователь
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
          <li><a class="dropdown-item text-danger" href="logout.php">Выйти</a></li>
        </ul>
      </div>
    </div>
  </div>
</nav>

<div class="container mt-4">
  <h3 class="mb-4">Активные чаты</h3>
  <div id="chatsContainer" class="row g-3">
    <!-- сюда придут карточки -->
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
  fetch('get_active_chats.php')
    .then(res => res.json())
    .then(chats => {
      const container = document.getElementById('chatsContainer');
      container.innerHTML = '';
      if (!Array.isArray(chats) || chats.length === 0) {
        container.innerHTML = '<p>Нет активных чатов.</p>';
        return;
      }
      chats.forEach(chat => {
        const visitorId = chat.channel.replace('user_', '');
        const card = document.createElement('div');
        card.className = 'col-md-4';
        card.innerHTML = `
          <div class="card border-primary">
            <div class="card-body">
              <h5 class="card-title">Чат с ${visitorId}</h5>
              <p class="card-text">Клиентов онлайн: ${chat.clients}</p>
              <a href="chat.php?visitor_id=${visitorId}" class="btn btn-primary">Открыть чат</a>
            </div>
          </div>`;
        container.appendChild(card);
      });
    })
    .catch(err => {
      console.error('Ошибка получения списка чатов:', err);
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
