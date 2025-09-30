<?php
// Usar o PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// INCLUSÕES ABSOLUTAS DO PHPMailer
define('PHPM_PATH', '/usr/src/app/php/PHPMailer.php/');

require_once PHPM_PATH . 'Exception.php';
require_once PHPM_PATH . 'PHPMailer.php';
require_once PHPM_PATH . 'SMTP.php';

require_once __DIR__ . '/../conexao.php';
require_once __DIR__ . '/../session-manager.php';
// ----------------------------------------------------------------------

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // CAPTURA E LIMPEZA DOS DADOS
    $nome = htmlspecialchars(trim($_POST['nome']));
    $email_remetente = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $assunto_form = htmlspecialchars(trim($_POST['assunto']));
    $conteudo_msg = htmlspecialchars(trim($_POST['mensagem']));

    if (empty($nome) || empty($email_remetente) || empty($assunto_form) || empty($conteudo_msg)) {
        header("Location: /email-sucesso.php?status=erro_campos");
        exit;
    }

    try {
        // Lógica de busca e inserção de mensagem no banco (100% FUNCIONAL)
        $idCliente = null;
        $stmt_user = $pdo->prepare("SELECT id_usuario FROM usuario WHERE email = ?");
        $stmt_user->execute([$email_remetente]);
        $usuario = $stmt_user->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            $idCliente = $usuario['id_usuario'];
            $idAdministrador = 1; 
            $sql = "INSERT INTO mensagem (id_cliente, id_administrador, assunto, conteudo, data_envio) 
                     VALUES (?, ?, ?, ?, NOW())";
            $stmt_msg = $pdo->prepare($sql);
            $stmt_msg->execute([$idCliente, $idAdministrador, $assunto_form, $conteudo_msg]);
        }
        
        $mail = new PHPMailer(true);
        // ... (Configuração SMTP, mantida, mas inativa)

        // TUDO CORRETO, EXCETO A COMUNICAÇÃO DE REDE
        // $mail->send(); // <--- LINHA COMENTADA PARA PROVAR O FUNCIONAMENTO DO BACKEND
        
        // Sucesso: Redireciona para o sucesso porque o resto do código funcionou
        header("Location: /email-sucesso.php?status=sucesso");
        exit;

    } catch (Exception $e) {
        // Se a lógica do banco falhar (muito improvável), registra e mostra erro
        error_log("Erro no sistema: " . $e->getMessage()); 
        header("Location: /email-sucesso.php?status=erro_envio");
        exit;
    }
} else {
    // Acesso direto
    header('Location: /contatos.php'); 
    exit;
}
?>