<?php
// CRÍTICO: Lê a string de conexão completa (DSN) da Variável de Ambiente configurada no Render.
// Essa variável (DB_DSN) contém o endereço, usuário e senha do seu banco Neon.
$dsn = getenv('DB_DSN'); 

if (!$dsn) {
    // Retorna um erro fatal se a variável de ambiente não for encontrada no servidor.
    die("ERRO FATAL: Variável de ambiente DB_DSN não configurada no Render. Verifique o painel de variáveis.");
}

// Configurações padrão para o PDO
$options = [
    PDO::ATTR_ERRMODE              => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES     => false,
];

try {
    // Usamos 'null' para usuário e senha porque o DSN (string de conexão)
    // já contém essas informações (padrão Neon/Render).
    $pdo = new PDO($dsn, null, null, $options);
} catch (PDOException $e) {
    // Exibe a mensagem de falha, útil para depuração no Render.
    die("FALHA NA CONEXÃO com PostgreSQL: " . $e->getMessage());
}
?>