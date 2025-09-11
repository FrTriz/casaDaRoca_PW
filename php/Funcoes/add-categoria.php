<?php
require_once '../conexao.php';
require_once '../Classes/CategoriaClass.php'; 
$c = new Categoria($pdo);

// Verifica se o formulário foi enviado (se existe um 'nome_categoria' no POST)
if (isset($_POST['nome_categoria'])) {

    // Pega o valor do formulário e remove espaços em branco extras
    $nome_categoria = trim($_POST['nome_categoria']); 

    // Garante que o nome não está vazio antes de tentar cadastrar
    if (!empty($nome_categoria)) {
        // Chama o método da sua classe para cadastrar
        $c->cadastrar($nome_categoria);
    }
}

// Após tentar salvar, redireciona o usuário de volta para a página da lista
// Isso evita que a categoria seja cadastrada novamente se o usuário atualizar a página
header("Location: ../../html/admin-categorias.php");
exit(); 
?>