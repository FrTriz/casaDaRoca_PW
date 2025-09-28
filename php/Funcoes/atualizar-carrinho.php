<?php
require_once '../conexao.php';
require_once '../Classes/CarrinhoClass.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_produto = isset($_POST['id_produto']) ? (int)$_POST['id_produto'] : 0;
    $quantidade = isset($_POST['quantidade']) ? (int)$_POST['quantidade'] : 0;

    $url_redirecionamento = '/carrinho.php';

    if ($id_produto > 0) {
        $carrinho = new Carrinho($pdo);
        $resultado = $carrinho->atualizarQuantidade($id_produto, $quantidade);

        if ($resultado['sucesso']) {
            $url_redirecionamento .= '?status=update-sucesso';
        } else {
            // Envia a mensagem de erro pela URL
            $url_redirecionamento .= '?status=erro-stock&msg=' . urlencode($resultado['mensagem']);
        }
    }
    
    header('Location: ' . $url_redirecionamento);
    exit();
}

// Redireciona se o método não for POST
header('Location: /carrinho.php');
exit();
?>