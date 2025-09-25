<?php
// Inclui os arquivos necessários
require_once '../php/conexao.php';
require_once '../php/Classes/CarrinhoClass.php';

// Garante que a sessão seja iniciada para ler os dados do carrinho
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cria uma instância da sua classe Carrinho
$carrinho = new Carrinho($pdo);
// Usa o seu método para buscar todos os produtos do carrinho de uma só vez
$produtosNoCarrinho = $carrinho->listarProdutos();

// Inicializa a variável para o cálculo do subtotal
$subtotal = 0;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho de Compras - Casa da Roça</title>
    <link rel="stylesheet" href="../css/style-cliente.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&family=Open+Sans&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/5eb066ef2f.js" crossorigin="anonymous"></script>
</head>
<body>

    <?php include 'cliente-header.php'; ?>

    <main>
        <section class="secao-conteudo">
            <h1 style="text-align: center;">Seu Carrinho</h1>
            
            <?php if (count($produtosNoCarrinho) > 0):?>
                
                <div class="tabela-carrinho-container">
                    <table class="tabela-carrinho">
                        <thead>
                            <tr>
                                <th>Produto</th>
                                <th>Preço</th>
                                <th>Quantidade</th>
                                <th>Total</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($produtosNoCarrinho as $produto):
                                $total_item = $produto['preco'] * $produto['quantidade'];
                                $subtotal += $total_item;
                                $imagemBase64 = '';
                                if (isset($produto['imagem']) && !empty($produto['imagem'])) {
                                    $imagemConteudo = is_resource($produto['imagem']) ? stream_get_contents($produto['imagem']) : $produto['imagem'];
                                    $imagemBase64 = base64_encode($imagemConteudo);
                                }
                            ?>
                                <tr>
                                    <td>
                                        <?php if ($imagemBase64): ?>
                                            <img src="data:image/jpeg;base64,<?php echo $imagemBase64; ?>" alt="<?php echo htmlspecialchars($produto['nome']); ?>">
                                        <?php endif; ?>
                                        <?php echo htmlspecialchars($produto['nome']); ?>
                                    </td>
                                    <td>R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></td>
                                    <td>
                                        <form action="../php/Funcoes/atualizar-carrinho.php" method="POST" class="form-quantidade">
                                            <input type="hidden" name="id_produto" value="<?php echo $produto['id_produto']; ?>">
                                            <input type="number" name="quantidade" value="<?php echo $produto['quantidade']; ?>" min="1" class="input-quantidade">
                                            <button type="submit" class="botao-atualizar">Atualizar</button>
                                        </form>
                                    </td>
                                    <td>R$ <?php echo number_format($total_item, 2, ',', '.'); ?></td>
                                    <td>
                                        <a href="../php/Funcoes/remover-item-carrinho.php?id=<?php echo $produto['id_produto']; ?>" class="link-remover" title="Remover item">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="resumo-compra">
                    <?php
                        $frete = 5.00;
                        $total_geral = $subtotal + $frete;
                    ?>
                    <div class="resumo-item">
                        <span>Subtotal:</span>
                        <span id="subtotal-carrinho" class="resumo-valor">R$ <?php echo number_format($subtotal, 2, ',', '.'); ?></span>
                    </div>
                    <div class="resumo-item">
                        <span>Frete (Feira de Santana):</span>
                        <span class="resumo-valor">R$ <?php echo number_format($frete, 2, ',', '.'); ?></span>
                    </div>
                    <div class="resumo-item total-final">
                        <span>Total:</span>
                        <span id="total-carrinho" class="resumo-valor">R$ <?php echo number_format($total_geral, 2, ',', '.'); ?></span>
                    </div>
                    <a href="checkout.php" class="botao-finalizar">Finalizar Compra</a>
                </div>

            <?php else: // Se o carrinho estiver vazio ?>
                <p style="text-align: center;">Seu carrinho está vazio.</p>
            <?php endif; ?>

        </section>
    </main>

    <?php include 'cliente-footer.php'; ?>
    <script src="../script.js"></script>
    <?php
    
    if (isset($_GET['status'])) {
        $status = $_GET['status'];
        $mensagem = isset($_GET['msg']) ? addslashes(htmlspecialchars($_GET['msg'])) : ''; 

        if ($status === 'update-sucesso') {
            echo "<script>alert('Quantidade atualizada com sucesso!');</script>";
        } elseif ($status === 'erro-stock') {
            echo "<script>alert('Erro: " . $mensagem . "');</script>";
        }
    }
    ?>
</body>
</html>
