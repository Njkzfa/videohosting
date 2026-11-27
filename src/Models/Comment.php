<?php
namespace App\Models;

use App\Core\Database;
use PDO;

class Comment {
    private $conn;
    private $table_name = "comments";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function create($text, $userId, $videoId) {
        $query = "INSERT INTO " . $this->table_name . " (text, user_id, video_id) VALUES (:text, :user_id, :video_id)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':text', $text);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':video_id', $videoId);
        return $stmt->execute();
    }

    public function getByVideoId($videoId) {
        $query = "SELECT c.*, u.username FROM " . $this->table_name . " c 
                  JOIN users u ON c.user_id = u.id 
                  WHERE c.video_id = :video_id 
                  ORDER BY c.created_at ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':video_id', $videoId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>