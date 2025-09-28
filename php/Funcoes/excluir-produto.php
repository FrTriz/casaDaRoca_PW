<?php
require_once '../conexao.php';
require_once '../Classes/ProdutoClass.php';

$p = new Produto($pdo);

$id_produto = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id_produto > 0) {
    $p->excluir($id_produto);
}
header("Location: /admin-list-produtos.php");
exit();
?>