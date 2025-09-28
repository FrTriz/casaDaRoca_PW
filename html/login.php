<?php
require_once '/usr/src/app/php/session-manager.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Casa da Roça</title>
    <link rel="stylesheet" href="/css/style-cliente.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&family=Open+Sans&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/5eb066ef2f.js" crossorigin="anonymous"></script>
</head>
<body>

    <?php include 'cliente-header.php'; ?>

    <main>
        <section class="secao-conteudo">
            <div class="form-container">
                <div id="login-form" class="auth-form active">
                    <h1 class="form-title">Entrar</h1>

                    <?php if (!empty($_SESSION['erro_login'])): ?>
                        <p style="color: red; text-align: center;">
                            <?= htmlspecialchars($_SESSION['erro_login']) ?>
                        </p>
                        <?php unset($_SESSION['erro_login']); ?>
                    <?php endif; ?>

                    <form action="/usr/src/app/php/Funcoes/processamento-login.php" method="POST">
                        <label for="login-email">E-mail</label>
                        <input type="email" id="login-email" name="email" required>

                        <label for="login-senha">Senha</label>
                        <input type="password" id="login-senha" name="senha" required>

                        <button type="submit" class="botao">Entrar</button>
                    </form>
                    <p class="form-switch">Ainda não tem conta? <a href="cadastro.php">Cadastre-se</a></p>
                </div>
            </div>
        </section>
    </main>

    <?php include 'cliente-footer.php'; ?>

    <script src="/script.js"></script>
</body>
</html>
