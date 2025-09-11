<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Casa da Roça - Produtos Naturais</title>
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
            <h1 style="text-align: center;">Fale Conosco</h1>
            <p style="text-align: center;">Estamos disponíveis para atendê-lo. Use o formulário ou entre em contato pelos canais abaixo:</p>

        <div class="info-contato-container">
            <div class="info-item">
                <i class="fa-solid fa-phone"></i>
                <div>
                    <h3>Telefone</h3>
                    <p>(75) 99982-3413</p>
                </div>
            </div>
            
            <div class="info-item">
                <i class="fa-solid fa-envelope"></i>
                <div>
                    <h3>E-mail</h3>
                    <p>contato@casadaroca.com.br</p>
                </div>
            </div>
            
            <div class="info-item">
                <i class="fa-solid fa-location-dot"></i>
                <div>
                    <h3>Endereço</h3>
                    <p>Rua Exemplo, 123<br>Feira de Santana - BA</p>
                </div>
            </div>
        </div>

                <div class="form-contato-section">
                    <h2>Envie sua Mensagem</h2>
                        <form action="../php/Funcoes/enviar-email.php" method="POST" class="contact-form">    
                        <label for="nome">Nome:</label>
                        <input type="text" id="nome" name="nome" required>

                        <label for="email">E-mail:</label>
                        <input type="email" id="email" name="email" required>

                        <label for="assunto">Assunto:</label>
                        <input type="text" id="assunto" name="assunto" required>

                        <label for="mensagem">Mensagem:</label>
                        <textarea id="mensagem" name="mensagem" required></textarea>

                        <button type="submit" class="botao">Enviar Mensagem</button>
                    </form>
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