<?php
include 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id    = $_POST['id'];
    $nome  = $_POST['nome'];
    $email = $_POST['email'];
    $tipo  = $_POST['tipo'];

    // Se o usuário enviou nova senha
    if (!empty($_POST['senha'])) {
        $senha = password_hash($_POST['senha'], PASSWORD_BCRYPT);
        $queryUsuario = "UPDATE usuario SET email=$1, senha=$2, tipo=$3 WHERE id_usuario=$4";
        pg_query_params($conn, $queryUsuario, array($email, $senha, $tipo, $id));
    } else {
        $queryUsuario = "UPDATE usuario SET email=$1, tipo=$2 WHERE id_usuario=$3";
        pg_query_params($conn, $queryUsuario, array($email, $tipo, $id));
    }

    // Atualizar cliente
    $queryCliente = "UPDATE cliente SET nome=$1 WHERE id_cliente=$2";
    pg_query_params($conn, $queryCliente, array($nome, $id));

    header("Location: /admin-list-usuarios.php?msg=atualizado");
    exit;
}
?>
