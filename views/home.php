<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Видеохостинг</title>
    <style>
        body { font-family: sans-serif; margin: 40px; background: #f9f9f9; }
        .video-block { background: #fff; padding: 20px; margin-bottom: 40px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        video { max-width: 100%; width: 600px; background: #000; margin-bottom: 15px; }
        .comments-section { margin-top: 20px; border-top: 1px solid #eee; padding-top: 15px; }
        .comment { margin-bottom: 10px; padding: 10px; background: #f1f1f1; border-radius: 5px; }
        .comment-author { font-weight: bold; color: #333; }
        .comment-form textarea { width: 100%; max-width: 600px; padding: 10px; margin-bottom: 10px; box-sizing: border-box; }
        .comment-form button { padding: 8px 15px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; }
        .comment-form button:hover { background: #0056b3; }
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
            <h2><?= htmlspecialchars($video['title']) ?></h2>
            <p><?= htmlspecialchars($video['description']) ?></p>
            <p><small>Автор: <?= htmlspecialchars($video['username']) ?> | <?= $video['uploaded_at'] ?></small></p>
            
            <video controls>
                <source src="/stream?id=<?= $video['id'] ?>">
                Ваш браузер не поддерживает видео.
            </video>

            <div class="comments-section">
                <h4>Комментарии:</h4>
                <?php 
                $commentModel = new \App\Models\Comment();
                $comments = $commentModel->getByVideoId($video['id']);
                
                if (empty($comments)): ?>
                    <p><small>Пока нет комментариев. Будьте первым!</small></p>
                <?php else: ?>
                    <?php foreach ($comments as $comment): ?>
                        <div class="comment">
                            <span class="comment-author"><?= htmlspecialchars($comment['username']) ?>:</span>
                            <span><?= htmlspecialchars($comment['text']) ?></span>
                            <br><small style="color: #888;"><?= $comment['created_at'] ?></small>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

                <?php if(isset($_SESSION['user'])): ?>
                    <form class="comment-form" method="POST" action="/comment/add">
                        <input type="hidden" name="video_id" value="<?= $video['id'] ?>">
                        <textarea name="text" rows="2" placeholder="Напишите комментарий..." required></textarea>
                        <button type="submit">Отправить</button>
                    </form>
                <?php else: ?>
                    <p><small><a href="/login">Войдите</a>, чтобы оставить комментарий.</small></p>
                <?php endif; ?>
            </div>

        </div>
    <?php endforeach; ?>
</body>
</html>