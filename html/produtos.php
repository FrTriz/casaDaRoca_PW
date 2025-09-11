<?php
    require_once '../php/Classes/ProdutoClass.php';
    require_once '../php/conexao.php';
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
        <section class="secao-conteudo">
            <h1 style="text-align: center;">Nossos Produtos</h1>
            <p style="text-align: center; margin-bottom: 2rem;">Conheça nossa seleção de produtos naturais, artesanais e saudáveis.</p>

           <div class="galeria-produtos">
                <?php
                // 1. Busca os produtos APENAS UMA VEZ, antes de começar a exibir
                $produtos = $p->buscarDados();

                // 2. Verifica se a busca retornou algum produto
                if ($produtos && count($produtos) > 0) {
                    // 3. Para CADA produto encontrado, cria um <article> completo
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
                        <a href="#" class="botao-adicionar-carrinho">Adicionar ao Carrinho</a>
                    </article>
                <?php
                    } // Fim do loop foreach
                } else {
                    // Mensagem para o caso de não haver produtos cadastrados
                    echo "<p>Nenhum produto disponível no momento.</p>";
                }
                ?>
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