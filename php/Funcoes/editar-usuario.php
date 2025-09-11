<?php

require_once '../conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $tipo = $_POST['tipo'];

        // Atualizar tabela usuario
        $sql_usuario = "UPDATE usuario SET email = :email, tipo = :tipo WHERE id_usuario = :id";
        $stmt_usuario = $pdo->prepare($sql_usuario);
        $stmt_usuario->bindParam(':email', $email);
        $stmt_usuario->bindParam(':tipo', $tipo);
        $stmt_usuario->bindParam(':id', $id);
        $stmt_usuario->execute();

        // Atualizar tabela cliente
        $sql_cliente = "UPDATE cliente SET nome = :nome WHERE id_cliente = :id";
        $stmt_cliente = $pdo->prepare($sql_cliente);
        $stmt_cliente->bindParam(':nome', $nome);
        $stmt_cliente->bindParam(':id', $id);
        $stmt_cliente->execute();

        header('Location: ../../html/admin-list-usuarios.php');
        exit();

    } catch (PDOException $e) {
        header('Location: ../../html/admin-list-usuarios.php?erro=edicao');
        exit();
    }
}
?>