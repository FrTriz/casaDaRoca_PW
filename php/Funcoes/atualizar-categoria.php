<?php
require_once __DIR__ . '/../conexao.php';
require_once '../Classes/CategoriaClass.php';
$c = new Categoria($pdo);

// Verifica se o formulário foi enviado (método POST)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Pega os dados do formulário de forma segura
    $id_categoria = isset($_POST['id_categoria']) ? (int)$_POST['id_categoria'] : 0;
    $nome_categoria = isset($_POST['nome_categoria']) ? trim($_POST['nome_categoria']) : '';

    // Valida os dados antes de atualizar
    if ($id_categoria > 0 && !empty($nome_categoria)) {
        // Chama o método para atualizar no banco
        $c->atualizar($id_categoria, $nome_categoria);
    }
}

// Redireciona o usuário de volta para a lista principal
header("Location: ../../html/admin-categorias.php");
exit();
?>