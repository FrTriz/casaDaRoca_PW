<?php
    require_once '/usr/src/app/php/Funcoes/verifica-admin.php';
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
    <title>Cadastrar Produto - Admin</title>
    <link rel="stylesheet" href="/css/style-admin.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&family=Open+Sans&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/5eb066ef2f.js" crossorigin="anonymous"></script>
    </head>
<body>

    <?php
        include 'admin-header.php';
    ?>

    <main>
        <section class="secao-conteudo">
            <h1 class="form-title" style="text-align: center;">Cadastrar Novo Produto</h1>
            <p style="text-align: center; margin-bottom: 2rem;">Preencha os dados do novo produto para adicioná-lo ao catálogo.</p>

            <form action="../php/Funcoes/add-produto.php" method="POST" enctype="multipart/form-data" class="admin-form">
                <div class="form-group">
                    <label for="nome_produto">Nome do Produto</label>
                    <input type="text" id="nome_produto" name="nome" required>
                </div>

                <div class="form-group">
                    <label for="descricao">Descrição</label>
                    <textarea id="descricao" name="descricao" rows="5" required></textarea>
                </div>
                
                <div class="form-group">
                    <label for="preco">Preço</label>
                    <input type="number" id="preco" name="preco" step="0.01" required>
                </div>
                
                <div class="form-group">
                    <label for="categoria">Categoria</label>
                    <select id="categoria" name="categoria" required>
                       <?php
                      $categorias = $c->buscarDados();
                      if ($categorias && count($categorias) > 0) {
                          foreach ($categorias as $categoria) {
                              echo '<option value="' . htmlspecialchars($categoria['id_categoria']) . '">' . htmlspecialchars($categoria['nome']) . '</option>';
                          }
                      } else {
                          echo '<option value="">Nenhuma categoria disponível</option>';
                      }
                      ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="estoque">Estoque</label>
                    <input type="number" id="estoque" name="estoque" required>
                </div>
                <div class="form-group">
                    <label for="imagem">Imagem do Produto</label>
                    <input type="file" id="imagem" name="imagem" required>
                </div>

                <div class="form-actions">
                    <button type="submit" class="botao">Cadastrar Produto</button>
                    <a href="admin-list-produtos.php" class="botao-secundario">Ver Produtos Cadastrados</a>
                </div>
            </form>
        </section>
    </main>

    <?php
        include 'admin-footer.php';
    ?>
</body>
</html>