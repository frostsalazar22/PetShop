<?php
$host = 'localhost';  // Servidor MySQL
$dbname = 'PetShop';  // Nome do banco de dados
$username = 'root';    // Usuário do MySQL
$password = '';        // Senha do MySQL

// Criar a conexão
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erro na conexão: " . $e->getMessage();
}
?>
