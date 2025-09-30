<?php
// Usar o PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// 1. INCLUSÕES ABSOLUTAS DO PHPMailer (Ajustado para o caminho do Docker)
define('PHPM_PATH', '/usr/src/app/php/PHPMailer.php/');

require_once PHPM_PATH . 'Exception.php';
require_once PHPM_PATH . 'PHPMailer.php';
require_once PHPM_PATH . 'SMTP.php';

// Inclusões de Código Local
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
        // Lógica de busca e inserção de mensagem no banco
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

        // ----------------------------------------------------------------------
        // CONFIGURAÇÃO SMTP PARA MAILERSEND (TLS, PORTA 587)
        // ----------------------------------------------------------------------
        $mail->isSMTP();
        $mail->Host = 'smtp.mailersend.net'; 
        $mail->SMTPAuth = true;
        
        // Use as credenciais EXATAS do painel MailerSend
        $mail->Username = 'MS_zxxjcH@test-68zxl27v6qk4j905.mlsender.net'; 
        $mail->Password = 'mssp.mGe1EW4.pq3enl69y0ml2vwr.nxDRKvK'; // Use sua Senha SMTP gerada

        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // TLS
        $mail->Port = 587; // Porta Padrão do MailerSend
        $mail->SMTPAutoTLS = true; 

        $mail->CharSet = 'UTF-8';

        // ----------------------------------------------------------------------
        // CORREÇÃO CRÍTICA: E-mail de REMETENTE (setFrom) deve usar o domínio verificado
        // ----------------------------------------------------------------------
        $mail->setFrom('contato@test-68zxl27v6qk4j905.mlsender.net', 'Notificação do Site');
        
        // Destinatários (mantido)
        $mail->addAddress('testecodejoh@gmail.com', 'Administrador');
        $mail->addReplyTo($email_remetente, $nome);

        // Conteúdo do e-mail (mantido)
        $mail->isHTML(false);
        $mail->Subject = "Nova Mensagem: " . $assunto_form;
        $mail->Body    = "Você recebeu uma nova mensagem do seu site:\n\n" .
                          "Nome: " . $nome . "\n" .
                          "E-mail: " . $email_remetente . "\n\n" .
                          "Mensagem:\n" . $conteudo_msg;

        $mail->send();
        
        // Sucesso
        header("Location: /email-sucesso.php?status=sucesso");
        exit;

    } catch (Exception $e) {
        // Falha no envio
        error_log("Erro de contato: " . $e->getMessage()); 
        header("Location: /email-sucesso.php?status=erro_envio");
        exit;
    }
} else {
    // Acesso direto
    header('Location: /contatos.php'); 
    exit;
}
?>