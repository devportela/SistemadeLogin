<?php
session_start();
require 'conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit;
}

$id = $_SESSION['usuario_id'];
$mensagem = '';


$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
$stmt->execute([$id]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $novo_nome = trim($_POST['nome']);
    $nova_senha = $_POST['senha'];

    if (empty($novo_nome)) {
        $mensagem = "O nome não pode estar vazio.";
    } else {
  
        if (!empty($nova_senha)) {
    
            $stmt = $pdo->prepare("UPDATE usuarios SET nome = ?, senha = ? WHERE id = ?");
            $stmt->execute([$novo_nome, $nova_senha, $id]);
            $_SESSION['usuario_nome'] = $novo_nome;
            $mensagem = "Dados atualizados com sucesso!";
        } else {
         
            $stmt = $pdo->prepare("UPDATE usuarios SET nome = ? WHERE id = ?");
            $stmt->execute([$novo_nome, $id]);
            $_SESSION['usuario_nome'] = $novo_nome;
            $mensagem = "Dados atualizados com sucesso!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Dados</title>
    <link rel="stylesheet" href="assets/edit.css">
</head>
<body>
    <div class="container">
        <h2>Editar Dados</h2>
        <?php if (!empty($mensagem)): ?>
            <p class="mensagem"><?= htmlspecialchars($mensagem) ?></p>
        <?php endif; ?>
        <form method="POST">
            <input type="text" name="nome" value="<?= htmlspecialchars($usuario['nome']) ?>" required>
            <input type="password" name="senha" placeholder="Nova senha (opcional)">
            <button type="submit" class="btn-submit">Salvar</button>
        </form>
        <a href="dashboard.php"><button class="btn-voltar">Voltar</button></a>
    </div>
</body>
</html>

