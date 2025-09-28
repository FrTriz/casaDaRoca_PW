<?php
// Inicia a sessão
session_start();

// Inclui a conexão com o banco de dados
require_once '../conexao.php';

// Verifica se a requisição é do tipo POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // CAPTURA E LIMPEZA DOS DADOS 
    $destinatario = "testecodejoh@gmail.com"; // E-mail que receberá a notificação
    $nome = htmlspecialchars($_POST['nome']);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $assunto_form = htmlspecialchars($_POST['assunto']);
    $conteudo_msg = htmlspecialchars($_POST['mensagem']);

    // Validação de campos
    if (empty($nome) || empty($email) || empty($assunto_form) || empty($conteudo_msg)) {
        header("Location: /email-sucesso.php?status=erro_campos");
        exit;
    }

    try {
        // Encontrar o id_cliente com base no e-mail
        $idCliente = null;
        $stmt = $pdo->prepare("SELECT id_usuario FROM public.usuario WHERE email = ?");
        $stmt->execute([$email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            $idCliente = $usuario['id_usuario'];
        } else {
            // Se o e-mail não está cadastrado, redireciona com um erro específico
            header("Location: /email-sucesso.php?status=erro_cliente");
            exit;
        }

        // Definir o administrador de destino
        $idAdministrador = 1; // Admin padrão

        // Inserir a mensagem no banco de dados
        $sql = "INSERT INTO public.mensagem (id_cliente, id_administrador, assunto, conteudo, data_envio) 
                VALUES (?, ?, ?, ?, NOW())";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$idCliente, $idAdministrador, $assunto_form, $conteudo_msg]);

    } catch (PDOException $e) {
        // Se houver um erro no banco, redireciona com status de erro
        header("Location: /email-sucesso.php?status=erro_db");
        exit;
    }

    // LÓGICA DE ENVIO DE E-MAIL (só executa se o DB funcionou)
    $assunto_email = "Nova Mensagem do Site: " . $assunto_form;
    $corpo_email = "Nome: " . $nome . "\n";
    $corpo_email .= "E-mail: " . $email . "\n";
    $corpo_email .= "Mensagem:\n" . $conteudo_msg . "\n";
    $headers = "From: " . $nome . " <" . $email . ">\r\n" . "Reply-To: " . $email . "\r\n" . "X-Mailer: PHP/" . phpversion();

    if (mail($destinatario, $assunto_email, $corpo_email, $headers)) {
        // Sucesso em ambos: DB e E-mail
        header("Location: /email-sucesso.php?status=sucesso");
    } else {
        // DB funcionou, mas o e-mail falhou
        header("Location: /email-sucesso.php?status=erro_envio");
    }
    exit;

} else {
    die("Acesso inválido.");
}
?>