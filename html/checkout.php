<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finalizar Compra - Casa da Roça</title>
    <link rel="stylesheet" href="../css/style-cliente.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&family=Open+Sans&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/5eb066ef2f.js" crossorigin="anonymous"></script>
    </head>
<body>

    <?php
        include 'cliente-header.php';
    ?>

    <main>
        <section class="secao-conteudo">
            <h1 style="text-align: center;">Finalizar Compra</h1>
            <p style="text-align: center; margin-bottom: 2rem;">Preencha seus dados para entrega e conclua o pedido.</p>

            <div class="checkout-container">
                <div class="checkout-form-col">
                    <form action="checkout.php" method="POST">
                        <h2>Dados de Entrega</h2>
                        <label for="nome">Nome Completo</label>
                        <input type="text" id="nome" name="nome" required>

                        <label for="email">E-mail</label>
                        <input type="email" id="email" name="email" required>
                        
                        <label for="telefone">Telefone</label>
                        <input type="tel" id="telefone" name="telefone" required>
                        
                        <label for="endereco">Endereço</label>
                        <input type="text" id="endereco" name="endereco" required>
                        
                        <label for="cidade">Cidade</label>
                        <input type="text" id="cidade" name="cidade" value="Feira de Santana" required readonly>

                        <label for="observacoes">Observações (opcional)</label>
                        <textarea id="observacoes" name="observacoes"></textarea>
                    
                        <button type="submit" class="botao" style="margin-top: 1.5rem;">Finalizar Compra</button>
                    </form>
                </div>

                <div class="checkout-resumo-col">
                    <h2>Resumo do Pedido</h2>
                    <div class="resumo-item">
                        <span>Subtotal:</span>
                        <span class="resumo-valor">R$ 60,90</span>
                    </div>
                    <div class="resumo-item">
                        <span>Frete:</span>
                        <span class="resumo-valor">R$ 5,00</span>
                    </div>
                    <div class="resumo-item total-final">
                        <span>Total:</span>
                        <span class="resumo-valor">R$ 65,90</span>
                    </div>
                    <div class="pagamento-info">
                        <h3>Método de Pagamento</h3>
                        <p>O pagamento será realizado na entrega via PIX ou dinheiro. Você receberá as instruções por e-mail.</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php
        include 'cliente-footer.php';
    ?>

    <script src="../script.js"></script>
</body>
</html>