<?php
session_start();
include '../php/connection.php';

// Verifica se o usuário está logado
$usuarioLogado = isset($_SESSION['usuario_id']);

// Consultar todos os animais na tabela
$sql = "SELECT * FROM petadocao";
$query = $pdo->prepare($sql);
$query->execute();
$animais = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adoção de Animais</title>
    <link rel="stylesheet" href="../css/index.css">
    <script>
    function filtrarAnimais(tipo) {
        let cards = document.querySelectorAll('.animal-card');
        
        cards.forEach(card => {
            let especie = card.dataset.tipo.toLowerCase(); // Convertendo para minúsculas para evitar problemas com maiúsculas/minúsculas
            
            if (tipo === 'todos') {
                card.style.display = 'block';
            } 
            else if (tipo === 'Exótico') {
                // Se não for cachorro nem gato, é exótico
                if (especie !== 'cachorro' && especie !== 'gato') {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            } 
            else {
                // Filtra pelo tipo específico
                if (especie === tipo.toLowerCase()) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            }
        });
    }
</script>

</head>
<body>

<header>
        <div class="logo">
            <h1>PetShop</h1>
        </div>
        <nav>
            <ul>
                <li><a href="#" onclick="filtrarAnimais('todos')">Animais</a>
                    <ul>
                        <li><a href="#" onclick="filtrarAnimais('Cachorro')">Cães para adoção</a></li>
                        <li><a href="#" onclick="filtrarAnimais('Gato')">Gatos para adoção</a></li>
                        <li><a href="#" onclick="filtrarAnimais('Exótico')">Exóticos para adoção</a></li>
                    </ul>
                </li>
                <li><a href="#">Minha Conta</a>
                    <ul>
                        <li><a href="<?php echo $usuarioLogado ? 'profile.php' : 'login_register.php'; ?>">Entrar no site</a></li>
                        <li><a href="profile.php">Meus animais para adoção</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </header>

    <h1>Animais para Adoção</h1>
            <div class="animal-list">
                <?php foreach ($animais as $animal): ?>
                    <div class="animal-card" data-tipo="<?php echo htmlspecialchars($animal['especie']); ?>">

                    <img src="../img/<?php echo htmlspecialchars($animal['imagem']); ?>" 
                        alt="Imagem de <?php echo htmlspecialchars($animal['nome']); ?>" 
                        class="animal-img">

                        <h2><?php echo htmlspecialchars($animal['nome']); ?></h2>
                        <p>Sexo: <?php echo htmlspecialchars($animal['sexo']); ?></p>
                        <a href="pet_info.php?id=<?php echo $animal['id']; ?>" class="btn btn-ficha">Ver Ficha de Registro</a>
                    </div>
                <?php endforeach; ?>
            </div>


</body>
</html>
