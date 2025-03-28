<?php
include '../php/connection.php';

// Função para sanitizar entradas
function limparEntrada($dado) {
    return htmlspecialchars(trim($dado), ENT_QUOTES, 'UTF-8');
}

// Função para buscar cidades do IBGE
function obterCidadesIBGE() {
    $url = "https://servicodados.ibge.gov.br/api/v1/localidades/municipios";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    curl_close($ch);

    $dados = json_decode($response, true);
    return is_array($dados) ? array_map(fn($cidade) => $cidade["nome"], $dados) : [];
}

// Obtém a lista de cidades válidas
$cidadesValidas = obterCidadesIBGE();

// Lista de nomes proibidos (comidas)
$nomesProibidos = ["Arroz", "Feijão", "Pizza", "Bolo", "Macarrão", "Chocolate", "Pipoca", "Hamburguer", "Coxinha", "Batata", "Churrasco", "Melancia", "Miojo", "Brigadeiro", "Sorvete", "Panqueca"];

// Função para validar nomes reais com regex (inicial maiúscula)
function validarNomeRegex($nome) {
    return preg_match("/^[A-ZÁÉÍÓÚÂÊÎÔÛÄËÏÖÜÇ][a-záéíóúâêîôûäëïöüç]+(?: [A-ZÁÉÍÓÚÂÊÎÔÛÄËÏÖÜÇ][a-záéíóúâêîôûäëïöüç]+)*$/", trim($nome));
}

// Função para validar nome via API Genderize
function validarNomeAPI($nome) {
    $primeiroNome = explode(" ", $nome)[0];
    $url = "https://api.genderize.io/?name=" . urlencode($primeiroNome);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    curl_close($ch);

    $dados = json_decode($response, true);
    return isset($dados['gender']);
}

// Função para verificar se o nome está na lista de comidas proibidas
function nomeEhComida($nome, $nomesProibidos) {
    $primeiroNome = explode(" ", $nome)[0];
    return in_array($primeiroNome, $nomesProibidos);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitizar entradas
    $nome = limparEntrada($_POST['nome']);
    $email = limparEntrada($_POST['email']);
    $senha = $_POST['senha']; // Senhas não devem ser alteradas
    $telefone = limparEntrada($_POST['telefone']);
    $cidade = limparEntrada($_POST['cidade']);

    // Validações de segurança
    if (!validarNomeRegex($nome) || !validarNomeAPI($nome) || nomeEhComida($nome, $nomesProibidos)) {
        die("Nome inválido. Use um nome real com iniciais maiúsculas e que não seja um alimento.");
    }
    if (!preg_match("/^\d{8,15}$/", $telefone)) {
        die("Telefone inválido. Deve conter apenas números (8 a 15 dígitos).");
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("E-mail inválido.");
    }
    if (!in_array($cidade, $cidadesValidas)) {
        die("Cidade inválida. Escolha uma cidade válida.");
    }

    // Criar tokens para dados sensíveis
    $emailToken = hash("sha256", $email);
    $telefoneToken = hash("sha256", $telefone);
    $cidadeToken = hash("sha256", $cidade);
    $senhaHash = password_hash($senha, PASSWORD_BCRYPT);

    try {
        // Query segura com bindParam (previne SQL Injection)
        $stmt = $pdo->prepare("INSERT INTO Usuario (nome, email, senha, telefone, cidade) VALUES (:nome, :email, :senha, :telefone, :cidade)");
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':email', $emailToken, PDO::PARAM_STR);
        $stmt->bindParam(':senha', $senhaHash, PDO::PARAM_STR);
        $stmt->bindParam(':telefone', $telefoneToken, PDO::PARAM_STR);
        $stmt->bindParam(':cidade', $cidadeToken, PDO::PARAM_STR);

        $stmt->execute();
        echo "Cadastro realizado com sucesso!";
    } catch (PDOException $e) {
        echo "Erro ao cadastrar: " . htmlspecialchars($e->getMessage());
    }
}
?>
