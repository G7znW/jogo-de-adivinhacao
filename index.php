<?php
session_start();
require_once 'db.php';

// Redireciona se não estiver logado
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

// Função para gerar número aleatório
function gerarNumeroSecreto() {
    return rand(1, 100);
}

// Cria o número se não existir
if (!isset($_SESSION['numero_secreto'])) {
    $_SESSION['numero_secreto'] = gerarNumeroSecreto();
}

$mensagem = "";
$classeMensagem = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['reiniciar'])) {
        $_SESSION['numero_secreto'] = gerarNumeroSecreto();
        $mensagem = "Novo número gerado! Boa sorte!";
        $classeMensagem = "wrong";
    } elseif (isset($_POST['palpite'])) {
        $palpite = intval($_POST['palpite']);
        $secreto = $_SESSION['numero_secreto'];

        if ($palpite < 1 || $palpite > 100) {
            $mensagem = "Insira um número entre 1 e 100!";
            $classeMensagem = "wrong";
        } elseif ($palpite == $secreto) {
            $mensagem = "🎉 Parabéns, {$_SESSION['usuario']}! Você acertou!";
            $classeMensagem = "correct";
        } elseif ($palpite < $secreto) {
            $mensagem = "Tente um número maior!";
            $classeMensagem = "wrong";
        } else {
            $mensagem = "Tente um número menor!";
            $classeMensagem = "wrong";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Jogo de Adivinhação</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="game-container">
    <h1>🎯 Jogo de Adivinhação</h1>

    <p>Olá, <strong><?= htmlspecialchars($_SESSION['usuario']) ?></strong>!</p>
    <p>Telefone cadastrado: <strong><?= htmlspecialchars($_SESSION['telefone']) ?></strong></p>
    <p>Estou pensando em um número entre <strong>1 e 100</strong>. Tente adivinhar!</p>

    <form method="POST" class="game-form">
      <input 
        type="number" 
        name="palpite" 
        placeholder="Digite seu palpite" 
        min="1" 
        max="100" 
        required>
      
      <button type="submit">Adivinhar</button>

      <!-- Botão REINICIAR corrigido -->
      <button class="restart-btn" type="submit" name="reiniciar" formnovalidate>
        Reiniciar Jogo
      </button>
    </form>

    <?php if (!empty($mensagem)): ?>
      <div class="message <?= $classeMensagem ?>">
        <?= htmlspecialchars($mensagem) ?>
      </div>
    <?php endif; ?>

    <p><a href="logout.php">Sair</a></p>
    <a href="https://github.com/G7znW/jogo-de-adivinhacao">nosso codigo no gitHub</a>
  </div>
</body>
</html>
