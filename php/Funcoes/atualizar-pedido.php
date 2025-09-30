<?php
require_once '../conexao.php';
require_once '../Classes/PedidoClass.php';
// Adicione aqui a verificação se o utilizador é um administrador, por segurança

if (isset($_GET['id']) && isset($_GET['status'])) {
    $id_pedido = (int)$_GET['id'];
    $novo_status = $_GET['status'];

    $pedido_obj = new Pedido($pdo);
    $pedido_obj->atualizarStatus($id_pedido, $novo_status);
}

// Redireciona de volta para a lista de pedidos no painel de administração
header('Location: /admin-pedidos-recentes.php');
exit();
?>