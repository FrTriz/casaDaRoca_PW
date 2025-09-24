<?php
$host = 'ep-young-unit-ac3td02j-pooler.sa-east-1.aws.neon.tech';
$dbname = 'neondb';
$user = 'neondb_owner';
$pass = 'npg_3S6uYVtveZiT';
$port = '5432';
$endpoint_id = 'ep-young-unit-ac3td02j-pooler';

$pass_com_endpoint = "endpoint=$endpoint_id;" . $pass;

$dsn = "pgsql:host=$host;port=$port;dbname=$dbname;sslmode=require";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false, 
];

try {
    $pdo = new PDO($dsn, $user, $pass_com_endpoint, $options);
} catch (PDOException $e) {
    die("FALHA NA CONEXÃO (com workaround): " . $e->getMessage());
}
?>