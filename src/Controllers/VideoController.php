<?php
namespace App\Controllers;

use App\Models\Video;

class VideoController {
    private $videoModel;

    public function __construct() {
        $this->videoModel = new Video();
    }

    public function uploadForm() {
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }
        require __DIR__ . '/../../views/upload.php';
    }

    public function upload() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['video'])) {
            $title = trim($_POST['title']);
            $description = trim($_POST['description']);
            $file = $_FILES['video'];

            $allowedTypes = ['video/mp4', 'video/webm', 'video/ogg'];
            if (!in_array($file['type'], $allowedTypes)) {
                die("Ошибка: Разрешены только видеофайлы (MP4, WebM, OGG).");
            }

            $fileName = time() . '_' . basename($file['name']);
            $uploadPath = __DIR__ . '/../../public/uploads/' . $fileName;

            if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
                $dbFilePath = '/uploads/' . $fileName;
                $this->videoModel->create($title, $description, $dbFilePath, $_SESSION['user_id']);
                
                header('Location: /');
                exit;
            } else {
                die("Ошибка при сохранении файла на сервере.");
            }
        }
    }

    public function stream() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $video = $this->videoModel->getById($id);

        if (!$video) {
            http_response_code(404);
            die("Видео не найдено");
        }

        $filePath = __DIR__ . '/../../public' . $video['file_path'];
        
        if (!file_exists($filePath)) {
            http_response_code(404);
            die("Файл не найден на диске");
        }

        $fileSize = filesize($filePath);
        $mimeType = mime_content_type($filePath);

        header("Content-Type: $mimeType");
        header("Accept-Ranges: bytes");

        if (isset($_SERVER['HTTP_RANGE'])) {
            $range = $_SERVER['HTTP_RANGE'];
            list(, $range) = explode('=', $range, 2);
            if (strpos($range, ',') !== false) {
                header('HTTP/1.1 416 Requested Range Not Satisfiable');
                header("Content-Range: bytes */$fileSize");
                exit;
            }
            
            if ($range == '-') {
                $c_start = $fileSize - substr($range, 1);
            } else {
                $range = explode('-', $range);
                $c_start = $range[0];
                $c_end = (isset($range[1]) && is_numeric($range[1])) ? $range[1] : $fileSize - 1;
            }
            $c_end = ($c_end > $fileSize - 1) ? $fileSize - 1 : $c_end;

            if ($c_start > $c_end || $c_start > $fileSize - 1 || $c_end >= $fileSize) {
                header('HTTP/1.1 416 Requested Range Not Satisfiable');
                header("Content-Range: bytes $c_start-$c_end/$fileSize");
                exit;
            }

            $start = $c_start;
            $end = $c_end;
            $length = $end - $start + 1;
            
            header('HTTP/1.1 206 Partial Content');
            header("Content-Range: bytes $start-$end/$fileSize");
            header("Content-Length: " . $length);
        } else {
            $start = 0;
            $end = $fileSize - 1;
            header("Content-Length: " . $fileSize);
        }

        $fp = fopen($filePath, 'rb');
        fseek($fp, $start);
        $bufferSize = 8192;

        while (!feof($fp) && ftell($fp) <= $end) {
            $readLength = min($bufferSize, $end - ftell($fp) + 1);
            echo fread($fp, $readLength);
            flush();
        }
        fclose($fp);
        exit;
    }
}
?>