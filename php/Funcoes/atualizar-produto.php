<?php
require_once '../conexao.php';
require_once '../Classes/ProdutoClass.php';

// Apenas executa se a requisição for do tipo POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Pega os dados do formulário com os nomes corretos
    $id_produto = isset($_POST['id_produto']) ? (int)$_POST['id_produto'] : 0;
    $nome = isset($_POST['nome']) ? trim($_POST['nome']) : '';
    $descricao = isset($_POST['descricao']) ? trim($_POST['descricao']) : '';
    $preco = isset($_POST['preco']) ? (float)$_POST['preco'] : 0.0;
    $estoque = isset($_POST['estoque']) ? (int)$_POST['estoque'] : 0;
    $id_categoria = isset($_POST['categoria']) ? (int)$_POST['categoria'] : 0; 

    // Lógica para tratar o upload da imagem
    $imagem = null; // Começa como nulo
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
        // Se uma nova imagem foi enviada sem erros, lê seu conteúdo
        $imagem = file_get_contents($_FILES['imagem']['tmp_name']);
    }

    // Validação dos dados
    if ($id_produto > 0 && !empty($nome) && !empty($descricao) && $preco > 0 && $id_categoria > 0) {
        $p = new Produto($pdo);
        // Chama a função de atualizar, passando os nomes corretos
        if ($p->atualizar($id_produto, $nome, $descricao, $preco, $estoque, $id_categoria, $imagem)) {
            // Se a atualização deu certo, redireciona com status de sucesso
            header("Location: ../../html/admin-list-produtos.php?status=sucesso");
            exit();
        }
    }
}

// Se algo falhar (dados inválidos ou não for POST), redireciona com status de erro
header("Location: ../../html/admin-list-produtos.php?status=erro");
exit();