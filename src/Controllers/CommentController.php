<?php
namespace App\Controllers;

use App\Models\Comment;

class CommentController {
    private $commentModel;

    public function __construct() {
        $this->commentModel = new Comment();
    }

    public function add() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['text']) && isset($_POST['video_id'])) {
            $text = trim($_POST['text']);
            $videoId = (int)$_POST['video_id'];

            if (!empty($text)) {
                $this->commentModel->create($text, $_SESSION['user_id'], $videoId);
            }
            
            header('Location: /');
            exit;
        }
    }
}
?>