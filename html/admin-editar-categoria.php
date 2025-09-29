<?php
require_once '/usr/src/app/php/Funcoes/verifica-admin.php';
require_once '/usr/src/app/php/conexao.php';
require_once '/usr/src/app/php/Classes/CategoriaClass.php';
require_once '/usr/src/app/php/Classes/ProdutoClass.php';
$c = new Categoria($pdo);
$p = new Produto($pdo);

// Pega o ID da URL de forma segura
$id_categoria = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Busca os dados da categoria específica no banco
$categoria = $c->buscarPorId($id_categoria);

// Se não encontrar a categoria, redireciona de volta para a lista
if (!$categoria) {
    header("Location: admin-categorias.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Categoria - Admin</title>
    <link rel="stylesheet" href="/css/style-admin.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    </head>
<body>
    <?php
        include 'admin-header.php';
    ?>

    <main>
        <section class="secao-conteudo">
            <h1 class="admin-title">Editar Categoria</h1>
            
            <div class="categoria-form-container" style="margin: auto; max-width: 500px;">
                <h2 style="color: var(--verde-principal);">Alterar dados</h2>
                <form action="/php/Funcoes/atualizar-categoria.php" method="POST" class="admin-form">
                    
                    <input type="hidden" name="id_categoria" value="<?php echo $categoria['id_categoria']; ?>">
                    
                    <div class="form-group">
                        <label for="nome_categoria">Nome da Categoria</label>
                        <input type="text" id="nome_categoria" name="nome_categoria" value="<?php echo htmlspecialchars($categoria['nome']); ?>" required>
                    </div>
                    <button type="submit" class="botao" style="margin-top: 1rem;">Atualizar Categoria</button>
                </form>
            </div>
        </section>
    </main>

    <?php
        include 'admin-footer.php';
    ?>
    <script src="/script.js"></script>
</body>
</html>