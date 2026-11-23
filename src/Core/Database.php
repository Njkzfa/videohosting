<?php
namespace App\Core;

use PDO;
use PDOException;

class Database {
    private $host = "localhost";
    private $port = "5432";
    private $db_name = "videohosting_db";
    private $username = "postgres";
    private $password = "QFGUFWAZ1";
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            // DSN строка для PostgreSQL
            $dsn = "pgsql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name;
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            echo "Ошибка подключения: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>