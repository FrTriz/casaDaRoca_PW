<?php
// Usar o PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

define('PHPM_PATH', '/usr/src/app/php/PHPMailer/'); 

require_once PHPM_PATH . 'Exception.php';
require_once PHPM_PATH . 'PHPMailer.php';
require_once PHPM_PATH . 'SMTP.php';
require_once __DIR__ . '/../conexao.php';
require_once __DIR__ . '/../session-manager.php';


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
        // Lógica de banco de dados
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


        // CONFIGURAÇÃO SMTP MAILERSEND (TLS, PORTA 587)
        $mail->isSMTP();
        $mail->Host = 'smtp.mailersend.net'; 
        $mail->SMTPAuth = true;
        

        $mail->Username = 'MS_zxxjcH@test-68zxl27v6qk4j905.mlsender.net'; 
        $mail->Password = 'mssp.mGe1EW4.pq3enl69y0ml2vwr.nxDRKvK'; 
        
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
        $mail->Port = 587; 
        $mail->SMTPAutoTLS = true; 

        $mail->CharSet = 'UTF-8';

        $mail->setFrom('test-68zxl27v6qk4j905.mlsender.net', 'Notificação do Site');
        
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
        

        header("Location: /email-sucesso.php?status=sucesso");
        exit;

    } catch (Exception $e) {
        error_log("FALHA SMTP CRÍTICA: " . $e->getMessage()); 
        header("Location: /email-sucesso.php?status=erro_envio");
        exit;
    }
} else {
    // Acesso direto
    header('Location: /contatos.php'); 
    exit;
}
?>