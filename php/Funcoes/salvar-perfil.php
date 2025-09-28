<?php
require_once '../session-manager.php';
require_once '../conexao.php';
require_once '../Classes/UsuarioClass.php';
require_once '../Classes/ClienteClass.php';

if (!isset($_SESSION['usuario_id']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /login.php');
    exit();
}

$id_logado = $_SESSION['usuario_id'];

// Recolhe todos os dados do formulário
$nome = trim($_POST['nome']);
$email = trim($_POST['email']);
$rua = trim($_POST['rua']);
$numero = trim($_POST['numero']);
$cidade = trim($_POST['cidade']);
$estado = trim($_POST['estado']);
$cep = trim($_POST['cep']);
$telefone = trim($_POST['telefone']);

$usuario_obj = new Usuario($pdo);
$cliente_obj = new Cliente($pdo);

// Atualiza a tabela Cliente com todos os dados
$sucesso_cliente = $cliente_obj->atualizarDados($id_logado, $nome, $rua, $numero, $cidade, $estado, $cep, $telefone);
// Atualiza a tabela Usuario com o email
$sucesso_usuario = $usuario_obj->atualizarEmail($id_logado, $email);

if ($sucesso_cliente && $sucesso_usuario) {
    header('Location: /perfil.php?status=sucesso');
} else {
    header('Location: /perfil.php?status=erro');
}
exit();
?>