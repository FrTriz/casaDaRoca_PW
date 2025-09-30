<?php
// Usar o PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Inclusões ABSOLUTAS (corrigidas)
define('PHPM_PATH', '/usr/src/app/php/PHPMailer.php/');

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

        // Lógica de busca e inserção de mensagem no banco (mantida)
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
        // CONFIGURAÇÃO SMTP CORRIGIDA PARA STARTTLS (PORTA 587)
        // ----------------------------------------------------------------------
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        
        // **ATENÇÃO: Substitua pelo seu Username e a NOVA SENHA DE APLICATIVO**
        $mail->Username = 'testecodejoh@gmail.com'; 
        $mail->Password = 'flmh xlpl tnyd rsnu'; // <--- O VALOR CRÍTICO
        
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Usa STARTTLS
        $mail->Port = 587; // Porta padrão para STARTTLS
        $mail->SMTPAutoTLS = true; // Garante que o TLS seja ativado

        $mail->CharSet = 'UTF-8';

        // Destinatários (mantido)
        $mail->setFrom('testecodejoh@gmail.com', 'Notificação do Site');
        $mail->addAddress('testecodejoh@gmail.com', 'Administrador');
        $mail->addReplyTo($email_remetente, $nome);

        // Conteúdo do e-mail (mantido)
        $mail->isHTML(false);
        $mail->Subject = "Nova Mensagem: " . $assunto_form;
        $mail->Body = "Você recebeu uma nova mensagem do seu site:\n\n" .
                    "Nome: " . $nome . "\n" .
                    "E-mail: " . $email_remetente . "\n\n" .
                    "Mensagem:\n" . $conteudo_msg;

        $mail->send();
        
        // Sucesso
        header("Location: /email-sucesso.php?status=sucesso");
        exit;

    } catch (Exception $e) {
        // Falha no envio (erro de senha ou rede)
        error_log("Erro no formulário de contato: " . $e->getMessage()); 
        header("Location: /email-sucesso.php?status=erro_envio");
        exit;
    }
} else {
    // Acesso direto
    header('Location: /contatos.php'); 
    exit;
}
?>