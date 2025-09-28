<?php
// C:\xampp\htdocs\TrabalhoPDS\php\Funcoes\excluir-usuario.php

require_once '../conexao.php';

if (isset($_GET['id'])) {
    try {
        $id = $_GET['id'];

        // Excluir das tabelas relacionadas primeiro
        $pdo->beginTransaction();

        // Excluir de cliente
        $sql_cliente = "DELETE FROM cliente WHERE id_cliente = :id";
        $stmt_cliente = $pdo->prepare($sql_cliente);
        $stmt_cliente->bindParam(':id', $id);
        $stmt_cliente->execute();

        // Excluir de usuario
        $sql_usuario = "DELETE FROM usuario WHERE id_usuario = :id";
        $stmt_usuario = $pdo->prepare($sql_usuario);
        $stmt_usuario->bindParam(':id', $id);
        $stmt_usuario->execute();

        $pdo->commit();

        header('Location: /html/admin-list-usuarios.php?sucesso=excluido');
        exit();

    } catch (PDOException $e) {
        $pdo->rollBack();
        header('Location: /html/admin-list-usuarios.php?erro=exclusao');
        exit();
    }
}
?>