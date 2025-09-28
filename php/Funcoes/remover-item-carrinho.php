<?php
require_once '../conexao.php';
require_once '../Classes/CarrinhoClass.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Pega o ID do produto a ser removido da URL
$id_produto = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id_produto > 0) {
    $carrinho = new Carrinho($pdo);
    // Usa o método da sua classe para remover o produto
    $carrinho->removerProduto($id_produto);
}

// Redireciona de volta para a página do carrinho
header('Location: /html/carrinho.php');
exit();
?>
