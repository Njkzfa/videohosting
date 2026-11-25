<?php
namespace App\Controllers;

use App\Models\User;

class AuthController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $password = $_POST['password'];

            if (empty($username) || empty($email) || empty($password)) {
                $error = "Все поля обязательны!";
                require __DIR__ . '/../../views/register.php';
                return;
            }

            if ($this->userModel->create($username, $email, $password)) {
                $_SESSION['user'] = $username;
                header('Location: /');
                exit;
            } else {
                $error = "Ошибка: Пользователь с таким логином или email уже существует.";
                require __DIR__ . '/../../views/register.php';
            }
        } else {
            require __DIR__ . '/../../views/register.php';
        }
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $password = $_POST['password'];

            $user = $this->userModel->findByUsername($username);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user'] = $user['username'];
                $_SESSION['user_id'] = $user['id']; // Пригодится завтра для загрузки видео
                header('Location: /');
                exit;
            } else {
                $error = "Неверный логин или пароль.";
                require __DIR__ . '/../../views/login.php';
            }
        } else {
            require __DIR__ . '/../../views/login.php';
        }
    }

    public function logout() {
        session_destroy();
        header('Location: /');
        exit;
    }
}
?>