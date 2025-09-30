<?php

require_once '../php/session-manager.php';
require_once '../php/conexao.php';
require_once '../php/Classes/PedidoClass.php'; 
require_once '../php/Funcoes/verifica-admin.php'; 


$pedido_obj = new Pedido($pdo);

$pedidos = $pdo->query("SELECT p.id_pedido, c.nome AS nome_cliente, p.data_pedido, p.status FROM pedido p JOIN cliente c ON p.id_cliente = c.id_cliente ORDER BY p.data_pedido DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos - Admin</title>
    <link rel="stylesheet" href="/css/style-admin.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&family=Open+Sans&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/5eb066ef2f.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php include 'admin-header.php'; ?>
    <main>
        <section class="secao-conteudo">
            <h1 class="admin-title">Gerir Pedidos</h1>
            <p class="admin-subtitle">Altere o status dos pedidos abaixo.</p>
            
            <div class="tabela-admin-container">
                <table class="tabela-admin">
                    <thead>
                        <tr>
                            <th>ID do Pedido</th>
                            <th>Cliente</th>
                            <th>Data</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($pedidos): ?>
                            <?php foreach ($pedidos as $pedido): ?>
                                <tr>
                                    <td>#<?php echo $pedido['id_pedido']; ?></td>
                                    <td><?php echo htmlspecialchars($pedido['nome_cliente']); ?></td>
                                    <td><?php echo date('d/m/Y H:i', strtotime($pedido['data_pedido'])); ?></td>
                                    <td>
                                        <form action="../php/Funcoes/atualizar-pedido.php" method="GET">
                                            <input type="hidden" name="id" value="<?php echo $pedido['id_pedido']; ?>">
                                            <select name="status" onchange="this.form.submit()">
                                                <option value="pendente" <?php if($pedido['status'] == 'pendente') echo 'selected'; ?>>Pendente</option>
                                                <option value="entregue" <?php if($pedido['status'] == 'entregue') echo 'selected'; ?>>Entregue</option>
                                            </select>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="5">Nenhum pedido encontrado.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
    <?php include 'admin-footer.php'; ?>
</body>
</html>