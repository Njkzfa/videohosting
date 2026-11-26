<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Видеохостинг</title>
    <style>
        body { font-family: sans-serif; margin: 40px; }
        .video-block { margin-bottom: 40px; border-bottom: 1px solid #ccc; padding-bottom: 20px; }
        video { max-width: 600px; width: 100%; background: #000; }
    </style>
</head>
<body>
    <h1>Все видео</h1>
    <p>Привет, <?= htmlspecialchars($_SESSION['user'] ?? 'Гость') ?>! 
       <?php if(isset($_SESSION['user'])): ?>
           <a href="/upload">Загрузить видео</a> | <a href="/logout">Выйти</a>
       <?php else: ?>
           <a href="/login">Войти</a> | <a href="/register">Регистрация</a>
       <?php endif; ?>
    </p>

    <?php foreach ($videos as $video): ?>
        <div class="video-block">
            <h3><?= htmlspecialchars($video['title']) ?></h3>
            <p><?= htmlspecialchars($video['description']) ?></p>
            <p><small>Автор: <?= htmlspecialchars($video['username']) ?> | <?= $video['uploaded_at'] ?></small></p>
            <video controls>
                <source src="/stream?id=<?= $video['id'] ?>">
                Ваш браузер не поддерживает видео.
            </video>
            
        </div>
    <?php endforeach; ?>
</body>
</html>