<?php
require_once '../session-manager.php';
require_once '../conexao.php';
require_once '../Classes/CarrinhoClass.php';

if (!isset($_SESSION['usuario_id']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /login.php');
    exit();
}

$carrinho = new Carrinho($pdo);
$produtosNoCarrinho = $carrinho->listarProdutos();

if (count($produtosNoCarrinho) === 0) {
    header('Location: /produtos.php');
    exit();
}

// Recolha dos dados do formulário
$nome_completo = trim($_POST['nome_completo']);
$email_contato = trim($_POST['email_contato']);
$telefone = trim($_POST['telefone']);
$cidade = trim($_POST['cidade']);
$rua = trim($_POST['rua']);
$numero = trim($_POST['numero']);
$cep = trim($_POST['cep']);
$observacoes = trim($_POST['observacoes']) ?: null;

try {
    $pdo->beginTransaction();

    // Insere os dados principais na tabela 'Pedido'
    $sql_pedido = "INSERT INTO Pedido 
        (id_cliente, data_pedido, status, nome_completo, email_contato, telefone, cidade, rua, numero, cep, observacoes) 
        VALUES (?, NOW(), 'pendente', ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt_pedido = $pdo->prepare($sql_pedido);
    $stmt_pedido->execute([
        $_SESSION['usuario_id'], $nome_completo, $email_contato, $telefone, 
        $cidade, $rua, $numero, $cep, $observacoes
    ]);
    
    $id_pedido_criado = $pdo->lastInsertId();

    // Insere cada item do carrinho na tabela 'ItemPedido'
    $sql_item = "INSERT INTO ItemPedido 
        (id_pedido, id_produto, quantidade, preco_unitario, nome_produto, preco_produto) 
        VALUES (?, ?, ?, ?, ?, ?)";
    $stmt_item = $pdo->prepare($sql_item);

    foreach ($produtosNoCarrinho as $produto) {
        $stmt_item->execute([
            $id_pedido_criado,
            $produto['id_produto'],
            $produto['quantidade'],
            $produto['preco'],
            $produto['nome'],      
            $produto['preco']     
        ]);
    }


    $pdo->commit();

    $carrinho->limparCarrinho();

    header('Location: /checkout-sucesso.php?pedido=' . $id_pedido_criado);
    exit();

} catch (Exception $e) {
    $pdo->rollBack();
    error_log("Erro ao processar pedido: " . $e->getMessage());
    header('Location: /checkout.php?status=erro');
    exit();
}
?>