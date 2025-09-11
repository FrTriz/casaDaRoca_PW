<?php
require_once '../conexao.php';
require_once '../Classes/ProdutoClass.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    $id_produto = isset($_POST['id_produto']) ? (int)$_POST['id_produto'] : 0;
    $nome_produto = isset($_POST['nome_produto']) ? trim($_POST['nome_produto']) : '';
    $descricao = isset($_POST['descricao']) ? trim($_POST['descricao']) : '';
    $preco = isset($_POST['preco']) ? (float)$_POST['preco'] : 0.0;
    $estoque = isset($_POST['estoque']) ? (int)$_POST['estoque'] : 0;
    $id_categoria = isset($_POST['id_categoria']) ? (int)$_POST['id_categoria'] : 0;
    $imagem = isset($_POST['imagem']) ? trim($_POST['imagem']) : '';
    if ($id_produto > 0 && !empty($nome_produto) && !empty($descricao) && $preco > 0 && $id_categoria > 0) {
        $p = new Produto($pdo);
        $p->atualizar($id_produto, $nome_produto, $descricao, $preco, $estoque, $id_categoria, $imagem);
    }
}
header("Location: ../../html/admin-editar-produtos.php");
exit();