<?php
session_start();
include '../php/connection.php';

if (!isset($_SESSION['usuario_id'])) {
    die("Erro: usuário não está logado.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $petId = $_POST['pet_id'];
    $usuarioId = $_SESSION['usuario_id'];

    try {
        // Buscar o pet na tabela PetAdocao
        $stmt = $pdo->prepare("SELECT * FROM petadocao WHERE id = ?");
        $stmt->execute([$petId]);
        $pet = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($pet) {
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

            echo "Adoção realizada com sucesso!";
        } else {
            echo "Erro: Pet não encontrado.";
        }
    } catch (PDOException $e) {
        echo "Erro ao adotar: " . $e->getMessage();
    }
}
?>
