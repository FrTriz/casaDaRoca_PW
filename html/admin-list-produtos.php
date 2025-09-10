<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Produtos - Admin</title>
    <link rel="stylesheet" href="../css/style-admin.css">
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
            <h1 class="admin-title">Gerenciar Produtos</h1>
            <p class="admin-subtitle">Lista de todos os produtos cadastrados.</p>
            
            <div class="centered-button-container">
            <a href="admin-produtos.php" class="botao">+ Novo Produto</a>
            </div>

            <div class="tabela-admin-container">
                <table class="tabela-admin">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Imagem</th>
                            <th>Nome do Produto</th>
                            <th>Preço</th>
                            <th>Categoria</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td><img src="../img/produto1.png" alt="Produto 1" class="tabela-img"></td>
                            <td>Nome do Produto 1</td>
                            <td>R$ 15,90</td>
                            <td>Grãos e Sementes</td>
                            <td>
                                <a href="admin-edit-produto.html" class="btn-editar" title="Editar"><i class="fa-solid fa-pen"></i></a>
                                <a href="#" class="btn-excluir" title="Excluir"><i class="fa-solid fa-trash-can"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td><img src="../img/produto2.png" alt="Produto 2" class="tabela-img"></td>
                            <td>Nome do Produto 2</td>
                            <td>R$ 22,50</td>
                            <td>Temperos</td>
                            <td>
                                <a href="admin-edit-produto.html" class="btn-editar" title="Editar"><i class="fa-solid fa-pen"></i></a>
                                <a href="#" class="btn-excluir" title="Excluir"><i class="fa-solid fa-trash-can"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <?php
        include 'admin-footer.php';
    ?>
</body>
</html>