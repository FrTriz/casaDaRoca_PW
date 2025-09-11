<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Realizado - Casa da Roça</title>
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
            <div class="success-container">
                <div class="success-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h1 class="success-title">Cadastro Realizado com Sucesso!</h1>
                <p class="success-message">Obrigado por se cadastrar na Casa da Roça. Seu cadastro foi realizado com sucesso e agora você pode aproveitar todos os nossos produtos e serviços.</p>
                
                <div class="button-group">
                    <a href="index.php" class="botao">Página Inicial</a>
                    <a href="login.php" class="botao-secundario">Fazer Login</a>
                </div>
            </div>
        </section>
    </main>

    <script src="../script.js"></script>

</body>
</html>