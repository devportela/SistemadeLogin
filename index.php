<?php
session_start();
require 'conexao.php';

$mensagem = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];

    if (empty($email) || empty($senha)) {
        $mensagem = 'Preencha todos os campos.';
    } else {
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->rowCount() > 0) {
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

   
            if ($senha == $usuario['senha']) {
                // Login bem-sucedido
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['usuario_nome'] = $usuario['nome'];
                header("Location: dashboard.php");
                exit;
            } else {
                $mensagem = 'Senha incorreta.';
            }
        } else {
            $mensagem = 'Usuário não encontrado.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="assets/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <?php if (!empty($mensagem)): ?>
            <p class="mensagem"><?= htmlspecialchars($mensagem) ?></p>
        <?php endif; ?>
        <form method="POST" class="login-form">
            <input type="email" name="email" placeholder="E-mail" required>
            <div class="password-container">
                <input type="password" id="senha" name="senha" placeholder="Senha" required>
                <span id="eye-icon" class="eye-icon" onclick="togglePassword()">👁️</span>
            </div>
            <button type="submit" class="btn-submit">Entrar</button>
        </form>
        <p class="cadastro-link">Não tem uma conta? <a href="register.php">Cadastre-se</a></p>
    </div>

    <script>
        function togglePassword() {
            const passwordField = document.getElementById('senha');
            const eyeIcon = document.getElementById('eye-icon');
            
            if (passwordField.type === "password") {
                passwordField.type = "text";
                eyeIcon.textContent = "🙈"; // Alterar o ícone para "esconder"
            } else {
                passwordField.type = "password";
                eyeIcon.textContent = "👁️"; // Alterar o ícone para "mostrar"
            }
        }
    </script>
</body>
</html>
