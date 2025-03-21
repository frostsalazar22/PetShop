<?php
require_once '../config/Database.php';

class Animal {
    private $conn;
    private $table = "animais";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function cadastrar($nome, $raca, $tipo, $genero, $idade, $dono_id) {
        $sql = "INSERT INTO " . $this->table . " (nome, raca, tipo, genero, idade, dono_id) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$nome, $raca, $tipo, $genero, $idade, $dono_id]);
    }

    public function listar() {
        $sql = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
