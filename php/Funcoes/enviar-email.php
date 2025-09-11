<?php
// Inicia o processamento do formulário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Seus dados de e-mail e captura dos campos
    $destinatario = "seu-email@seudominio.com.br"; // <-- Altere para o seu e-mail
    $nome = filter_var($_POST['nome'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $assunto_form = filter_var($_POST['assunto'], FILTER_SANITIZE_STRING);
    $mensagem = filter_var($_POST['mensagem'], FILTER_SANITIZE_STRING);

    // Validação
    if (empty($nome) || empty($email) || empty($assunto_form) || empty($mensagem)) {
        // Redireciona de volta com status de erro (campos vazios)
        header("Location: ../../html/email-sucesso.php?status=erro_campos");
        exit;
    }

    // Monta o e-mail
    $assunto_email = "Nova Mensagem do Site: " . $assunto_form;
    $corpo_email = "Nome: " . $nome . "\n";
    $corpo_email .= "E-mail: " . $email . "\n";
    $corpo_email .= "Mensagem:\n" . $mensagem . "\n";
    $headers = "From: " . $nome . " <" . $email . ">\r\n" . "Reply-To: " . $email . "\r\n" . "X-Mailer: PHP/" . phpversion();

    // Envia o e-mail
    if (mail($destinatario, $assunto_email, $corpo_email, $headers)) {
        // Redireciona para a página de confirmação com status de sucesso
        header("Location: ../../html/email-sucesso.php?status=sucesso");
    } else {
        // Redireciona com status de erro de envio
        header("Location: ../../html/email-sucesso.php?status=erro_envio");
    }

} else {
    // Se não for POST, nega o acesso.
    die("Acesso inválido.");
}
?>