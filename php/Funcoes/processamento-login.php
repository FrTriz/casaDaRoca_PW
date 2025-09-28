<?php
// 1. INCLUSÃO DE SESSÃO E CONEXÃO (Use o caminho absoluto no arquivo que chama este script!)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '/usr/src/app/php/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $email = trim($_POST['email']);
        $senha_digitada = trim($_POST['senha']);

        // Busca o usuário na tabela 'usuario'
        $sql = "SELECT id_usuario, senha, tipo FROM usuario WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        // 2. CORREÇÃO DE LÓGICA PRINCIPAL: Verifica se o usuário EXISTE antes de verificar a senha.
        if ($usuario && password_verify($senha_digitada, $usuario['senha'])) {
            
            // Login bem-sucedido
            $_SESSION['usuario_logado'] = true;
            $_SESSION['usuario_id'] = $usuario['id_usuario'];
            $_SESSION['usuario_tipo'] = $usuario['tipo'];

            // Verifica o TIPO de usuário para buscar o nome e redirecionar
            if ($usuario['tipo'] === 'cliente') {
                // Se for cliente, busca o nome
                $stmt = $pdo->prepare("SELECT nome FROM cliente WHERE id_cliente = :id");
                $stmt->execute(['id' => $usuario['id_usuario']]);
                $detalhes = $stmt->fetch(PDO::FETCH_ASSOC);

                // CORREÇÃO: Verificação de array para evitar Warning de headers (Linha 45)
                if ($detalhes) {
                    $_SESSION['usuario_nome'] = $detalhes['nome'];
                }
                
                // CORREÇÃO: Redirecionamento para a URL ABSOLUTA
                header('Location: /index.php'); 
                exit;

            } elseif ($usuario['tipo'] === 'administrador') {
                // Se for admin, busca o nome
                $stmt = $pdo->prepare("SELECT nome FROM administrador WHERE id_administrador = :id");
                $stmt->execute(['id' => $usuario['id_usuario']]);
                $detalhes = $stmt->fetch(PDO::FETCH_ASSOC);

                // CORREÇÃO: Verificação de array para evitar Warning de headers (Linha 45)
                if ($detalhes) {
                    $_SESSION['usuario_nome'] = $detalhes['nome'];
                }

                // CORREÇÃO: Redirecionamento para a URL ABSOLUTA
                header('Location: /admin-dashboard.php');
                exit;
            }

        } else {
            // Falha no login (Usuário não existe OU Senha incorreta)
            $_SESSION['erro_login'] = "E-mail ou senha incorretos.";
            // CORREÇÃO: Redirecionamento para a URL ABSOLUTA
            header('Location: /login.php');
            exit;
        }

    } catch (PDOException $e) {
        $_SESSION['erro_login'] = "Erro no sistema. Tente novamente mais tarde.";
        error_log("Erro de login: " . $e->getMessage());
        // CORREÇÃO: Redirecionamento para a URL ABSOLUTA
        header('Location: /login.php');
        exit;
    }
} else {
    // Acesso direto ao arquivo de processamento
    // CORREÇÃO: Redirecionamento para a URL ABSOLUTA
    header('Location: /login.php');
    exit;
}
?>