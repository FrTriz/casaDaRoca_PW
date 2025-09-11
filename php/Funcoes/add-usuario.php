<?php

require_once '../conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
        $tipo = 'cliente';

        // Inserir na tabela usuario
        $sql_usuario = "INSERT INTO usuario (email, senha, tipo) VALUES (:email, :senha, :tipo) RETURNING id_usuario";
        $stmt_usuario = $pdo->prepare($sql_usuario);
        $stmt_usuario->bindParam(':email', $email);
        $stmt_usuario->bindParam(':senha', $senha);
        $stmt_usuario->bindParam(':tipo', $tipo);
        $stmt_usuario->execute();
        
        $id_usuario = $stmt_usuario->fetch(PDO::FETCH_ASSOC)['id_usuario'];

        // Inserir na tabela cliente
        $sql_cliente = "INSERT INTO cliente (id_cliente, nome) VALUES (:id_cliente, :nome)";
        $stmt_cliente = $pdo->prepare($sql_cliente);
        $stmt_cliente->bindParam(':id_cliente', $id_usuario);
        $stmt_cliente->bindParam(':nome', $nome);
        $stmt_cliente->execute();

        // Redirecionar para sucesso
        header('Location: ../../html/cadastro-sucesso.php');
        exit();

    } catch (PDOException $e) {
        if ($e->getCode() == '23505') {
            header('Location: ../html/cadastro.php?erro=email_duplicado');
        } else {
            header('Location: ../html/cadastro.php?erro=geral');
        }
        exit();
    }
}
?>