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
        <section class="section-hero">
            <div class="container hero-content">
                <h1 class="hero-title">O gostinho da roça na sua casa</h1>
                <p class="hero-subtitle">Nossa missão é levar produtos saudáveis e artesanais para você. Conheça a nossa história.</p>
                <a href="sobre.html" class="botao">Conheça Nossa História</a>
            </div>
        </section>

        <section class="secao-conteudo">
            <h2 style="text-align: center;">Produtos Mais Vendidos</h2>
            <p style="text-align: center; margin-bottom: 2rem;">Confira os itens mais populares entre os nossos clientes.</p>
            
            <div class="galeria-produtos">
                <article class="produto">
                    <img src="../img/produto1.png" alt="Produto 1">
                    <h3>Nome do Produto 1</h3>
                    <p>Breve descrição do produto.</p>
                    <span class="preco">R$ 15,90</span>
                    <a href="#" class="botao-adicionar-carrinho">Adicionar ao Carrinho</a>
                </article>

                <article class="produto">
                    <img src="../img/produto2.png" alt="Produto 2">
                    <h3>Nome do Produto 2</h3>
                    <p>Breve descrição do produto.</p>
                    <span class="preco">R$ 22,50</span>
                    <a href="#" class="botao-adicionar-carrinho">Adicionar ao Carrinho</a>
                </article>
                
                <article class="produto">
                    <img src="../img/produto3.png" alt="Produto 3">
                    <h3>Nome do Produto 3</h3>
                    <p>Breve descrição do produto.</p>
                    <span class="preco">R$ 9,99</span>
                    <a href="#" class="botao-adicionar-carrinho">Adicionar ao Carrinho</a>
                </article>
            </div>
        </section>

        <section class="section-depoimento-bg">
            <div class="container depoimento-content">
                <h2>A Qualidade da Nossa Família Para a Sua</h2>
                <p>"Adoramos a Casa da Roça! Os produtos são fresquinhos e a entrega é super rápida. É como ter um pedacinho do campo em casa." - Ana F.</p>
            </div>
        </section>

        <section class="secao-conteudo section-motivacional">
            <div class="container">
                <h2 style="text-align: center;">Feito com Carinho, da Roça para Você</h2>
                <p style="text-align: center; max-width: 600px; margin: 0 auto 2rem;">A nossa missão é conectar a qualidade e o sabor dos produtos artesanais diretamente com a sua família, com o cuidado que você merece.</p>
            </div>
        </section>
    </main>

    <?php
        include 'cliente-footer.php';
    ?>

    <script src="../script.js"></script>

</body>
</html>