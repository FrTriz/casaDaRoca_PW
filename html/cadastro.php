<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Casa da Roça</title>
    <link rel="stylesheet" href="../css/style-cliente.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&family=Open+Sans&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/5eb066ef2f.js" crossorigin="anonymous"></script>
</head>
<body>

    <?php
        include 'cliente-header.php';
    ?>

    <main>
        <section class="secao-conteudo">
            <div class="form-container">
                <div id="cadastro-form" class="auth-form active" style="display: block;">
                    <h1 class="form-title">Cadastre-se</h1>
                   <!-- Altere o formulário para: -->
                        <form action="../php/Funcoes/add-usuario.php" method="POST">
                            <label for="cadastro-nome">Nome</label>
                            <input type="text" id="cadastro-nome" name="nome" required>

                            <label for="cadastro-email">E-mail</label>
                            <input type="email" id="cadastro-email" name="email" required>

                            <label for="cadastro-senha">Senha</label>
                            <input type="password" id="cadastro-senha" name="senha" required>

                            <button type="submit" class="botao">Cadastrar</button>
                        </form>
                    <p class="form-switch">Já tem conta? <a href="login.php">Faça login</a></p>
                </div>
            </div>
        </section>
    </main>

    <?php
        include 'cliente-footer.php';
    ?>

    <script src="../script.js"></script>
</body>
</html>