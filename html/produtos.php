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
            <h1 style="text-align: center;">Nossos Produtos</h1>
            <p style="text-align: center; margin-bottom: 2rem;">Conheça nossa seleção de produtos naturais, artesanais e saudáveis.</p>

            <div class="galeria-produtos">
                <article class="produto">
                    <img src="../img/produto1.png" alt="Produto 1">
                    <h3>Nome do Produto 1</h3>
                    <p>Breve descrição do produto.</p>
                    <span class="preco">R$ 15,90</span>
                    <button class="botao-adicionar-carrinho" data-produto="Nome do Produto 1">Adicionar ao Carrinho</button>
                </article>

                <article class="produto">
                    <img src="../img/produto2.png" alt="Produto 2">
                    <h3>Nome do Produto 2</h3>
                    <p>Breve descrição do produto.</p>
                    <span class="preco">R$ 22,50</span>
                    <button class="botao-adicionar-carrinho" data-produto="Nome do Produto 2">Adicionar ao Carrinho</button>
                </article>

                <article class="produto">
                    <img src="../img/produto3.png" alt="Produto 3">
                    <h3>Nome do Produto 3</h3>
                    <p>Breve descrição do produto.</p>
                    <span class="preco">R$ 9,99</span>
                    <button class="botao-adicionar-carrinho" data-produto="Nome do Produto 3">Adicionar ao Carrinho</button>
                </article>

                <article class="produto">
                    <img src="../img/produto4.png" alt="Produto 4">
                    <h3>Nome do Produto 4</h3>
                    <p>Breve descrição do produto.</p>
                    <span class="preco">R$ 35,00</span>
                    <button class="botao-adicionar-carrinho" data-produto="Nome do Produto 4">Adicionar ao Carrinho</button>
                </article>
            </div>
        </section>
    </main>

    <div id="popup-confirmacao" class="popup-overlay">
        <div class="popup-content">
            <span class="popup-close">&times;</span>
            <h2>Item Adicionado ao Carrinho!</h2>
            <p id="popup-message"></p>
            <a href="#" class="botao">Ver Carrinho</a>
        </div>
    </div>

    <?php
        include 'cliente-footer.php';
    ?>

    <script src="../script.js"></script>
</body>
</html>