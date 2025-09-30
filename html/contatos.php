<?php

require_once '../php/session-manager.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fale Conosco - Casa da Roça</title>
    <link rel="stylesheet" href="../css/style-cliente.css?v=<?php echo time(); ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&family=Open+Sans&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/5eb066ef2f.js" crossorigin="anonymous"></script>
</head>
<body>

    <?php include 'cliente-header.php'; ?>

    <main>
        <section class="secao-conteudo">
            <h1 style="text-align: center;">Fale Conosco</h1>
            <p style="text-align: center;">Estamos disponíveis para atendê-lo. Use o formulário ou entre em contato pelos canais abaixo:</p>

            <div class="info-contato-container">
                </div>

            <div class="form-contato-section">
                <h2>Envie sua Mensagem</h2>
                
                <form action="../php/Funcoes/enviar-email.php" method="POST" id="form-contato"> 
                    <div class="form-group">
                        <label for="contato-nome">Nome:</label>
                        <input type="text" id="contato-nome" name="nome" required>
                        <span class="error-message" id="error-contato-nome"></span>
                    </div>

                    <div class="form-group">
                        <label for="contato-email">E-mail:</label>
                        <input type="email" id="contato-email" name="email" required>
                        <span class="error-message" id="error-contato-email"></span>
                    </div>

                    <div class="form-group">
                        <label for="contato-assunto">Assunto:</label>
                        <input type="text" id="contato-assunto" name="assunto" required>
                        <span class="error-message" id="error-contato-assunto"></span>
                    </div>

                    <div class="form-group">
                        <label for="contato-mensagem">Mensagem:</label>
                        <textarea id="contato-mensagem" name="mensagem" rows="6" required></textarea>
                        <span class="error-message" id="error-contato-mensagem"></span>
                    </div>

                    <button type="submit" class="botao">Enviar Mensagem</button>
                </form>
            </div>
        </section>
    </main>

    <?php include 'cliente-footer.php'; ?>

    <script src="../script.js?v=<?php echo time(); ?>"></script>
</body>
</html>