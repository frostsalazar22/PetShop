<?php
require_once '../config/Database.php';

class User {
    private $conn;
    private $table = "users";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function register($nome, $email, $senha) {
        $hashed_password = password_hash($senha, PASSWORD_DEFAULT);
        $sql = "INSERT INTO " . $this->table . " (nome, email, senha) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$nome, $email, $hashed_password]);
    }

    public function login($email, $senha) {
        $sql = "SELECT * FROM " . $this->table . " WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($senha, $user['senha'])) {
            return $user;
        }
        return false;
    }
}
?>
