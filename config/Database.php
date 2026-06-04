<?php
/**
 * Database Connection Configuration
 * Lovné miery reviérov - Fishing Waters Database
 */

class Database {
    private $host = 'localhost';
    private $db_name = 'lovne_miery';
    private $user = 'root';
    private $password = '';
    private $charset = 'utf8mb4';
    private $conn;

    public function connect() {
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->db_name . ';charset=' . $this->charset;
        
        try {
            $this->conn = new PDO($dsn, $this->user, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conn;
        } catch (PDOException $e) {
            echo 'Chyba pripojenia: ' . $e->getMessage();
            return null;
        }
    }

    public function getConnection() {
        return $this->conn;
    }
}
?>
