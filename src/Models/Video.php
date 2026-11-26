<?php
namespace App\Models;

use App\Core\Database;
use PDO;

class Video {
    private $conn;
    private $table_name = "videos";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function create($title, $description, $filePath, $userId) {
        $query = "INSERT INTO " . $this->table_name . " (title, description, file_path, user_id) VALUES (:title, :description, :file_path, :user_id)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':file_path', $filePath);
        $stmt->bindParam(':user_id', $userId);

        return $stmt->execute();
    }

    public function getAll() {
        $query = "SELECT v.*, u.username FROM " . $this->table_name . " v 
                  JOIN users u ON v.user_id = u.id 
                  ORDER BY v.uploaded_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>