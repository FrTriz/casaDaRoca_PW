<?php 
 require_once '../php/session-manager.php'; 
 require_once '/usr/src/app/php/conexao.php'; 
 require_once '/usr/src/app/php/Classes/ProdutoClass.php'; 
 require_once '/usr/src/app/php/Classes/CategoriaClass.php';
 
 $p = new Produto($pdo); 
 $c = new Categoria($pdo); 

 ?> 
 <!DOCTYPE html> 
    <html lang="pt-br"> 
        <head> 
            <meta charset="UTF-8"> 
            <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
            <title>Nossos Produtos - Casa da Roça</title> 
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
                    <?php
                    // Bloco para exibir as mensagens de status
                    if (isset($_GET['status'])) {
                        $status = $_GET['status'];
                        $mensagem = isset($_GET['msg']) ? htmlspecialchars($_GET['msg']) : '';

                        if ($status === 'item-adicionado') {
                            echo '<div class="alerta sucesso">Produto adicionado ao carrinho com sucesso!</div>';
                        } elseif ($status === 'erro-stock') {
                            echo '<div class="alerta erro">Erro: ' . $mensagem . '</div>';
                        }
                    }
                    ?>
                        <h1 style="text-align: center;">Nossos Produtos</h1> 
                            <p style="text-align: center; margin-bottom: 2rem;">Conheça a nossa seleção de produtos naturais, artesanais e saudáveis.</p> 
                        <div class="galeria-produtos"> 
                    <?php 
                        $produtos = $p->buscarDados(); 
                        if ($produtos && count($produtos) > 0) { 
                        foreach ($produtos as $produto) { 
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
                                    <a href="carrinho.php" class="botao">Ver Carrinho</a> 
                                </div> 
                            </div> 

    <?php include 'cliente-footer.php'; ?> 

    <script src="/script.js?v=<?php echo time(); ?>"></script> 
    </body> 
</html>