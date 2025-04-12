<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Área do Usuário</title>
    <link rel="stylesheet" href="assets/dashboard.css">
</head>
<body>
    <div class="container">
        <h2>Bem-vindo(a), <?= htmlspecialchars($_SESSION['usuario_nome']) ?>!</h2>
        <p>Você está logado com sucesso.</p>

        <a href="edit.php"><button>Editar dados</button></a>
        <a href="logout.php"><button>Sair</button></a>
    </div>
</body>
</html>
