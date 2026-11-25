<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход</title>
    <style>body { font-family: sans-serif; margin: 40px; }</style>
</head>
<body>
    <h2>Вход в систему</h2>
    
    <?php if (isset($error)): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST" action="/login">
        <label>Логин:</label><br>
        <input type="text" name="username" required><br><br>
        
        <label>Пароль:</label><br>
        <input type="password" name="password" required><br><br>
        
        <button type="submit">Войти</button>
    </form>
    <p>Нет аккаунта? <a href="/register">Зарегистрироваться</a></p>
</body>
</html>