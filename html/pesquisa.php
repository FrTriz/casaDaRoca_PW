<?php
require_once '../php/session-manager.php';
require_once '/usr/src/app/php/conexao.php';
require_once '/usr/src/app/php/Classes/ProdutoClass.php';
require_once '/usr/src/app/php/Classes/CategoriaClass.php';

$p = new Produto($pdo);
$cat = new Categoria($pdo);

$termo = isset($_GET['q']) ? trim($_GET['q']) : '';
$filtro_categoria = isset($_GET['categoria']) ? (int)$_GET['categoria'] : null;

$produtos_encontrados = [];
if (!empty($termo)) {
    $produtos_encontrados = $p->buscarPorTermo($termo, $filtro_categoria);
}

// Busca todas as categorias para preencher o menu de filtro
$categorias = $cat->buscarDados();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido Confirmado! - Casa da Roça</title>
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
            <h1 style="text-align: center;">Resultados da Pesquisa</h1>

            <?php if (!empty($termo)): ?>
                <p style="text-align: center; margin-bottom: 1rem;">
                    A exibir resultados para: <strong>"<?php echo htmlspecialchars($termo); ?>"</strong>
                </p>

                <form action="pesquisa.php" method="GET" class="form-filtro">
                    <input type="hidden" name="q" value="<?php echo htmlspecialchars($termo); ?>">
                    <select name="categoria" onchange="this.form.submit()">
                        <option value="">Filtrar por todas as categorias</option>
                        <?php foreach ($categorias as $categoria): ?>
                            <option value="<?php echo $categoria['id_categoria']; ?>" <?php if ($filtro_categoria == $categoria['id_categoria']) echo 'selected'; ?>>
                                <?php echo htmlspecialchars($categoria['nome']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </form>

                <div class="galeria-produtos" style="margin-top: 2rem;">
                    <?php if (count($produtos_encontrados) > 0): ?>
                        <?php foreach ($produtos_encontrados as $produto):
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
                                <a href="../php/Funcoes/add-carrinho.php?id=<?php echo $produto['id_produto']; ?>" class="botao adicionar-carrinho" data-id="<?php echo $produto['id_produto']; ?>" data-nome="<?php echo htmlspecialchars($produto['nome']); ?>">Adicionar ao Carrinho</a>
                            </article>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p style="text-align: center;">Nenhum produto encontrado para a sua pesquisa.</p>
                    <?php endif; ?>
                </div>

            <?php else: ?>
                <p style="text-align: center;">Por favor, digite um termo para pesquisar.</p>
            <?php endif; ?>
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
    <script src="/script.js?v=<?php echo time(); ?>"></script>
</body>
</html>