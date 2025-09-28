<?php

// 1. Lendo as Variáveis de Ambiente do Servidor (Render)
// Usamos o if/empty para garantir que o PHP não se confunda ao iniciar.
$host = getenv('DB_HOST');
if (empty($host)) { $host = 'seu_host_local'; }

$dbname = getenv('DB_NAME');
if (empty($dbname)) { $dbname = 'seu_db_local'; }

$user = getenv('DB_USER');
if (empty($user)) { $user = 'seu_user_local'; }

$pass = getenv('DB_PASSWORD');
if (empty($pass)) { $pass = 'sua_senha_local'; }

$port = getenv('DB_PORT');
if (empty($port)) { $port = '5432'; }

// O endpoint_id não é mais usado na senha, mas mantemos a variável por segurança.
$endpoint_id = getenv('DB_ENDPOINT_ID');


// 2. Montando a String DSN (Data Source Name)
// Removemos o 'sslmode=require' para o teste. Se o Neon exige, pode ser que
// o contêiner Docker não encontre os certificados.
$dsn = "pgsql:host=$host;port=$port;dbname=$dbname";

$options = [
    // Se ainda der erro de constante, o Dockerfile está falhando em carregar o PDO.
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false, 
];

try {
    // Usamos a senha pura ($pass), sem o workaround do endpoint.
    $pdo = new PDO($dsn, $user, $pass, $options); 
} catch (PDOException $e) {
    // Registra o erro no log do Render
    error_log("FALHA CRÍTICA NA CONEXÃO COM O BD: " . $e->getMessage());
    // Mostra a mensagem amigável ao usuário
    http_response_code(503);
    die("Serviço indisponível temporariamente. Tente novamente mais tarde.");
}
?>