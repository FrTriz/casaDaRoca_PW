<?php
require_once '../php/conexao.php';
require_once '../php/Classes/ProdutoClass.php';
require_once '../php/Classes/CategoriaClass.php';
$p = new Produto($pdo);
$c = new Categoria($pdo);

?>
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
                <?php
                // Busca os produtos APENAS UMA VEZ, antes de começar a exibir
                $produtos = $p->buscarDados(4);

                // Verifica se a busca retornou algum produto
                if ($produtos && count($produtos) > 0) {
                    // Para CADA produto encontrado, cria um <article> completo
                    foreach ($produtos as $produto) {
                        // Prepara a imagem do produto atual para exibição
                        $imagemBase64 = '';
                        if (isset($produto['imagem']) && !empty($produto['imagem'])) {
                            $imagemConteudo = is_resource($produto['imagem']) ? stream_get_contents($produto['imagem']) : $produto['imagem'];
                            $imagemBase64 = base64_encode($imagemConteudo);
                        }
                ?>
                    <article class="produto">
                        <img src="data:image/jpeg;base64,<?php echo $imagemBase64; ?>" alt="<?php echo htmlspecialchars($produto['nome']); ?>">
                        <h3><?php echo htmlspecialchars($produto['nome']); ?></h3>
                        <p><?php echo htmlspecialchars($produto['descricao']); ?></p>
                        <span class="preco">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></span>
                            <a href="../php/Funcoes/add-carrinho.php?id=<?php echo $produto['id_produto']; ?>" 
                                class="botao adicionar-carrinho" 
                                data-id="<?php echo $produto['id_produto']; ?>" 
                                data-nome="<?php echo htmlspecialchars($produto['nome']); ?>">Adicionar ao Carrinho</a>
                    </article>
                <?php
                    } 
                } else {
                    // Mensagem para o caso de não haver produtos cadastrados
                    echo "<p>Nenhum produto disponível no momento.</p>";
                }
                ?>
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

    <div id="popup-confirmacao" class="popup-overlay">
        <div class="popup-content">
            <span class="popup-close">&times;</span>
            <h2>Item Adicionado ao Carrinho!</h2>
            <p id="popup-message"></p>
            <a href="carrinho.php" class="botao">Ver Carrinho</a>
        </div>
    </div>
    <?php
        include 'cliente-footer.php';
    ?>

       <script src="../script.js?v=<?php echo time(); ?>"></script> 

</body>
</html>