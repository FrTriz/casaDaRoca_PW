<?php
require_once '/usr/src/app/php/Funcoes/verifica-admin.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Admin</title>
    <link rel="stylesheet" href="/css/style-admin.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&family=Open+Sans&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/5eb066ef2f.js" crossorigin="anonymous"></script>
</head>
<body>

    <?php
        // Inclui o cabeçalho do admin para ter a estrutura básica
        include 'admin-header.php';

        // Inclui o arquivo de conexão ao banco de dados
        require_once '../php/conexao.php'; // Ajuste o caminho conforme a sua estrutura de pastas

        // Consulta SQL para contar o número de produtos
        $query_produtos = "SELECT COUNT(*) FROM Produto";
        $stmt_produtos = $pdo->prepare($query_produtos);
        $stmt_produtos->execute();
        $total_produtos = $stmt_produtos->fetchColumn();

        // Consulta SQL para contar o número de usuários
        $query_usuarios = "SELECT COUNT(*) FROM Usuario";
        $stmt_usuarios = $pdo->prepare($query_usuarios);
        $stmt_usuarios->execute();
        $total_usuarios = $stmt_usuarios->fetchColumn();

        // Consulta SQL para contar o número de pedidos
        $query_pedidos = "SELECT COUNT(*) FROM Pedido";
        $stmt_pedidos = $pdo->prepare($query_pedidos);
        $stmt_pedidos->execute();
        $total_pedidos = $stmt_pedidos->fetchColumn();

    ?>

    <main>
        <section class="secao-conteudo">
            <h1 class="admin-title">Bem-vindo(a), Administrador(a)!</h1>
            <p class="admin-subtitle">Painel de controle do seu site.</p>
            
            <div class="dashboard-cards">
                <div class="dashboard-card">
                    <h3>Produtos Cadastrados</h3>
                    <p class="card-number"><?php echo $total_produtos; ?></p>
                    <a href="admin-list-produtos.php" class="card-link">Gerenciar produtos</a>
                </div>
                
                <div class="dashboard-card">
                    <h3>Usuários Registrados</h3>
                    <p class="card-number"><?php echo $total_usuarios; ?></p>
                    <a href="admin-list-usuarios.php" class="card-link">Gerenciar usuários</a>
                </div>
                
                <div class="dashboard-card">
                    <h3>Pedidos Recentes</h3>
                    <p class="card-number"><?php echo $total_pedidos; ?></p>
                    <a href="admin-pedidos.php" class="card-link">Ver pedidos</a>
                </div>
            </div>
        </section>
    </main>

    <?php
        include 'admin-footer.php';
    ?>
</body>
</html>