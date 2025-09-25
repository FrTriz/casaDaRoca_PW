<?php
class Pedido {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function buscarPorCliente($id_cliente) {
        $sql = "SELECT 
                    id_pedido, 
                    data_pedido, 
                    status,
                    (SELECT SUM(quantidade * preco_unitario) FROM ItemPedido WHERE id_pedido = p.id_pedido) AS valor_total
                FROM Pedido p
                WHERE id_cliente = :id_cliente
                ORDER BY data_pedido DESC";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id_cliente', $id_cliente, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarDetalhesPorId($id_pedido) {
    $stmt = $this->pdo->prepare("SELECT * FROM Pedido WHERE id_pedido = :id");
    $stmt->bindParam(':id', $id_pedido, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function buscarItensPorPedidoId($id_pedido) {
        $sql = "SELECT i.quantidade, i.preco_unitario, p.nome, p.imagem 
                FROM ItemPedido i 
                JOIN Produto p ON i.id_produto = p.id_produto 
                WHERE i.id_pedido = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id_pedido, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>