<?php
// Garante que a sessão seja iniciada de forma centralizada e segura
require_once __DIR__ . '/../php/session-manager.php';

$num_itens_carrinho = isset($_SESSION['carrinho']) ? count($_SESSION['carrinho']) : 0;
?>
<header class="main-header">
    <div class="container main-header-content">
        <div class="user-actions">
            <a href="" class="action-icon" id="user-icon" title="Login/Perfil">
                <i class="fa-solid fa-user"></i>
            </a>
            <div id="user-modal" class="user-modal">
                <div class="modal-content">
                    <?php if (isset($_SESSION['usuario_id'])): ?>
                        <a href="perfil.php" class="modal-button">Perfil</a>
                        <a href="../php/Funcoes/logout-login.php" class="modal-button">Logout</a>
                    <?php else: ?>
                        <a href="login.php" class="modal-button">Login</a>
                        <a href="cadastro.php" class="modal-button">Cadastro</a>
                    <?php endif; ?>
                </div>
            </div>

            <a href="carrinho.php" class="action-icon cart-icon-container" title="Carrinho de Compras">
                <i class="fa-solid fa-cart-shopping"></i>
                <?php if ($num_itens_carrinho > 0): ?>
                    <span class="cart-badge"><?php echo $num_itens_carrinho; ?></span>
                <?php endif; ?>
            </a>
            
            <form action="pesquisa.php" method="GET" class="search-box">
                <input type="text" name="q" placeholder="Pesquisar..." required>
                <button type="submit">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </form>
        </div>
        <a href="index.php" class="logo" title="Ir para a página inicial">
            <img src="../img/logo.png" alt="Logo da Casa da Roça">
        </a>
        <nav class="menu-nav">
            <ul>
                <li><a href="produtos.php">Produtos</a></li>
                <li><a href="contatos.php">Contatos</a></li>
            </ul>
        </nav>
    </div>
</header>