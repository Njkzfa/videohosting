<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Загрузка видео</title>
</head>
<body style="font-family: sans-serif; margin: 40px;">
    <h2>Загрузить новое видео</h2>
    <form method="POST" action="/upload" enctype="multipart/form-data">
        <label>Название:</label><br>
        <input type="text" name="title" required><br><br>
        
        <label>Описание:</label><br>
        <textarea name="description"></textarea><br><br>
        
        <label>Видеофайл (mp4/webm):</label><br>
        <input type="file" name="video" accept="video/mp4, video/webm" required><br><br>
        
        <button type="submit">Загрузить</button>
    </form>
    <p><a href="/">Вернуться на главную</a></p>
</body>
</html>