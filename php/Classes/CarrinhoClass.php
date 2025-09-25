<?php
class Carrinho {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function adicionarProduto($id_produto, $quantidade_a_adicionar = 1) {
    $produto_info = $this->buscarProdutoPorId($id_produto);
    if (!$produto_info) {
        // Retorna um erro se o produto não for encontrado
        return ['sucesso' => false, 'mensagem' => 'Produto não encontrado.'];
    }
    $stock_disponivel = $produto_info['estoque'];

    // Calcula a quantidade que o cliente já tem no carrinho para este item
    $quantidade_no_carrinho = 0;
    if (isset($_SESSION['carrinho'][$id_produto])) {
        $quantidade_no_carrinho = $_SESSION['carrinho'][$id_produto];
    }

    // Verifica se a quantidade total desejada excede o estoque
    if (($quantidade_no_carrinho + $quantidade_a_adicionar) > $stock_disponivel) {
        // Se exceder, não adiciona e retorna uma mensagem de erro
        return [
            'sucesso' => false, 
            'mensagem' => 'Quantidade solicitada excede o estoque disponível (' . $stock_disponivel . ' unidades).'
        ];
    }

    // Se houver estoque suficiente, adiciona o produto ao carrinho
    if (!isset($_SESSION['carrinho'])) {
        $_SESSION['carrinho'] = [];
    }
    if (isset($_SESSION['carrinho'][$id_produto])) {
        $_SESSION['carrinho'][$id_produto] += $quantidade_a_adicionar;
    } else {
        $_SESSION['carrinho'][$id_produto] = $quantidade_a_adicionar;
    }
    
    // Retorna sucesso
    return ['sucesso' => true];
}

    public function removerProduto($id_produto) {
        if (isset($_SESSION['carrinho'][$id_produto])) {
            unset($_SESSION['carrinho'][$id_produto]);
        }
    }

   public function atualizarQuantidade($id_produto, $nova_quantidade) {
    // Primeiro, verifica se o produto existe no carrinho
    if (isset($_SESSION['carrinho'][$id_produto])) {
        
        // Se a quantidade for zero ou menos, remove o produto
        if ($nova_quantidade <= 0) {
            $this->removerProduto($id_produto);
            return ['sucesso' => true]; // A remoção foi bem-sucedida
        }

        // Busca as informações do produto para verificar o stock
        $produto_info = $this->buscarProdutoPorId($id_produto);
        if (!$produto_info) {
            return ['sucesso' => false, 'mensagem' => 'Produto não encontrado.'];
        }
        $stock_disponivel = $produto_info['estoque'];

        // Verifica se a nova quantidade excede o stock
        if ($nova_quantidade > $stock_disponivel) {
            return [
                'sucesso' => false,
                'mensagem' => 'Estoque insuficiente. Apenas ' . $stock_disponivel . ' unidades disponíveis.'
            ];
        }

        // Se houver estoque suficiente, atualiza a quantidade na sessão
        $_SESSION['carrinho'][$id_produto] = $nova_quantidade;
        return ['sucesso' => true];
    }
    
    return ['sucesso' => false, 'mensagem' => 'Produto não está no carrinho.'];
    }

    public function limparCarrinho() {
        unset($_SESSION['carrinho']);
    }  

    public function listarProdutos() {
        $produtos = [];
        if (isset($_SESSION['carrinho']) && count($_SESSION['carrinho']) > 0) {
            foreach ($_SESSION['carrinho'] as $id_produto => $quantidade) {
                $produto = $this->buscarProdutoPorId($id_produto);
                if ($produto) {
                    $produto['quantidade'] = $quantidade;
                    $produtos[] = $produto;
                }
            }
        }
        return $produtos;
    }  
    private function buscarProdutoPorId($id_produto) {
        $stmt = $this->pdo->prepare("SELECT * FROM produto WHERE id_produto = :id");
        $stmt->bindParam(':id', $id_produto, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
