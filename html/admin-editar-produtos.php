<?php
require_once '/usr/src/app/php/Funcoes/verifica-admin.php';
require_once '/usr/src/app/php/conexao.php';
require_once '/usr/src/app/php/Classes/ProdutoClass.php';
require_once '/usr/src/app/php/Classes/CategoriaClass.php';

// Verifica se o ID do produto foi passado na URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    // Se não houver ID, redireciona para a lista de produtos
    header('Location: admin-list-produtos.php?status=erro-id');
    exit();
}

$id_produto = $_GET['id'];

// Busca os dados do produto e das categorias
$produto_obj = new Produto($pdo);
$categoria_obj = new Categoria($pdo);

// Busca o produto específico pelo ID
$produto = $produto_obj->buscarPorId($id_produto);
// Busca todas as categorias para preencher o <select>
$categorias = $categoria_obj->buscarDados();

// Verifica se o produto foi encontrado
if (!$produto) {
    // Se o produto não existe, redireciona
    header('Location: admin-list-produtos.php?status=produto-nao-encontrado');
    exit();
}

// Prepara a imagem para exibição, se existir
$imagemBase64 = '';
if (isset($produto['imagem']) && !empty($produto['imagem'])) {
    $imagemConteudo = is_resource($produto['imagem']) ? stream_get_contents($produto['imagem']) : $produto['imagem'];
    $imagemBase64 = base64_encode($imagemConteudo);
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Produto - Admin</title>
    <link rel="stylesheet" href="/css/style-admin.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&family=Open+Sans&display=swap" rel="stylesheet">
</head>
<body>
    <?php include 'admin-header.php'; ?>

    <main>
        <section class="secao-conteudo">
            <h1 class="form-title" style="text-align: center;">Editar Produto</h1>
            <p style="text-align: center; margin-bottom: 2rem;">Altere os dados do produto abaixo.</p>

            <form action="/php/Funcoes/atualizar-produto.php" method="POST" enctype="multipart/form-data" class="admin-form">
                <input type="hidden" name="id_produto" value="<?php echo htmlspecialchars($produto['id_produto']); ?>">

                <div class="form-group">
                    <label for="nome_produto">Nome do Produto</label>
                    <input type="text" id="nome_produto" name="nome" required value="<?php echo htmlspecialchars($produto['nome']); ?>">
                </div>

                <div class="form-group">
                    <label for="descricao">Descrição</label>
                    <textarea id="descricao" name="descricao" rows="5" required><?php echo htmlspecialchars($produto['descricao']); ?></textarea>
                </div>
                
                <div class="form-group">
                    <label for="preco">Preço</label>
                    <input type="number" id="preco" name="preco" step="0.01" required value="<?php echo htmlspecialchars($produto['preco']); ?>">
                </div>

                <div class="form-group">
                    <label for="estoque">Estoque</label>
                    <input type="number" id="estoque" name="estoque" required value="<?php echo htmlspecialchars($produto['estoque']); ?>">
                </div>
                
                <div class="form-group">
                    <label for="categoria">Categoria</label>
                    <select id="categoria" name="categoria" required>
                        <option value="">Selecione uma categoria</option>
                        <?php foreach ($categorias as $cat): ?>
                            <option value="<?php echo $cat['id_categoria']; ?>" <?php echo ($cat['id_categoria'] == $produto['id_categoria']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($cat['nome']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Imagem Atual</label>
                    <?php if ($imagemBase64): ?>
                        <img src="data:image/jpeg;base64,<?php echo $imagemBase64; ?>" alt="Imagem atual" style="max-width: 100px; display: block; margin-bottom: 10px;">
                    <?php else: ?>
                        <p>Nenhuma imagem cadastrada.</p>
                    <?php endif; ?>
                    
                    <label for="imagem">Enviar Nova Imagem (opcional)</label>
                    <input type="file" id="imagem" name="imagem">
                    <small>Se nenhuma nova imagem for enviada, a atual será mantida.</small>
                </div>

                <div class="form-actions">
                    <button type="submit" class="botao">Salvar Alterações</button>
                    <a href="admin-list-produtos.php" class="botao-secundario">Cancelar</a>
                </div>
            </form>
        </section>
    </main>
    <?php
        include 'admin-footer.php';
    ?>
    <script src="/script.js"></script>
</body>
</html>