<?php
require_once '/usr/src/app/php/Funcoes/verifica-admin.php';
require_once '/usr/src/app/php/Classes/ProdutoClass.php';
require_once '/usr/src/app/php/conexao.php';
require_once '/usr/src/app/php/Classes/CategoriaClass.php';
$c = new Categoria($pdo);
$p = new Produto($pdo);

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Produtos - Admin</title>
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
            <h1 class="admin-title">Gerenciar Produtos</h1>
            <p class="admin-subtitle">Lista de todos os produtos cadastrados.</p>
            
            <div class="centered-button-container">
            <a href="admin-produtos.php" class="botao">+ Novo Produto</a>
            </div>

            <div class="tabela-admin-container">
                <table class="tabela-admin">
                    <thead>
                        <tr>
                            <th>Imagem</th>
                            <th>Nome Do Produto</th>
                            <th>Categoria</th>
                            <th>Preço</th>
                            <th>Estoque</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            // Busca os dados dos produtos, incluindo o nome da categoria
                            $Produto = $p->buscarDados(); 

                            if ($Produto && count($Produto) > 0) {
                                // Para cada produto encontrado, cria uma linha na tabela
                                foreach ($Produto as $produto) {
                                    echo '<tr>';
                                    
                                    // Célula para a Imagem do Produto
                                    // Prepara a imagem para exibição (converte de bytea para Base64)
                                    $imagemBase64 = '';
                                    if (isset($produto['imagem']) && !empty($produto['imagem'])) {
                                        $imagemConteudo = is_resource($produto['imagem']) ? stream_get_contents($produto['imagem']) : $produto['imagem'];
                                        $imagemBase64 = base64_encode($imagemConteudo);
                                    }
                                    echo "<td><img src='data:image/jpeg;base64," . $imagemBase64 . "' alt='" . htmlspecialchars($produto['nome']) . "' style='width: 50px; height: 50px; object-fit: cover; border-radius: 5px;'></td>";

                                    // Célula para o Nome do Produto
                                    echo '<td>' . htmlspecialchars($produto['nome']) . '</td>';

                                    // Célula para a Categoria
                                    echo '<td>' . htmlspecialchars($produto['categoria']) . '</td>';

                                    // Célula para o Preço
                                    echo '<td>R$ ' . number_format($produto['preco'], 2, ',', '.') . '</td>';

                                    // Célula para o Estoque
                                    echo '<td>' . htmlspecialchars($produto['estoque']) . '</td>';

                                    // Célula para os botões de Ação
                                    echo '<td>';
                                    echo '<a href="admin-editar-produtos.php?id=' . $produto['id_produto'] . '" class="btn-editar" title="Editar"><i class="fa-solid fa-pen"></i></a>';
                                    echo ' <a href="../php/Funcoes/excluir-produto.php?id=' . $produto['id_produto'] . '" class="btn-excluir" title="Excluir" onclick="return confirm(\'Tem certeza que deseja excluir este produto?\');"><i class="fa-solid fa-trash-can"></i></a>';
                                    echo '</td>';
                                    
                                    echo '</tr>';
                                }
                            } else {
                                // Se não houver produtos, exibe uma mensagem ocupando todas as colunas
                                echo '<tr><td colspan="6">Ainda não há produtos cadastrados!</td></tr>';
                            }
                        ?>
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