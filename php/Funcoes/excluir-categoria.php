<?php
require_once __DIR__ . '/../conexao.php';
require_once '../Classes/CategoriaClass.php';
$c = new Categoria($pdo);

// 2. Pega o ID da URL de forma segura
// Verifica se o ID foi enviado e o converte para um número inteiro. Se não for enviado, usa 0.
$id_categoria = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// 3. Verifica se o ID é válido antes de prosseguir
if ($id_categoria > 0) {
    // 4. Chama o método da classe para excluir a categoria
    $c->excluir($id_categoria);
}

// 5. Redireciona o usuário de volta para a página da lista, independentemente do que acontecer
header("Location: ../../html/admin-categorias.php");
exit();
?>