<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '/usr/src/app/php/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $email = trim($_POST['email']);
        $senha_digitada = trim($_POST['senha']);

        $sql = "SELECT id_usuario, senha, tipo FROM usuario WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($senha_digitada, $usuario['senha'])) {
            
            $_SESSION['usuario_logado'] = true;
            $_SESSION['usuario_id'] = $usuario['id_usuario'];
            $_SESSION['usuario_tipo'] = $usuario['tipo'];

            if ($usuario['tipo'] === 'cliente') {
                $stmt = $pdo->prepare("SELECT nome FROM cliente WHERE id_cliente = :id");
                $stmt->execute(['id' => $usuario['id_usuario']]);
                $detalhes = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($detalhes) {
                    $_SESSION['usuario_nome'] = $detalhes['nome'];
                }

                header('Location: /index.php'); 
                exit;

            } elseif ($usuario['tipo'] === 'administrador') {
                $stmt = $pdo->prepare("SELECT nome FROM administrador WHERE id_administrador = :id");
                $stmt->execute(['id' => $usuario['id_usuario']]);
                $detalhes = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($detalhes) {
                    $_SESSION['usuario_nome'] = $detalhes['nome'];
                }
                header('Location: /admin-dashboard.php');
                exit;
            }

        } else {
            $_SESSION['erro_login'] = "E-mail ou senha incorretos.";
            header('Location: /login.php');
            exit;
        }

    } catch (PDOException $e) {
        $_SESSION['erro_login'] = "Erro no sistema. Tente novamente mais tarde.";
        error_log("Erro de login: " . $e->getMessage());

        header('Location: /login.php');
        exit;
    }
} else {

    header('Location: /login.php');
    exit;
}
?>