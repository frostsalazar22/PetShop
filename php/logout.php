<?php
session_start();
session_destroy(); // Destroi todas as variáveis de sessão
header("Location: ../pages/index.php"); // Redireciona para a página inicial
exit();
?>
