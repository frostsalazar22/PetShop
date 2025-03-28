<?php
$host = "localhost"; // ou 127.0.0.1
$dbname = "pet_adoption";
$usuario = "root"; // ou o usuário configurado
$senha = ""; // normalmente vazio no XAMPP


try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $usuario, $senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}
?>
