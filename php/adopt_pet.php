<?php
session_start();
include '../php/connection.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../pages/login_register.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $petId = $_POST['pet_id'];
    $usuarioId = $_SESSION['usuario_id'];

    try {
        // Iniciar transação para garantir que ambas as operações ocorram corretamente
        $pdo->beginTransaction();

        // Buscar o pet na tabela PetAdocao
        $stmt = $pdo->prepare("SELECT * FROM petadocao WHERE id = ?");
        $stmt->execute([$petId]);
        $pet = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$pet) {
            throw new Exception("Erro: Pet não encontrado.");
        }

        // Inserir na tabela PetDono
        $stmtInsert = $pdo->prepare("
            INSERT INTO petdono (nome, especie, idade, sexo, porte, castrado, vacinado, vermifugado, cidade, imagem, dono_id) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmtInsert->execute([
            $pet['nome'], $pet['especie'], $pet['idade'], $pet['sexo'],
            $pet['porte'], $pet['castrado'], $pet['vacinado'], $pet['vermifugado'],
            $pet['cidade'], $pet['imagem'], $usuarioId
        ]);

        // Remover o pet da tabela PetAdocao
        $stmtDelete = $pdo->prepare("DELETE FROM petadocao WHERE id = ?");
        $stmtDelete->execute([$petId]);

        // Confirmar transação
        $pdo->commit();

        // Redirecionar para o perfil com mensagem de sucesso
        header("Location: ../pages/profile.php?sucesso=1");
        exit();
    } catch (Exception $e) {
        // Se algo der errado, desfazer transação
        $pdo->rollBack();
        header("Location: ../pages/profile.php?erro=" . urlencode($e->getMessage()));
        exit();
    }
}
?>
