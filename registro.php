<?php
include 'conexao.php'; // Inclui a conexão com o banco

// Verifica se o ID foi passado na URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Consulta os dados do animal baseado no ID
    $sql = "SELECT * FROM Animais WHERE id = :id";
    $query = $pdo->prepare($sql);
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->execute();
    $animal = $query->fetch(PDO::FETCH_ASSOC);
    
    if (!$animal) {
        echo "Animal não encontrado!";
        exit;
    }
} else {
    echo "ID do animal não fornecido!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ficha de Registro - <?php echo $animal['nome']; ?></title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <h1>Ficha de Registro</h1>
    <div class="registro">
        <img src="images/<?php echo $animal['imagem']; ?>" alt="Imagem de <?php echo $animal['nome']; ?>" class="registro-img">
        <ul>
            <li><strong>Espécie:</strong> <?php echo $animal['especie']; ?></li>
            <li><strong>Idade:</strong> <?php echo $animal['idade']; ?></li>
            <li><strong>Sexo:</strong> <?php echo $animal['sexo']; ?></li>
            <li><strong>Porte:</strong> <?php echo $animal['porte']; ?></li>
            <li><strong>Castrado:</strong> <?php echo $animal['castrado']; ?></li>
            <li><strong>Vacinado:</strong> <?php echo $animal['vacinado']; ?></li>
            <li><strong>Vermifugado:</strong> <?php echo $animal['vermifugado']; ?></li>
            <li><strong>Cidade:</strong> <?php echo $animal['cidade']; ?></li>
        </ul>
    </div>

</body>
</html>
