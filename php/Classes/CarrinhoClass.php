<?php
class Carrinho {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function adicionarProduto($id_produto, $quantidade = 1) {
        if (!isset($_SESSION['carrinho'])) {
            $_SESSION['carrinho'] = [];
        }

        if (isset($_SESSION['carrinho'][$id_produto])) {
            $_SESSION['carrinho'][$id_produto] += $quantidade;
        } else {
            $_SESSION['carrinho'][$id_produto] = $quantidade;
        }
    }

    public function removerProduto($id_produto) {
        if (isset($_SESSION['carrinho'][$id_produto])) {
            unset($_SESSION['carrinho'][$id_produto]);
        }
    }

    public function atualizarQuantidade($id_produto, $quantidade) {
        if (isset($_SESSION['carrinho'][$id_produto])) {
            if ($quantidade <= 0) {
                $this->removerProduto($id_produto);
            } else {
                $_SESSION['carrinho'][$id_produto] = $quantidade;
            }
        }
    }

    public function calcularTotal() {
        $total = 0.0;
        if (isset($_SESSION['carrinho']) && count($_SESSION['carrinho']) > 0) {
            foreach ($_SESSION['carrinho'] as $id_produto => $quantidade) {
                $produto = $this->buscarProdutoPorId($id_produto);
                if ($produto) {
                    $total += $produto['preco'] * $quantidade;
                }
            }
        }
        return $total;
    }

    private function buscarProdutoPorId($id_produto) {
        $stmt = $this->pdo->prepare("SELECT * FROM produto WHERE id_produto = :id");
        $stmt->bindParam(':id', $id_produto, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>