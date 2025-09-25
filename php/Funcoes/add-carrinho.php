<?php
require_once '../conexao.php';
require_once '../Classes/CarrinhoClass.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json'); // Resposta em JSON

$id_produto = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id_produto > 0) {
    $carrinho = new Carrinho($pdo);
    $resultado = $carrinho->adicionarProduto($id_produto);
    session_write_close();
    
    echo json_encode($resultado); // Devolve o resultado como JSON
    exit();
}

echo json_encode(['sucesso' => false, 'mensagem' => 'ID do produto inválido.']);
exit();
?>