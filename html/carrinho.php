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

    <?php
        include 'cliente-header.php';
    ?>

    <main>
        <section class="secao-conteudo">
            <h1 style="text-align: center;">Seu Carrinho</h1>
            <p class="carrinho-vazio" style="text-align: center; display: none;">Seu carrinho está vazio.</p>
            
            <div class="tabela-carrinho-container">
                <table class="tabela-carrinho">
                    <thead>
                        <tr>
                            <th>Produto</th>
                            <th>Preço</th>
                            <th>Quantidade</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><img src="../img/produto1.png" alt="Produto 1"> Nome do Produto 1</td>
                            <td>R$ 15,90</td>
                            <td>1</td>
                            <td>R$ 15,90</td>
                        </tr>
                        <tr>
                            <td><img src="../img/produto2.png" alt="Produto 2"> Nome do Produto 2</td>
                            <td>R$ 22,50</td>
                            <td>2</td>
                            <td>R$ 45,00</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="resumo-compra">
                <div class="resumo-item">
                    <span>Subtotal:</span>
                    <span class="resumo-valor">R$ 60,90</span>
                </div>
                <div class="resumo-item">
                    <span>Frete (Feira de Santana):</span>
                    <span class="resumo-valor">R$ 5,00</span>
                </div>
                <div class="resumo-item total-final">
                    <span>Total:</span>
                    <span class="resumo-valor">R$ 65,90</span>
                </div>
                <a href="checkout.html" class="botao-finalizar">Finalizar Compra</a>
            </div>
        </section>
    </main>

    <?php
        include 'cliente-footer.php';
    ?>
    <script src="../script.js"></script>
</body>
</html>