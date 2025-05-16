<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Все чаты</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body class="bg-light">

    <!-- ВСТАВЬ HEADER СЮДА -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="#">Admin</a>
            <div class="d-flex align-items-center">
                <a class="nav-link me-3" href="chats.html">Все чаты</a>

                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        Пользователь
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item text-danger" href="#">Выйти</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h3 class="mb-4">Активные чаты</h3>

        <!-- Список чатов -->
        <div class="row g-3">
            <div class="col-md-4">
                <div class="card border-primary">
                    <div class="card-body">
                        <h5 class="card-title">Чат с Пользователем 1</h5>
                        <p class="card-text">Последнее сообщение: Привет!</p>
                        <a href="#" class="btn btn-primary">Открыть чат</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-primary">
                    <div class="card-body">
                        <h5 class="card-title">Чат с Пользователем 2</h5>
                        <p class="card-text">Последнее сообщение: Как дела?</p>
                        <a href="#" class="btn btn-primary">Открыть чат</a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card border-primary">
                    <div class="card-body">
                        <h5 class="card-title">Чат с Пользователем 3</h5>
                        <p class="card-text">Последнее сообщение: Как дела?</p>
                        <a href="#" class="btn btn-primary">Открыть чат</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-primary">
                    <div class="card-body">
                        <h5 class="card-title">Чат с Пользователем 4</h5>
                        <p class="card-text">Последнее сообщение: Как дела?</p>
                        <a href="#" class="btn btn-primary">Открыть чат</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-primary">
                    <div class="card-body">
                        <h5 class="card-title">Чат с Пользователем 5</h5>
                        <p class="card-text">Последнее сообщение: Как дела?</p>
                        <a href="#" class="btn btn-primary">Открыть чат</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-primary">
                    <div class="card-body">
                        <h5 class="card-title">Чат с Пользователем 6</h5>
                        <p class="card-text">Последнее сообщение: Как дела?</p>
                        <a href="#" class="btn btn-primary">Открыть чат</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>