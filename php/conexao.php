<?php
try {
    $pdo = new PDO("pgsql:host=localhost;port=5432;dbname=TrabalhoPDS", "postgres", "172834");

} catch (PDOException $e) {
    echo "Erro ao conectar com o banco de dados: " . $e->getMessage();
    exit();
} catch (Exception $e) {
    echo "Erro genérico: " . $e->getMessage();
    exit();
}
?>