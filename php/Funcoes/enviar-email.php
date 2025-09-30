<?php
// Usar o PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../PHPMailer/Exception.php';
require_once __DIR__ . '/../PHPMailer/PHPMailer.php';
require_once __DIR__ . '/../PHPMailer/SMTP.php';
require_once __DIR__ . '/../conexao.php';
require_once __DIR__ . '/../session-manager.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // CAPTURA E LIMPEZA DOS DADOS
    $nome = htmlspecialchars(trim($_POST['nome']));
    $email_remetente = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $assunto_form = htmlspecialchars(trim($_POST['assunto']));
    $conteudo_msg = htmlspecialchars(trim($_POST['mensagem']));

    if (empty($nome) || empty($email_remetente) || empty($assunto_form) || empty($conteudo_msg)) {
        header("Location: ../../html/email-sucesso.php?status=erro_campos");
        exit;
    }

    try {

        // Tenta encontrar o id_cliente com base no e-mail
        $idCliente = null;
        $stmt_user = $pdo->prepare("SELECT id_usuario FROM usuario WHERE email = ?");
        $stmt_user->execute([$email_remetente]);
        $usuario = $stmt_user->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            $idCliente = $usuario['id_usuario'];
        } else {
            // Se o e-mail não estiver cadastrado, pode decidir o que fazer.
            // Por agora, vamos permitir o envio, mas não associar a um cliente.
            // Numa versão futura, poderia guardar o e-mail diretamente na tabela de mensagens.
        }

        // Se encontrou um cliente, salva a mensagem associada a ele
        if ($idCliente) {
            $idAdministrador = 1; // Admin padrão
            $sql = "INSERT INTO mensagem (id_cliente, id_administrador, assunto, conteudo, data_envio) 
                    VALUES (?, ?, ?, ?, NOW())";
            $stmt_msg = $pdo->prepare($sql);
            $stmt_msg->execute([$idCliente, $idAdministrador, $assunto_form, $conteudo_msg]);
        }
        
        $mail = new PHPMailer(true);

        // Configurações do servidor SMTP (Gmail)
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'testecodejoh@gmail.com'; 
        $mail->Password = 'rwag tyhn ifnw ekep'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;
        $mail->CharSet = 'UTF-8';

        // Destinatários
        $mail->setFrom('testecodejoh@gmail.com', 'Notificação do Site');
        $mail->addAddress('testecodejoh@gmail.com', 'Administrador');
        $mail->addReplyTo($email_remetente, $nome);

        // Conteúdo do e-mail
        $mail->isHTML(false);
        $mail->Subject = "Nova Mensagem: " . $assunto_form;
        $mail->Body    = "Você recebeu uma nova mensagem do seu site:\n\n" .
                         "Nome: " . $nome . "\n" .
                         "E-mail: " . $email_remetente . "\n\n" .
                         "Mensagem:\n" . $conteudo_msg;

        $mail->send();
        
        // Sucesso: Redireciona para a página de contatos com status de sucesso
        header("Location: ../../html/email-sucesso.php?status=sucesso");
        exit;

    } catch (Exception $e) {
        // Se ocorrer qualquer erro (seja no banco de dados ou no envio do e-mail)
        // error_log("Erro no formulário de contato: " . $e->getMessage()); // Para depuração
        header("Location: ../../html/email-sucesso.php?status=erro_envio");
        exit;
    }
}
?>