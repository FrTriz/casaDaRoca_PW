<?php
// Usar o PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// ----------------------------------------------------------------------
// ERRO 1 CORRIGIDO: Removida a inclusão manual. 
// Usamos o Autoloader do Composer para carregar o PHPMailer de forma correta e segura.
// O caminho é absoluto no Docker: /usr/src/app/vendor/autoload.php
require_once '/usr/src/app/vendor/autoload.php';

// Inclusões de Código Local (Mantidas)
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
        // CORREÇÃO: Redirecionamento para a URL ABSOLUTA
        header("Location: /email-sucesso.php?status=erro_campos");
        exit;
    }

    try {
        // ... (Lógica de busca e inserção de mensagem no banco)

        // Se encontrou um cliente, salva a mensagem associada a ele
        if ($idCliente) {
            $idAdministrador = 1; 
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
        // ATENÇÃO: Se isso falhar, o problema é nas configurações de App Password do Gmail
        $mail->Username = 'testecodejoh@gmail.com'; 
        $mail->Password = 'rwag tyhn ifnw ekep'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;
        $mail->CharSet = 'UTF-8';

        // Destinatários (mantido)
        $mail->setFrom('testecodejoh@gmail.com', 'Notificação do Site');
        $mail->addAddress('testecodejoh@gmail.com', 'Administrador');
        $mail->addReplyTo($email_remetente, $nome);

        // Conteúdo do e-mail (mantido)
        $mail->isHTML(false);
        $mail->Subject = "Nova Mensagem: " . $assunto_form;
        $mail->Body    = "Você recebeu uma nova mensagem do seu site:\n\n" .
                          "Nome: " . $nome . "\n" .
                          "E-mail: " . $email_remetente . "\n\n" .
                          "Mensagem:\n" . $conteudo_msg;

        $mail->send();
        
        // Sucesso: Redireciona para a página de sucesso
        // CORREÇÃO: Redirecionamento para a URL ABSOLUTA
        header("Location: /email-sucesso.php?status=sucesso");
        exit;

    } catch (Exception $e) {
        // Falha no envio ou no banco de dados
        // error_log("Erro no formulário de contato: " . $e->getMessage()); // Descomente para depuração
        // CORREÇÃO: Redirecionamento para a URL ABSOLUTA
        header("Location: /email-sucesso.php?status=erro_envio");
        exit;
    }
}
?>