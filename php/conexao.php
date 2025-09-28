<?php

// 1. Lendo as Variáveis de Ambiente do Servidor (Render)
// Se a variável existir, use o valor dela. Caso contrário, use um valor de fallback (para testes locais, por exemplo).
$host = getenv('DB_HOST') ?: 'seu_host_local';
$dbname = getenv('DB_NAME') ?: 'seu_db_local';
$user = getenv('DB_USER') ?: 'seu_user_local';
$pass = getenv('DB_PASSWORD') ?: 'sua_senha_local';
$port = getenv('DB_PORT') ?: '5432';
$endpoint_id = getenv('DB_ENDPOINT_ID') ?: ''; // O Endpoint é crucial para o Neon

// 2. Montando a Senha (Workaround do Neon)
// Sua lógica de conexão com o Neon requer que o endpoint_id seja anexado à senha.
// Vamos manter essa lógica, mas usando as variáveis de ambiente.
$pass_com_endpoint = !empty($endpoint_id) ? "endpoint=$endpoint_id;" . $pass : $pass;
// 3. Montando a String DSN (Data Source Name)
// sslmode=require é essencial para a conexão com o Neon.
$dsn = "pgsql:host=$host;port=$port;dbname=$dbname;sslmode=require";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false, 
];

try {
    // Usamos $pass_com_endpoint para a conexão
    $pdo = new PDO($dsn, $user, $pass_com_endpoint, $options);
} catch (PDOException $e) {
    // É bom logar o erro, mas evitar mostrar detalhes de conexão ao usuário final.
    error_log("FALHA NA CONEXÃO COM O BD: " . $e->getMessage());
    die("Serviço indisponível temporariamente. Tente novamente mais tarde.");
}
?>