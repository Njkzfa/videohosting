<?php
namespace App\Controllers;

class HomeController {
    public function index() {
        echo "<p>Здесь скоро будет список видео.</p>";
        echo "<a href='/test'>Перейти на страницу теста</a>";
    }

    public function test() {
        echo "<h1>Тестовая страница</h1>";
        echo "<p>Роутер работает отлично!</p>";
        echo "<a href='/'>Вернуться на главную</a>";
    }
}
?>