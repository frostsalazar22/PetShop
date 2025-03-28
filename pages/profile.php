<?php
session_start();
include '../php/connection.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login_register.php");
    exit();
}

// Regenera o ID da sessão para maior segurança
session_regenerate_id(true);

$usuarioId = $_SESSION['usuario_id'];

// Buscar informações do usuário
$stmtUser = $pdo->prepare("SELECT nome, email, telefone, cidade FROM Usuario WHERE id = ?");
$stmtUser->bindParam(1, $usuarioId, PDO::PARAM_INT);
$stmtUser->execute();
$usuario = $stmtUser->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    die("Erro: Usuário não encontrado.");
}

// Buscar os pets adotados pelo usuário
$stmtPets = $pdo->prepare("SELECT * FROM PetDono WHERE dono_id = ?");
$stmtPets->bindParam(1, $usuarioId, PDO::PARAM_INT);
$stmtPets->execute();
$pets = $stmtPets->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="stylesheet" href="../css/perfil.css">
</head>
<body>

<header>
    <div class="logo">
        <h1>PetShop</h1>
    </div>
    <nav>
        <ul>
            <li><a href="index.php">Animais</a></li>
            <li><a href="#">Minha Conta</a>
                <ul>
                    <li><a href="profile.php">Meu Perfil</a></li>
                    <li><a href="../php/logout.php">Sair</a></li>
                </ul>
            </li>
        </ul>
    </nav>
</header>

<div class="container">
    <?php if (isset($_GET['sucesso'])): ?>
        <p style="color: green; text-align: center;">Adoção realizada com sucesso!</p>
    <?php endif; ?>

    <?php if (isset($_GET['erro'])): ?>
        <p style="color: red; text-align: center;"><?php echo htmlspecialchars($_GET['erro']); ?></p>
    <?php endif; ?>

    <h2>Perfil do Usuário</h2>

    <table class="user-table">
        <tr><td>Nome</td><td><?= htmlspecialchars($usuario['nome'] ?? 'Não informado'); ?></td></tr>
    </table>

    <h2>Meus Pets Adotados</h2>
    <div class="pets-container">
        <?php if (!empty($pets)): ?>
            <?php foreach ($pets as $pet): ?>
                <div class="card">
                    <img src="../img/<?= htmlspecialchars($pet['imagem'] ?? 'default.png'); ?>" alt="<?= htmlspecialchars($pet['nome'] ?? 'Pet'); ?>">
                    <h3><?= htmlspecialchars($pet['nome'] ?? 'Desconhecido'); ?></h3>
                    <p><strong>Gênero:</strong> <?= htmlspecialchars($pet['sexo'] ?? 'Não informado'); ?></p>
                    <p><strong>Espécie:</strong> <?= htmlspecialchars($pet['especie'] ?? 'Não informado'); ?></p>
                    <p><strong>Idade:</strong> <?= htmlspecialchars($pet['idade'] ?? '0'); ?> anos</p>
                    <p><strong>Vacinado:</strong> <?= isset($pet['vacinado']) && $pet['vacinado'] ? 'Sim' : 'Não'; ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Você ainda não adotou nenhum pet.</p>
        <?php endif; ?>
    </div>
</div>

</body>
</html>