<?php
require_once '../php/Classes/CategoriaClass.php';
$c = new Categoria("db_casaDaRoca", "localhost", "postgres", "bsi1234");

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Categorias - Admin</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&family=Open+Sans&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/5eb066ef2f.js" crossorigin="anonymous"></script>
</head>
<body>
    <header class="main-header admin-header">
        <div class="container main-header-content">
            <a href="admin-dashboard.html" class="logo" title="Ir para a Dashboard">
                <img src="../img/logo.png" alt="Logo da Casa da Roça">
            </a>
            <nav class="menu-nav">
                <ul>
                    <li><a href="admin-dashboard.html">Dashboard</a></li>
                    <li><a href="admin-list-produtos.html">Produtos</a></li>
                    <li><a href="admin-list-usuarios.html">Usuários</a></li>
                    <li><a href="admin-categorias.php">Categorias</a></li>
                </ul>
            </nav>
            <a href="#" class="action-icon" title="Sair"><i class="fa-solid fa-right-from-bracket"></i></a>
        </div>
    </header>

    <main>
        <section class="secao-conteudo">
            <h1 class="admin-title">Gerenciar Categorias</h1>
            <p class="admin-subtitle">Adicione, edite ou exclua categorias de produtos.</p>
            
            <div class="categoria-gerenciamento">
                <div class="categoria-form-container">
                    <h2 style="color: var(--verde-principal);">Nova Categoria</h2>
                   <form action="../php/Funcoes/add-categoria.php" method="POST" class="admin-form">
                        <div class="form-group">
                            <label for="nome_categoria">Nome da Categoria</label>
                            <input type="text" id="nome_categoria" name="nome_categoria" required>
                        </div>
                        <button type="submit" class="botao" style="margin-top: 1rem;">Salvar Categoria</button>
                    </form>
                </div>
                
                <div class="tabela-admin-container">
                    <h2 style="color: var(--verde-principal);">Categorias Existentes</h2>
                    <table class="tabela-admin">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome da Categoria</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                           <tbody>
                                <?php
                                    $categorias = $c->buscarDados(); // Busca os dados do banco

                                        if ($categorias && count($categorias) > 0) {
                                              // Para cada categoria encontrada, crie uma linha na tabela
                                              foreach ($categorias as $categoria) {
                                                 echo '<tr>';
                                                    // Adiciona a célula (td) para o ID
                                                    echo '<td>' . htmlspecialchars($categoria['id_categoria']) . '</td>';
                                                    // Adiciona a célula (td) para o Nome
                                                    echo '<td>' . htmlspecialchars($categoria['nome']) . '</td>';
                                                    // Adiciona a célula (td) para os botões de Ação
                                                    echo '<td>';
                                                    echo '<a href="editar-categoria.php?id=' . $categoria['id_categoria'] . '" class="btn-editar" title="Editar"><i class="fa-solid fa-pen"></i></a>';
                                                    // DEPOIS (O link agora tem o caminho e o ID corretos)
                                                    echo ' <a href="../php/Funcoes/excluir-categoria.php?id=' . $categoria['id_categoria'] . '" class="btn-excluir" title="Excluir" onclick="return confirm(\'Tem certeza que deseja excluir esta categoria?\');"><i class="fa-solid fa-trash-can"></i></a>';
                                                    echo '</td>';
                                                    echo '</tr>';
                                                }    
                                        } else {
                                        // Se não houver categorias, exibe uma mensagem ocupando todas as colunas
                                        echo '<tr><td colspan="3">Ainda não há categorias cadastradas!</td></tr>';
                                     }
                                ?>
                            </tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </main>

    <footer class="admin-footer">
        <div class="container">
            <p>&copy; 2025 Casa da Roça. Todos os direitos reservados.</p>
        </div>
    </footer>
</body>
</html>