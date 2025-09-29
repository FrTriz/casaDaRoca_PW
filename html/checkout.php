<?php
require_once '../php/session-manager.php';
require_once '../php/conexao.php';
require_once '../php/Classes/CarrinhoClass.php';
require_once '../php/Classes/UsuarioClass.php'; 
require_once '../php/Classes/ClienteClass.php'; 



// Garante que o utilizador esteja logado para aceder ao checkout
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php?redirect=checkout.php');
    exit();
}

$carrinho_obj = new Carrinho($pdo);
$produtosNoCarrinho = $carrinho_obj->listarProdutos();

// Se o carrinho estiver vazio, redireciona para a página de produtos
if (count($produtosNoCarrinho) === 0) {
    header('Location: produtos.php');
    exit();
}

// Busca os dados do cliente e do utilizador para pré-preencher o formulário
$cliente_obj = new Cliente($pdo);
$usuario_obj = new Usuario($pdo);
$cliente_info = $cliente_obj->buscarPorId($_SESSION['usuario_id']);
$usuario_info = $usuario_obj->buscarPorId($_SESSION['usuario_id']);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Meu Perfil - Casa da Roça</title>
    
    <link rel="stylesheet" href="../css/style-cliente.css?v=<?php echo time(); ?>">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&family=Open+Sans&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/5eb066ef2f.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php include 'cliente-header.php'; ?>
        <section class="secao-conteudo">
            <h1 style="text-align: center;">Finalizar Compra</h1>
            <p style="text-align: center; margin-bottom: 2rem;">Preencha os seus dados para entrega e conclua o pedido.</p>

            <div class="checkout-container">
                <div class="checkout-form-col">
                    <form action="../php/Funcoes/processa-pedido.php" method="POST" id="form-checkout">
                        <h2>Dados de Entrega</h2>

                        <div class="form-group">
                            <label for="checkout-nome">Nome Completo</label>
                            <input type="text" id="checkout-nome" name="nome_completo" required value="<?php echo htmlspecialchars($cliente_info['nome'] ?? ''); ?>">
                            <span class="error-message" id="error-checkout-nome"></span>
                        </div>

                        <div class="form-group">
                            <label for="checkout-email">E-mail</label>
                            <input type="email" id="checkout-email" name="email_contato" required value="<?php echo htmlspecialchars($usuario_info['email'] ?? ''); ?>">
                            <span class="error-message" id="error-checkout-email"></span>
                        </div>
                        
                        <div class="form-group">
                            <label for="checkout-telefone">Telefone</label>
                            <input type="tel" id="checkout-telefone" name="telefone" required value="<?php echo htmlspecialchars($cliente_info['telefone'] ?? ''); ?>">
                            <span class="error-message" id="error-checkout-telefone"></span>
                        </div>
                        
                        <div class="form-group">
                            <label for="cidade">Cidade</label>
                            <input type="text" id="cidade" name="cidade" value="Feira de Santana" required readonly>
                            </div>

                        <div class="form-group">
                            <label for="rua_entrega">Rua</label>
                            <input type="text" id="rua_entrega" name="rua" required value="<?php echo htmlspecialchars($cliente_info['rua'] ?? ''); ?>">
                            <span class="error-message" id="error-checkout-rua"></span>
                        </div>

                        <label for="observacoes">Observações (opcional)</label>
                        <textarea id="observacoes" name="observacoes"></textarea>

                        <button type="submit" class="botao" style="margin-top: 1.5rem;">Finalizar Compra</button>
                    </form>
                </div>

                <div class="checkout-resumo-col">
                    <h2>Resumo do Pedido</h2>
                    <?php
                     
                        $subtotal = 0;
                        foreach ($produtosNoCarrinho as $produto) {
                            $subtotal += $produto['preco'] * $produto['quantidade'];
                        }
                        $frete = 5.00; 
                        $total_geral = $subtotal + $frete;
                    ?>
                    <div class="resumo-item">
                        <span>Subtotal:</span>
                        <span class="resumo-valor">R$ <?php echo number_format($subtotal, 2, ',', '.'); ?></span>
                    </div>
                    <div class="resumo-item">
                        <span>Frete:</span>
                        <span class="resumo-valor">R$ <?php echo number_format($frete, 2, ',', '.'); ?></span>
                    </div>
                    <div class="resumo-item total-final">
                        <span>Total:</span>
                        <span class="resumo-valor">R$ <?php echo number_format($total_geral, 2, ',', '.'); ?></span>
                    </div>
                    <div class="pagamento-info">
                        <h3>Método de Pagamento</h3>
                        <p>O pagamento será realizado na entrega via PIX ou dinheiro.</p>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <?php include 'cliente-footer.php'; ?>
    <script src="../script.js"></script>
</body>
</html>