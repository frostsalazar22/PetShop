<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_tipo'] !== 'admin') {
    die("Acesso negado.");
}

require_once 'models/Animal.php';
$animal = new Animal();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_id'])) {
    $sql = "DELETE FROM animais WHERE id = ?";
    $stmt = $animal->conn->prepare($sql);
    $stmt->execute([$_POST['delete_id']]);
    echo "Animal removido.";
}

$animais = $animal->listar();
?>

<h1>Gerenciamento de Animais</h1>
<table border ="1">
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Raça</th>
        <th>Tipo</th>
        <th>Idade</th>
        <th>Ações</th>
    </tr>
    <?php foreach ($animais as $a): ?>
        <tr>
            <td><?= $a['id'] ?></td>
            <td><?= $a['nome'] ?></td>
            <td><?= $a['raca'] ?></td>
            <td><?= $a['tipo'] ?></td>
            <td><?= $a['idade'] ?> anos</td>
            <td>
                <form method="POST">
                    <input type="hidden" name="delete_id" value="<?= $a['id'] ?>">
                    <button type="submit">Deletar</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
