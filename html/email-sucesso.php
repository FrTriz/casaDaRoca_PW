<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmação de Contato - Casa da Roça</title>
    <link rel="stylesheet" href="/css/style-cliente.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&family=Open+Sans&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/5eb066ef2f.js" crossorigin="anonymous"></script>
</head>
<body>

    <?php
        // Inclui o header do seu site
        include 'cliente-header.php';
        // Captura o status da URL
        $status = isset($_GET['status']) ? $_GET['status'] : '';
    ?>

    <main>
        <section class="secao-conteudo">
            <div class="success-container">
                
                <?php if ($status == 'sucesso'): ?>
                    <div class="success-icon">
                        <i class="fas fa-check-circle" style="color: #28a745;"></i> </div>
                    <h1 class="success-title">Mensagem Enviada!</h1>
                    <p class="success-message">Obrigado por entrar em contato. Sua mensagem foi recebida e responderemos em breve.</p>
                    <div class="button-group">
                        <a href="index.php" class="botao">Página Inicial</a>
                        <a href="produtos.php" class="botao-secundario">Ver Produtos</a>
                    </div>

                <?php else: // Mensagem para ambos os tipos de erro ?>
                    <div class="success-icon">
                        <i class="fas fa-exclamation-triangle" style="color: #dc3545;"></i> </div>
                    <h1 class="success-title">Ocorreu um Problema</h1>
                    <?php if ($status == 'erro_envio'): ?>
                        <p class="success-message">Não foi possível enviar sua mensagem no momento. Por favor, tente novamente mais tarde ou entre em contato por outro canal.</p>
                    <?php else: // erro_campos ?>
                        <p class="success-message">Parece que alguns campos do formulário não foram preenchidos. Por favor, volte e complete o formulário.</p>
                    <?php endif; ?>
                    <div class="button-group">
                        <a href="contatos.php" class="botao">Tentar Novamente</a>
                    </div>
                <?php endif; ?>

            </div>
        </section>
    </main>

    <script src="/script.js"></script>

</body>
</html>