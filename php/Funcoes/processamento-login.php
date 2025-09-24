<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $email = trim($_POST['email']);
        $senha_digitada = trim($_POST['senha']);

        // Busca o usuário APENAS na tabela 'usuario' para verificar a senha e o tipo
        $sql = "SELECT id_usuario, senha, tipo FROM usuario WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verifica se o usuário existe e se a senha está correta
        if ($usuario && password_verify($senha_digitada, $usuario['senha'])) {
            
            // Login bem-sucedido
            $_SESSION['usuario_logado'] = true;
            $_SESSION['usuario_id'] = $usuario['id_usuario'];
            $_SESSION['usuario_tipo'] = $usuario['tipo'];

            // Verifica o TIPO de usuário para buscar o nome e redirecionar
            if ($usuario['tipo'] === 'cliente') {
                // Se for cliente, busca o nome na tabela 'cliente'
                $stmt = $pdo->prepare("SELECT nome FROM cliente WHERE id_cliente = :id");
                $stmt->execute(['id' => $usuario['id_usuario']]);
                $detalhes = $stmt->fetch(PDO::FETCH_ASSOC);
                $_SESSION['usuario_nome'] = $detalhes['nome'];
                
                header('Location: ../../html/index.php'); // Redireciona cliente
                exit;

            } elseif ($usuario['tipo'] === 'administrador') {
                // Se for admin, busca o nome na tabela 'administrador'
                $stmt = $pdo->prepare("SELECT nome FROM administrador WHERE id_administrador = :id");
                $stmt->execute(['id' => $usuario['id_usuario']]);
                $detalhes = $stmt->fetch(PDO::FETCH_ASSOC);
                $_SESSION['usuario_nome'] = $detalhes['nome'];

                // ATENÇÃO: Altere o caminho para a sua página de admin
                header('Location: ../../html/admin-dashboard.php'); // Redireciona admin
                exit;
            }

        } else {
            // Falha no login
            $_SESSION['erro_login'] = "E-mail ou senha incorretos.";
            header('Location: ../../html/login.php');
            exit;
        }

    } catch (PDOException $e) {
        $_SESSION['erro_login'] = "Erro no sistema. Tente novamente mais tarde.";
        // Para depuração: error_log("Erro de login: " . $e->getMessage());
        header('Location: ../../html/login.php');
        exit;
    }
} else {
    header('Location: ../../html/login.php');
    exit;
}