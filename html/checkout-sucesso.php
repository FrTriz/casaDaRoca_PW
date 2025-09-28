<?php

require_once '../php/session-manager.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

// Pega o ID do pedido da URL de forma segura
$id_pedido = isset($_GET['pedido']) ? (int)$_GET['pedido'] : 0;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido Confirmado! - Casa da Roça</title>
    <link rel="stylesheet" href="../css/style-cliente.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&family=Open+Sans&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/5eb066ef2f.js" crossorigin="anonymous"></script>
</head>
<body>

    <?php include 'cliente-header.php'; ?>

    <main>
        <section class="secao-conteudo">
            <div class="success-container">
                <i class="fas fa-check-circle success-icon"></i>
                <h1 class="success-title">Pedido Realizado com Sucesso!</h1>
                
                <?php if ($id_pedido > 0): ?>
                    <p class="success-message">Obrigado pela sua compra. O número do seu pedido é <strong>#<?php echo $id_pedido; ?></strong>. Enviaremos uma confirmação para o seu e-mail em breve.</p>
                <?php else: ?>
                    <p class="success-message">Obrigado pela sua compra! A sua encomenda está a ser processada.</p>
                <?php endif; ?>

                <div class="button-group">
                    <a href="produtos.php" class="botao">Continuar a Comprar</a>
                    <a href="perfil.php" class="botao-secundario">Ver Meus Pedidos</a>
                </div>
            </div>
        </section>
    </main>
    <script src="../script.js"></script>
    <?php include 'cliente-footer.php'; ?>

</body>
</html>