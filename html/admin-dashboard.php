<?php
require_once dirname(__DIR__) . '/php/Funcoes/verifica-admin.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Admin</title>
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
            <h1 class="admin-title">Bem-vindo(a), Administrador(a)!</h1>
            <p class="admin-subtitle">Painel de controle do seu site.</p>
            
            <div class="dashboard-cards">
                <div class="dashboard-card">
                    <h3>Produtos Cadastrados</h3>
                    <p class="card-number">12</p>
                    <a href="admin-list-produtos.html" class="card-link">Gerenciar produtos</a>
                </div>
                <div class="dashboard-card">
                    <h3>Usuários Registrados</h3>
                    <p class="card-number">5</p>
                    <a href="admin-list-usuarios.html" class="card-link">Gerenciar usuários</a>
                </div>
                <div class="dashboard-card">
                    <h3>Pedidos Recentes</h3>
                    <p class="card-number">3</p>
                    <a href="#" class="card-link">Ver pedidos</a>
                </div>
            </div>
        </section>
    </main>

    <?php
        include 'admin-footer.php';
    ?>
</body>
</html>