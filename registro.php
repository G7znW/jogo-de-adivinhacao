-<?php
session_start();
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = trim($_POST['usuario']);
    $telefone = trim($_POST['telefone']);
    $senha = trim($_POST['senha']);
    $confirmar = trim($_POST['confirmar']);

    if ($usuario === "" || $telefone === "" || $senha === "" || $confirmar === "") {
        $erro = "Preencha todos os campos!";
    } elseif ($senha !== $confirmar) {
        $erro = "As senhas não coincidem!";
    } else {
        // Verifica se o usuário já existe
        $stmt = $pdo->prepare("SELECT id FROM users WHERE usuario = ?");
        $stmt->execute([$usuario]);

        if ($stmt->rowCount() > 0) {
            $erro = "Usuário já existe!";
        } else {
            // Criptografa a senha
            $hash = password_hash($senha, PASSWORD_DEFAULT);

            // Insere no banco
            $stmt = $pdo->prepare("INSERT INTO users (usuario, senha, telefone) VALUES (?, ?, ?)");
            $stmt->execute([$usuario, $hash, $telefone]);

            $_SESSION['usuario'] = $usuario;
            header("Location: login.php");
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Cadastrar Usuário</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="auth-container">
    <h1>Cadastro</h1>
    <form method="POST" class="auth-form">
      <input type="text" name="usuario" placeholder="Usuário" required>
      <input type="tel" name="telefone" placeholder="Telefone (ex: 11999999999)" pattern="[0-9]{10,11}" required>
      <input type="password" name="senha" placeholder="Senha" required>
      <input type="password" name="confirmar" placeholder="Confirmar senha" required>
      <button type="submit">Cadastrar</button>
    </form>
    <p>Já tem uma conta? <a href="login.php">Fazer login</a></p>
    <?php if (!empty($erro)): ?>
      <div class="message wrong"><?= htmlspecialchars($erro) ?></div>
    <?php endif; ?>
  </div>
</body>
</html>
