<?php
require_once '../php/session-manager.php';
require_once '../php/conexao.php';
require_once '../php/Classes/PedidoClass.php';

if (!isset($_SESSION['usuario_id']) || !isset($_GET['id'])) {
    header('Location: login.php');
    exit();
}

$id_pedido = (int)$_GET['id'];
$pedido_obj = new Pedido($pdo);

$pedido = $pedido_obj->buscarDetalhesPorId($id_pedido);
$itens_pedido = $pedido_obj->buscarItensPorPedidoId($id_pedido);

// Verifica se o pedido existe e pertence ao usuário logado
if (!$pedido || $pedido['id_cliente'] != $_SESSION['usuario_id']) {
    echo "Pedido não encontrado ou não pertence a este utilizador.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Meu Perfil - Casa da Roça</title>
    
    <link rel="stylesheet" href="../css/style-cliente.css?v=<?php echo time(); ?>">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&family=Open+Sans&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/5eb066ef2f.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php include 'cliente-header.php'; ?>
    <main>
        <section class="secao-conteudo">
            <h1>Detalhes do Pedido #<?php echo $pedido['id_pedido']; ?></h1>
            <p><strong>Data:</strong> <?php echo date('d/m/Y H:i', strtotime($pedido['data_pedido'])); ?></p>
            <p><strong>Status:</strong> <?php echo ucfirst($pedido['status']); ?></p>

            <h3 style="margin-top: 2rem;">Itens Comprados</h3>
            <div class="tabela-carrinho-container">
                <table class="tabela-carrinho">
                    <thead>
                        <tr><th>Produto</th><th>Quantidade</th><th>Preço Unitário</th><th>Subtotal</th></tr>
                    </thead>
                    <tbody>
                        <?php 
                        $total_pedido = 0;
                        foreach ($itens_pedido as $item): 
                            $subtotal_item = $item['quantidade'] * $item['preco_unitario'];
                            $total_pedido += $subtotal_item;
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['nome']); ?></td>
                            <td><?php echo $item['quantidade']; ?></td>
                            <td>R$ <?php echo number_format($item['preco_unitario'], 2, ',', '.'); ?></td>
                            <td>R$ <?php echo number_format($subtotal_item, 2, ',', '.'); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <h3 style="text-align: right; margin-top: 1rem;">Total do Pedido: R$ <?php echo number_format($total_pedido, 2, ',', '.'); ?></h3>
            <a href="perfil.php" style="display: block; margin-top: 2rem;">&larr; Voltar para Meus Pedidos</a>
        </section>
    </main>
    <?php include 'cliente-footer.php'; ?>
</body>
</html>