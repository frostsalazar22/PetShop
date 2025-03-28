<?php
include('connection.php');
if ($conn) {
    echo "Conexão bem-sucedida!";
} else {
    echo "Erro de conexão.";
}
?>
