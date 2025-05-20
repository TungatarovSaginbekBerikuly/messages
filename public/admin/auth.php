<?php
session_start();

const ADMIN_PASSWORD = '0010303s';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['password']) && $_POST['password'] === ADMIN_PASSWORD) {
        $_SESSION['is_admin'] = true;
        header('Location: chats.php');
        exit;
    } else {
        $error = 'Неверный пароль';
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Admin Login</title>
</head>

<body>
    <h2>Вход в админку</h2>
    <?php if($error): ?>
    <p style="color:red;">
        <?=htmlspecialchars($error)?>
    </p>
    <?php endif; ?>
    <form method="post">
        <input type="password" name="password" placeholder="Пароль" required>
        <button type="submit">Войти</button>
    </form>
</body>

</html>